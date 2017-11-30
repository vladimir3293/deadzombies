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

Route::get('/', 'IndexController@getIndex');


//todo admin one grpup
//Route::middleware(['auth'])->group(function () {
//admin
    Route::get('/admin/', ['uses' => 'Admin\IndexController@getIndex', 'as' => 'admin']);
    Route::get('/admin/category/{Category}', 'Admin\CategoryController@getCategory')->name('admin.getCat');
    Route::put('/admin/category/{Category}', 'Admin\CategoryController@putCategory');
//Route::post('/admin/category/{Category}', 'Admin\CategoryController@deleteCategory');
    Route::delete('/admin/category/{Category}', 'Admin\CategoryController@deleteCategory');
    // wtf
    Route::get('/admin/game/{Game}', 'Admin\GameController@getGame')->name('admin.getGame');
    Route::put('/admin/game/{Game}', 'Admin\GameController@putGame');
    Route::get('/admin/game/{game}', [
        'uses' => 'Admin\GameController@getIndex',
        'as' => 'admin.getGame']);
    Route::delete('/admin/game/{Game}','Admin\GameController@deleteGame');

//home
Route::get('/', ['uses' => 'IndexController@getIndex', 'as' => 'index']);
Route::get('/category/{Category}', 'CategoryController@getCategory')->name('getCat');
Route::get('/{Category}/{Game}', 'GameController@getGame')->name('getGame');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//Auth::routes();