<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Category;
use App\Helper\GalleryHelper;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private $helper; 

    public function __construct()
    {
        $this->helper = new GalleryHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->helper->List();
        return view('gallery.list', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Gallery();
        return view('gallery.detail', ['item' => $item, 'mode' => 'new']);
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

        $gallery = (new Gallery)->forceFill($input);

        $item = $this->helper->Save($gallery);
        return $item;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->helper->Get($id);
        //$category = Category::select("id,name")->get();
        $category = Category::select('id','name')->get();
        // return $item;
        return view('gallery.detail', ['item' => $item, 'mode' => 'view', 'category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->helper->Get($id);
        return view('gallery.detail', ['item' => $item, 'mode' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate_request($request);
        $input = $request->only(['name', 'description', 'visibility']);

        $gallery = (new Gallery)->forceFill($this->helper->Get($id));
        $gallery->forceFill($input);

        $item = $this->helper->Save($gallery);
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->helper->Delete($id);
        return null;
    }

    private function validate_request(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'visibility' => ['required']
        ]);
    }
}
