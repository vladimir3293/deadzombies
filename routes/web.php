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

//TODO admin one group
//Route::middleware(['auth'])->group(function () {

//admin index
Route::get('/admin/', ['uses' => 'Admin\IndexController@getIndex', 'as' => 'admin']);
//admin category
Route::get('/admin/category/{Category}', 'Admin\CategoryController@getCategory')->name('admin.getCat');
Route::put('/admin/category/{Category}', 'Admin\CategoryController@putCategory');
Route::delete('/admin/category/{Category}', 'Admin\CategoryController@deleteCategory');
//admin game
Route::get('/admin/game/{Game}', 'Admin\GameController@getGame')->name('admin.getGame');
Route::put('/admin/game/{Game}', 'Admin\GameController@putGame');
Route::get('/admin/game/{game}', [
    'uses' => 'Admin\GameController@getIndex',
    'as' => 'admin.getGame']);
Route::delete('/admin/game/{Game}', 'Admin\GameController@deleteGame');
//admin parser
Route::get('/admin/parser', 'Admin\ParseController@getParser')->name('admin.getParser');


//index
Route::get('/', ['uses' => 'IndexController@getIndex', 'as' => 'index']);
//index category
Route::get('/{Category}', 'CategoryController@getCategory')->name('getCat');
//index game
Route::get('/{Category}/{Game}', 'GameController@getGame')->name('getGame');


//authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//Auth::routes();