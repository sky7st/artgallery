<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artist', 'ArtistController@index')->name('pages.artist.index');
Route::get('/artist/{id}', 'ArtistController@show')->name('pages.artist.show');
Route::get('/artist/{id}/delete', 'ArtistController@destroy');


Route::get('/artist/insert', "ArtistController@insertIndex");
Route::post('/artist/insert', "ArtistController@insert");

Route::get('/artist/update', "ArtistController@updateIndex");
Route::post('/artist/{id}/update', "ArtistController@update");





