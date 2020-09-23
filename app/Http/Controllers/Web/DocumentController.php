<?php

namespace App\Http\Controllers\Web;

use App\Models\Document;
use App\Models\Category;
use App\Helper\DocumentHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    private $helper; 

    public function __construct()
    {
        $this->helper = new DocumentHelper();
    }

    private function validate_request(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'visibility' => ['required'],
            'gallery_id' => ['required']
        ]);
    }

    public function types()
    {
    	return array_keys(DocumentHelper::$document_mapper);
    }

    public function list(Request $request,$type=null) 
    {
        $list = $this->helper->List($type);
        $category = Category::select('id','name')->get();

        // return $list;
        if(is_null($type)) $type = "All Files";
        else $type = Str::ucfirst(Str::lower($type))."s";
        return view('documents.list', ['list' => $list, 'type' => $type, 'category' => $category]);
        // return view('documents.list', ['list' => $list['data'], 'type' => $type, 'data' => $list]);
    }

    public function category(Request $request,$category=null) 
    {
        $list = $this->helper->Category($category);

        // return $list;
        if(is_null($category)) $category = "All Files";
        else $category = Str::ucfirst(Str::lower($category))."s";
        return view('documents.list', ['list' => $list, 'type' => $category]);
        // return view('documents.list', ['list' => $list['data'], 'type' => $type, 'data' => $list]);
    }

    public function show($id) 
    {
    	$item = $this->helper->Get($id);

        $type = $item['attributes_type'];
        return view('documents.detail', ['item' => $item, 'mode' => 'view', 'type' => $type]);
    }

    public function store(Request $request)
    {
        $this->validate_request($request);
        $input = $request->only(['name', 'description', 'visibility','file','license','type','gallery_id','category']);

        $document = (new Document)->forceFill($input);
        $datasource = $request->datasource;

        $item = $this->helper->Save($document,$request->file('file'),$datasource);
        return $item;
    }

    public function search(Request $request)
    {
        $category = Category::select('id','name')->get();
    	$keyword = (is_null($request->q)) ? '' : $request->q;
    	$list = $this->helper->Search($keyword);

    	$type = "Search";
        return view('documents.search', ['list' => $list, 'type' => $type, 'key' => $keyword, 'category' => $category]);

    	// return $list;
    }

    public function recent(Request $request)
    {
    	$list = $this->helper->Recent();

        return view('home', ['list' => $list]);
    }
}
