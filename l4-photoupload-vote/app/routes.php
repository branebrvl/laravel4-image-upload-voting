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
Route::get('test', function()
{
  $users = App::make('PhotoUpload\Repositories\User\UserRepositoryInterface'); 
  // return Response::json($users->getByIdWithImage(2));
  return Response::json($users->getByIdFavorites(2));
});

# Route filters
Route::when('admin/*', 'admin');

# Route patterns
Route::pattern('tag_slug', '[a-z0-9\-]+');
Route::pattern('image_slug', '[a-z0-9\-]+');

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
    
    # Photo Upload routes
    Route::resource('image','UploadController');

    # Image routes
    Route::get('images/{image_slug?}', [ 'as' => 'images.show', 'uses' => 'ImagesController@getShow' ]);
    Route::post('images/{image_slug}/like', [ 'as' => 'images.like', 'uses' => 'ImagesController@postLike' ]); 
    
    // # Search routes            
    // Route::get('search', 'SearchController@getIndex');
    //   
    // # Sitemap route            
    // Route::get('sitemap', 'SitemapController@getIndex');
    // Route::get('sitemap.xml', 'SitemapController@getIndex');
    //   
    # Authentication and registration routes
    Route::get('login', [ 'as' => 'auth.login', 'uses' => 'AuthController@getLogin' ]);
    Route::post('login', 'AuthController@postLogin');
    // Route::get('login/github', [ 'as' => 'auth.login.github', 'uses' => 'AuthController@getLoginWithGithub' ]);
    Route::get('register', [ 'as' => 'auth.register', 'uses' => 'AuthController@getRegister']); 
    Route::post('register', 'AuthController@postRegister'); 

    # Password reminder routes                                                                                                      
    // Route::controller('password', 'RemindersController', [                                                                          
    //     'getRemind' => 'auth.remind',                                                                                               
    //     'getReset'  => 'auth.reset'                                                                                                 
    // ]);                                                                                                                             
                                                                                                                                    
    # User profile routes                                                                                                           
    Route::get('user', [ 'as' => 'user.index', 'uses' => 'UserController@getIndex' ]);                                              
    Route::get('user/settings', [ 'as' => 'user.settings', 'uses' => 'UserController@getSettings' ]);                               
    Route::post('user/settings', 'UserController@postSettings');                                                                    
    Route::get('user/favorites', [ 'as' => 'user.favorites', 'uses' => 'UserController@getFavorites' ]);                            
    Route::post('user/avatar', [ 'as' => 'user.avatar', 'uses' => 'UserController@postAvatar' ]);                                   
                                                                                                                                    
    // # Trick creation route                                                                                                          
    // Route::get('user/tricks/new', [ 'as' => 'tricks.new', 'uses' => 'UserTricksController@getNew' ]);                               
    // Route::post('user/tricks/new', 'UserTricksController@postNew');                                                                 
    //                                                                                                                                 
    // # Trick editing route                                                                                                           
    // Route::get('user/tricks/{trick_slug}', [ 'as' => 'tricks.edit', 'uses' => 'UserTricksController@getEdit' ]);                    
    // Route::post('user/tricks/{trick_slug}', 'UserTricksController@postEdit');                                                       
    //                                                                                                                                 
    // # Trick delete route                                                                                                            
    // Route::get('user/tricks/{trick_slug}/delete', [ 'as' => 'tricks.delete', 'uses' => 'UserTricksController@getDelete' ]);         
                                                                                                                                    
    # Feed routes                                                                                                                   
    // Route::get('feed', [ 'as' => 'feed.atom', 'uses' => 'FeedsController@getAtom' ]);                                               
    // Route::get('feed.atom', [ 'uses' => 'FeedsController@getAtom' ]);                                                               
    // Route::get('feed.xml', [ 'as' => 'feed.rss', 'uses' => 'FeedsController@getRss' ]);                                             
                                                                                                                                    
    # This route will match the user by username to display their public profile                                                    
    # (if we want people to see who favorites and who posts what)                                                                   
    Route::get('{user}', [ 'as' => 'user.profile', 'uses' => 'UserController@getPublic' ]);
});
