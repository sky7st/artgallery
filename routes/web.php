<?php
use App\Http\Middleware\EnquiryAccess;
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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/artist', 'ArtistController@index')->name('pages.artist.index');
Route::get('/artist/{id}', 'ArtistController@show')->name('pages.artist.show');
Route::get('/artist/{id}/delete', 'ArtistController@destroy')->middleware('can:update artist data');
Route::post('/artist/insert', "ArtistController@create");
Route::post('/artist/{id}/update', "ArtistController@edit")->name('pages.artist.update')->middleware('can:update artist data');

Route::get('/work/{id}', 'WorkController@show');
Route::post('/work/insert', "WorkController@create")->middleware("can:add new work");
Route::get('/work/{id}/delete', "WorkController@destroy")->middleware("can:delete work");



Route::get('/enquiry', 'EnquiryController@index')->name('pages.enquiry.index')->middleware([EnquiryAccess::class]);
Route::get('/enquiry/{work}/{user}', 'EnquiryController@show')->name('pages.enquiry.show')->middleware([EnquiryAccess::class]);
Route::post('/enquiry/{work}/{user}/make', 'EnquiryController@create')->middleware("can:send enquiry");

Route::post('/trade/make', 'TradeController@create')->middleware("can:make trade");
Route::post('/trade/confirm', 'TradeController@edit')->middleware("can:confirm trade");
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
