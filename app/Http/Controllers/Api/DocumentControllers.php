<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Image;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Map;
use App\Models\Category;
use App\Helper\DocumentHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use wapmorgan\MediaFile\MediaFile;

class DocumentControllers extends Controller
{
    public function index()
    {
        $data = $this->ConnectData();

        // return response()->json( count($data) );
        return response()->json($data->sortByDesc('updated_at')->sortByDesc('origin_id'));
    }

    public function list($type)
    {
        if(is_null($type)) return $this->index();

        $type = Str::ucfirst(Str::lower($type));

        $data = $this->ConnectData(null,'attributes_type = ?',[$type]);

        // return response()->json( count($data) );
        return response()->json($data->sortByDesc('updated_at')->sortByDesc('origin_id'));
    }

    public function store(Request $request)
    {
        $this->validate_request($request);

        try {
            \DB::beginTransaction();

            $file = $request->file('file');
            $filename = $file->getClientOriginalName();

            $input = $request->only(['name', 'description', 'visibility','license','gallery_id']);
            $input["user_id"] = $this->get_current_user_id($request);
            $input["filename"] = $filename;
            $input["fileformat"] = $file->getMimeType();
            $input["category"] = 1;
            $input["filesize"] = $file->getSize();
            $input["uploaded_date"] = date("Y-m-d H:i:s");

            //Create new document object and save to database
            $document = (new Document)->forceFill($input);
            $document->save();

            //save file to repository folder
            $path = 'doc_repository/'.$document->gallery_id.'/';
            $file->move($path, $filename);
            $datasource = $request->datasource;

            //process document attributes
            switch(Str::lower($request->type)) {
                case 'image':
                    $this->SaveImage($document,$path,$filename);
                    break;
                case 'audio':
                    $this->SaveAudio($document,$path,$filename);
                    break;
                case 'video':
                    $this->SaveVideo($document,$path,$filename);
                    break;
                case 'map':
                    $this->SaveMap($document,$datasource);
                    break;
            }

            \DB::commit();
            return response()->json($document, 201);

        } catch (Throwable $e) {
            \DB::rollback();

            $response = [
                'message' => 'Something wrong while uploading documents. Please see error log for detail',
                'errors' => 'Failed to upload file!'
            ];

            return response()->json($response,400)->send();
        }
    }

    private function LinkAttribute($attr,$doc)
    {
        $attr->save();
        $attr->document()->save($doc);
    }

    private function SaveImage($document,$path,$filename) 
    {
        list($width, $height) = getimagesize($path.$filename);
        $img = new Image();
        $img->height = $height;
        $img->width = $width;
        $img->is_portrait = ($height > $width) ? 1 : 0;
        $this->LinkAttribute($img,$document);
    }

    private function SaveAudio($document,$path,$filename)
    {
        $media = MediaFile::open($path.$filename);
        $data = $media->getAudio();

        $audio = new Audio();
        $audio->duration = $data->getLength();
        $this->LinkAttribute($audio,$document);
    }

    private function SaveVideo($document,$path,$filename)
    {
        // $media = MediaFile::open($path.$filename);
        // $data = $media->getVideo();

        $getID3 = new \getID3;
        $file_info = $getID3->analyze($path.$filename);

        $video = new Video();
        $video->height = (isset($file_info['video']['resolution_y'])) ? $file_info['video']['resolution_y'] : 0;
        $video->width = (isset($file_info['video']['resolution_x'])) ? $file_info['video']['resolution_x'] : 0;
        $video->duration = (isset($file_info['playtime_seconds'])) ? (int)$file_info['playtime_seconds'] : 0;
        $this->LinkAttribute($video,$document);
    }

    private function SaveMap($document,$datasource)
    {
        $map = new Map();
        $map->datasource = $datasource;
        $this->LinkAttribute($map,$document);
    }

    public function show($id)
    {
        $document = $this->get($id); //->load('gallery:id,name','attributes');
        return response()->json($document, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate_request($request);

        $document = $this->get($id);

        $this->validate_owner($request, $document);

        $input = $request->only(['name', 'description', 'visibility']);
        $document->forceFill($input)->save();

        return response()->json($document, 200);
    }

    public function destroy(Request $request, $id)
    {
        $document = $this->get($id);

        $this->validate_owner($request, $document);

        $document->delete();

        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $key = (is_null($request->key)) ? '' : $request->key;

        if($key=='') return [];

        $whereField = 'name like ? or filename like ? or description like ?';
        $whereValue = ['%'.$key.'%','%'.$key.'%','%'.$key.'%','%'.$key.'%'];
        $data = $this->ConnectData(null,$whereField,$whereValue);

        return response()->json($data->sortByDesc('updated_at')->sortByDesc('id'));
    }

    public function recent()
    {
        $recent = $this->ConnectData('CN1',null,null)->sortByDesc('created_at')->sortByDesc('origin_id')->take(5);

        return response()->json($recent);
    }

    public function category($category)
    {
        $category = Str::ucfirst(Str::lower($category));
        $cat = Category::where('name',$category)->first();

        if(!$cat) {
            $response = [
                'message' => 'Category '.$category.' cannot be found in database!',
                'errors' => 'Invalid Category!'
            ];

            return response()->json($response,404)->send();
        }

        $data = $this->ConnectData(null,'category = ?',[$cat['id']]);

        return response()->json($data->sortByDesc('updated_at')->sortByDesc('origin_id'));
    }


    private function validate_request(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'visibility' => ['required']
        ]);
    }

    private function get_current_user_id(Request $request)
    {
        return 1;
    }

    private function validate_owner(Request $request, $document)
    {
        $current_user_id = $this->get_current_user_id($request);

        if($document->user_id != $current_user_id)
        {
            $response = [
                'message' => 'User is not the owner of current document',
                'errors' => 'Invalid user!'
            ];

            return response()->json($response,404)->send();
        }
    }

    private function ConnectData($code=null,$wherefield=null,$wherevalue=null)
    {
        $source = \Config::get('datasource.collections');
        $data = null;

        if(is_null($code))
        {
            foreach($source as $src)
            {
                $tmp = $this->GetData($src,$wherefield,$wherevalue);

                if(is_null($data)) $data = $tmp;
                else $data = $data->merge($tmp);
            }
        }
        else 
        {
            $key = array_search($code, array_column($source, 'id'));
            $src = $source[$key];

            $data = $this->GetData($src,$wherefield,$wherevalue);
        }

        return $data;
    }

    private function GetData($src,$wherefield,$wherevalue)
    {
        $cn = $src['connection'];
        $db = $src['database'];
        $tb = $src['table'];
        $q = $src['select'];

        $subQuery = \DB::connection($cn)->table($tb)->selectRaw($q);
        $tmp = \DB::connection($cn)->query()->from(\DB::raw('('. $subQuery->toSql() . ') AS subquery'));
        if(!is_null($wherefield)) $tmp = $tmp->whereRaw($wherefield, $wherevalue);

        return $tmp->get();
    }

    private function get($id)
    {
        // $document = Document::find($id);

        $cd = explode('|',$id);
        $document = null;

        if(count($cd) == 2) {
            $document = $this->ConnectData($cd[0],'id = ?',[$id])->first();
        }

        if(is_null($document))
        {
            $response = [
                'message' => 'Document with ID '.$id.' cannot be found in database!',
                'errors' => 'Invalid Document ID!'
            ];

            return response()->json($response,404)->send();
        }

        return $document;
    }

    
}
