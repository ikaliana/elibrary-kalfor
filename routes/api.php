<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/gallery', 'Api\GalleryController@index');
Route::get('/gallery/{id}', 'Api\GalleryController@show');
Route::post('/gallery', 'Api\GalleryController@store');
Route::put('/gallery/{id}', 'Api\GalleryController@update');
Route::delete('/gallery/{id}', 'Api\GalleryController@destroy');

Route::get('/document/all', 'Api\DocumentControllers@index');
Route::get('/document/search', 'Api\DocumentControllers@search');
Route::get('/document/recent', 'Api\DocumentControllers@recent');
// Route::get('/document/check', 'Api\DocumentControllers@check');
Route::get('/document/list/{type}', 'Api\DocumentControllers@list');
Route::get('/document/category/{category}', 'Api\DocumentControllers@category');
Route::get('/document/{id}', 'Api\DocumentControllers@show');
Route::post('/document', 'Api\DocumentControllers@store');
