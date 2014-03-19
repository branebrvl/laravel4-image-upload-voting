<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/',array('as' => 'home', function()
// {
//
//   // Give::javaScript(['name' => 'jsdata']);
// 	// return View::make('hello');
//   return \PhotoUpload\models\User::with('images')->get();
// }));


# Route filters
Route::when('admin/*', 'admin');
// Route::when('*', 'trick.view_throttle');

# Route patterns
Route::pattern('tag_slug', '[a-z0-9\-]+');
Route::pattern('trick_slug', '[a-z0-9\-]+');

# Admin routes
// Route::group([ 'prefix' => 'admin', 'namespace' => 'PhotoUpload\Controllers\Web\Admin' ], function () {
//     Route::controller('tags', 'TagsController', [
//         'getIndex' => 'admin.tags.index',
//         'getView'  => 'admin.tags.view'
//     ]);
//
//     Route::controller('categories', 'CategoriesController', [
//         'getIndex' => 'admin.categories.index',
//         'getView'  => 'admin.categories.view'
//     ]); 
//         
//     Route::controller('users', 'UsersController');
// });     
        
Route::group([ 'namespace' => 'PhotoUpload\Controllers\Web' ], function () {
    # Home routes              
    Route::get('/', [ 'as' => 'home', 'uses' => 'HomeController@getIndex' ]);
    Route::get('about', [ 'as' => 'about', 'uses' => 'HomeController@getAbout' ]);
    Route::get('popular', [ 'as' => 'browse.popular', 'uses' => 'BrowseController@getBrowsePopular' ]);
    Route::get('comments', [ 'as' => 'browse.comments', 'uses' => 'BrowseController@getBrowseComments' ]);  
    
    Route::resource('image','ImageController');
    // # Search routes            
    // Route::get('search', 'SearchController@getIndex');
    //   
    // # Sitemap route            
    // Route::get('sitemap', 'SitemapController@getIndex');
    // Route::get('sitemap.xml', 'SitemapController@getIndex');
    //   
    // # Authentication and registration routes
    // Route::get('login', [ 'as' => 'auth.login', 'uses' => 'AuthController@getLogin' ]);
    // Route::post('login', 'AuthController@postLogin');
    // Route::get('login/github', [ 'as' => 'auth.login.github', 'uses' => 'AuthController@getLoginWithGithub' ]);
    // Route::get('register', [ 'as' => 'auth.register', 'uses' => 'AuthController@getRegister']); 
    // Route::post('register', 'AuthController@postRegister'); 
});
