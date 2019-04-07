<?php
//TODO admin one group
//Route::middleware(['auth'])->group(function () {

/***** INDEX PAGES *****/

Route::get('/', ['uses' => 'IndexController@getIndex', 'as' => 'index']);
//index category
Route::get('/category/{category}', 'CategoryController@getCategory')->name('getCategory');
//index game
Route::get('/game/{gameIndex}', 'GameController@getGame')->name('getGame');
//index tag
Route::get('/tag/{tag}', 'TagController@getTag')->name('getTag');

/***** ADMIN PAGES *****/

Route::middleware(['auth', 'can:isAdmin'])->group(function () {
//admin index
    Route::get('/admin/', ['uses' => 'Admin\IndexController@getIndex', 'as' => 'admin']);

//admin pages
    Route::get('/admin/pages/all', 'Admin\PagesController@getAll')->name('admin.pages.getAll');
    Route::get('/admin/pages/{page}', 'Admin\PagesController@getPage')->name('admin.pages.getPage');

//admin images
    Route::post('/admin/images/', 'Admin\ImagesController@addImage')->name('admin.images.addImg');

//admin category pages
//page get all categories
    Route::get('/admin/category/all', 'Admin\CategoryController@getAll')->name('admin.category.getAll');
//page create category
    Route::get('/admin/category/create', 'Admin\CategoryController@createCategory')->name('admin.category.create');
//page unpublished games
    Route::get('/admin/category/unpublished', 'Admin\CategoryController@getUnpublished')->name('admin.category.getUnpublished');
//page published games
    Route::get('/admin/category/published', 'Admin\CategoryController@getPublished')->name('admin.category.getPublished');
//page one get category
    Route::get('/admin/category/{category}', 'Admin\CategoryController@getCategory')->name('admin.getCategory');
//put category
    Route::put('/admin/category/{category}', 'Admin\CategoryController@putCategory');
//delete category
    Route::delete('/admin/category/{category}', 'Admin\CategoryController@deleteCategory');
//post category
    Route::post('/admin/category/', 'Admin\CategoryController@postCategory');
//add category tag
    Route::post('/admin/category/tag/{Category}', 'Admin\CategoryController@postCategoryTag');
//delete game tag
    Route::delete('/admin/category/tag/{Category}', 'Admin\CategoryController@deleteCategoryTag');

//admin game pages

//page get all games
    Route::get('/admin/game/all', 'Admin\GameController@getAll')->name('admin.game.getAll');
//page create game
    Route::get('/admin/game/create', 'Admin\GameController@createGame')->name('admin.game.create');
//page unpublished games
    Route::get('/admin/game/unpublished', 'Admin\GameController@getUnpublished')->name('admin.game.getUnpublished');
//page published games
    Route::get('/admin/game/published', 'Admin\GameController@getPublished')->name('admin.game.getPublished');
//page get one game
    Route::get('/admin/game/{Game}', 'Admin\GameController@getGame')->name('admin.getGame');
//put game
    Route::put('/admin/game/{Game}', 'Admin\GameController@putGame');
//create game
    Route::post('/admin/game/', 'Admin\GameController@postGame');
//delete game
    Route::delete('/admin/game/{Game}', 'Admin\GameController@deleteGame');
//delete game tag
    Route::delete('/admin/game/tag/{Game}', 'Admin\GameController@deleteGameTag');
//add game tag
    Route::post('/admin/game/tag/{game}', 'Admin\GameController@postGameTag');

//admin tag pages

//get tags page
    Route::get('/admin/tag/all', 'Admin\TagController@getAll')->name('admin.tag.getAll');
//page create tag
    Route::get('/admin/tag/create', 'Admin\TagController@createTag')->name('admin.tag.create');
//page unpublished games
    Route::get('/admin/tag/unpublished', 'Admin\TagController@getUnpublished')->name('admin.tag.getUnpublished');
//page published games
    Route::get('/admin/tag/published', 'Admin\TagController@getPublished')->name('admin.tag.getPublished');

//get one tag page
    Route::get('/admin/tag/{Tag}', 'Admin\TagController@getTag')->name('admin.getTag');
//put tag
    Route::put('/admin/tag/{tag}', 'Admin\TagController@putTag');
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
});

//authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
