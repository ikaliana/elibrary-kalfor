<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $galleries = Gallery::with(['documents' => function ($query) {
        //                 $query->orderBy("updated_at", 'desc')->orderBy("id", 'desc');
        //             }])->orderBy("updated_at", 'desc')->orderBy("id", 'desc')->get();

        // return $galleries;
        return response()->json(Gallery::all()->sortByDesc("updated_at")->sortByDesc("id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate_request($request);

        $input = $request->only(['name', 'description', 'visibility']);
        $input["user_id"] = $this->get_current_user_id($request);

        //$gallery = new Gallery($input);
        $gallery = (new Gallery)->forceFill($input);

        $gallery->save();

        return response()->json($gallery, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = $this->get($id)
                    ->load([
                        'documents' => function ($query) {
                                        $query->with('attributes')->orderBy("updated_at", 'desc')->orderBy("id", 'desc');
                                    }
                        ]);

        return response()->json($gallery, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate_request($request);

        $gallery = $this->get($id);

        $this->validate_owner($request, $gallery);

        $input = $request->only(['name', 'description', 'visibility']);
        $gallery->forceFill($input)->save();

        return response()->json($gallery, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $gallery = $this->get($id);

        $this->validate_owner($request, $gallery);

        try {
            \DB::beginTransaction();

            $gallery->documents()->delete();
            $gallery->delete();

            \DB::commit();
            return response()->json(null, 204);

        } catch (Throwable $e) {
            \DB::rollback();

            $response = [
                'message' => 'Something wrong while deleting gallery. Please see error log for detail',
                'errors' => 'Failed to delete galery and its documents!'
            ];

            return response()->json($response,400)->send();
        }

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
        $user_info = $this->Userinfo($request);

        return $user_info["id"];
    }

    private function validate_owner(Request $request, $gallery)
    {
        $current_user_id = $this->get_current_user_id($request);

        if($gallery->user_id != $current_user_id)
        {
            $response = [
                'message' => 'User is not the owner of current gallery',
                'errors' => 'Invalid user!'
            ];

            return response()->json($response,404)->send();
        }
    }

    private function get($id)
    {
        $gallery = Gallery::find($id);

        if(is_null($gallery))
        {
            $response = [
                'message' => 'Gallery with ID '.$id.' cannot be found in database!',
                'errors' => 'Invalid Gallery ID!'
            ];

            return response()->json($response,404)->send();
        }

        return $gallery;
    }

    protected function InitClient() {
        return new Client([
            'verify' => false,
            'curl' => [
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER => false
            ]
        ]);
    }

    protected function OpenRequest($method, $url, $params) {
        $client = $this->InitClient();

        try {
            $response = $client->request($method, $url, $params);
            return $response;
        } catch (RequestException $e) {
            if($e->getCode() == 401) return $e->getResponse();
            else abort($e->getCode(), $e->getResponse()->getBody());
        }
    }

    protected function Userinfo(Request $request) {
        $response = $this->OpenRequest('GET',env('SSO_SERVER_URL').'api/user', 
            ['headers' => [
                'Authorization' => 'Bearer '.$request->bearerToken(),
                'Accept' => 'application/json',
                ]
            ]);

        $statusCode = $response->getStatusCode();

        if($statusCode == '200') 
            return json_decode((string) $response->getBody(), true);
        else 
            abort($statusCode, $response->getBody());
    }

}
