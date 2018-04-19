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

//admin pages

//admin index
Route::get('/admin/', ['uses' => 'Admin\IndexController@getIndex', 'as' => 'admin']);
//admin category
Route::get('/admin/category/{Category}', 'Admin\CategoryController@getCategory')->name('admin.getCat');
Route::put('/admin/category/{Category}', 'Admin\CategoryController@putCategory');
Route::delete('/admin/category/{Category}', 'Admin\CategoryController@deleteCategory');

//admin game pages

Route::get('/admin/game/{Game}', 'Admin\GameController@getGame')->name('admin.getGame');
Route::put('/admin/game/{Game}', 'Admin\GameController@putGame');
Route::post('/admin/game/', 'Admin\GameController@postGame');
Route::get('/admin/game/{game}', [
    'uses' => 'Admin\GameController@getIndex',
    'as' => 'admin.getGame']);
//create game page
Route::get('/admin/creategame', 'Admin\GameController@createGame')->name('admin.createGame');
//create category
Route::get('/admin/createcategory', 'Admin\CategoryController@createCategory')->name('admin.createСategory');
//delete game
Route::delete('/admin/game/{Game}', 'Admin\GameController@deleteGame');
//delete game tag
Route::delete('/admin/game/tag/{Game}', 'Admin\GameController@deleteGameTag');
//create game tag
Route::post('/admin/game/tag/{Game}', 'Admin\GameController@postGameTag');
//unpublished games
Route::get('/admin/unpublished', 'Admin\GameController@getUnpublished')->name('admin.getUnpublished');
//published games
Route::get('/admin/published', 'Admin\GameController@getPublished')->name('admin.getPublished');

//admin tag pages

//get tags page
Route::get('/admin/tags', 'Admin\TagController@getTags')->name('admin.getTags');
//get one tag page
Route::get('/admin/tag/{Tag}', 'Admin\TagController@getTag')->name('admin.getTag');
//put tag
Route::put('/admin/tag/{Tag}', 'Admin\TagController@putTag');
//delete tag
Route::delete('/admin/tag/{Tag}', 'Admin\TagController@deleteTag');
//create tag
Route::post('/admin/tag/', 'Admin\TagController@postTag');

//parser pages

//admin parser
Route::get('/admin/parser', 'Admin\ParseController@getParser')->name('admin.getParser');
Route::post('/admin/parser', 'Admin\ParseController@postGameDist')->name('admin.getParser');





//index
Route::get('/', ['uses' => 'IndexController@getIndex', 'as' => 'index']);
//index category
Route::get('/{Category}', 'CategoryController@getCategory')->name('getCat');
//index game
Route::get('/game/{game}', 'GameController@getGame')->name('getGame');


//authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//Auth::routes();