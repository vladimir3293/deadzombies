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

//admin category pages

//get category
Route::get('/admin/category/{Category}', 'Admin\CategoryController@getCategory')->name('admin.getCategory');
//put category
Route::put('/admin/category/{Category}', 'Admin\CategoryController@putCategory');
//delete category
Route::delete('/admin/category/{Category}', 'Admin\CategoryController@deleteCategory');
//post category
Route::post('/admin/category/', 'Admin\CategoryController@postCategory');
//page create category
Route::get('/admin/createcategory', 'Admin\CategoryController@createCategory')->name('admin.createСategory');
//add category tag
Route::post('/admin/category/tag/{Category}', 'Admin\CategoryController@postCategoryTag');
//delete game tag
Route::delete('/admin/category/tag/{Category}', 'Admin\CategoryController@deleteCategoryTag');


//admin game pages

//get game
Route::get('/admin/game/{Game}', 'Admin\GameController@getGame')->name('admin.getGame');
//put game
Route::put('/admin/game/{Game}', 'Admin\GameController@putGame');
//create game
Route::post('/admin/game/', 'Admin\GameController@postGame');
//delete game
Route::delete('/admin/game/{Game}', 'Admin\GameController@deleteGame');
//page create game
Route::get('/admin/creategame', 'Admin\GameController@createGame')->name('admin.createGame');
//delete game tag
Route::delete('/admin/game/tag/{Game}', 'Admin\GameController@deleteGameTag');
//add game tag
Route::post('/admin/game/tag/{Game}', 'Admin\GameController@postGameTag');
//page unpublished games
Route::get('/admin/unpublished', 'Admin\GameController@getUnpublished')->name('admin.getUnpublished');
//page published games
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
//add tag to tag
Route::post('/admin/tag/subtag/{Tag}', 'Admin\TagController@addTag');
//delete sub tag from tag
Route::delete('/admin/tag/subtag/{Tag}', 'Admin\TagController@removeTag');


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