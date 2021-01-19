<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// })->name('home');

// Route::get('/gallery', 'Web\GalleryController@index')->name('gallery');
// Route::get('/gallery/{id}', 'Web\GalleryController@get')->name('gallery_detail');

Route::resource('gallery', 'Web\GalleryController');

Route::get('documents/all/{type?}', 'Web\DocumentController@list')->name('documents.list');
Route::get('documents/category/{category?}', 'Web\DocumentController@category')->name('documents.category');
Route::get('documents/show/{id}', 'Web\DocumentController@show')->name('documents.show');
Route::get('documents/types', 'Web\DocumentController@types')->name('documents.types');
Route::post('documents/save', 'Web\DocumentController@store')->name('documents.save');
Route::get('documents/search', 'Web\DocumentController@search')->name('documents.search');

Route::get('login', 'SsoController@Login')->name('login');
Route::get('logout', 'SsoController@Logout')->name('logout');
Route::get('callback', 'SsoController@Callback');
// Route::get('/me', 'SsoController@GetUserInfo');

Route::get('/', 'Web\DocumentController@recent')->name('home');
