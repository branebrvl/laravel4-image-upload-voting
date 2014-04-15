<?php
// Auth::login(\Evolve\Render\Models\User::find(2));

/*
|--------------------------------------------------------------------------
| RESTful routes - API
|--------------------------------------------------------------------------
|
*/
Route::group(['prefix' => 'api/v1', 'namespace' => 'Evolve\Render\Controllers\Api'], function()
{                                              
  Route::get('renders/{id}/tags', 'TagsController@index');
  Route::resource('renders','RendersController');
  Route::resource('tags','TagsController',['only' => ['index','show']]);
}); 

/*
|--------------------------------------------------------------------------
| Web routes - The Site
|--------------------------------------------------------------------------
|
*/

# Route filters
Route::when('admin/*', 'admin');

# Route patterns
Route::pattern('tag_slug', '[a-z0-9\-]+');
Route::pattern('image_slug', '[a-z0-9\-]+');

# Admin routes
Route::group([ 'prefix' => 'admin', 'namespace' => 'Evolve\Render\Controllers\Web\Admin' ], function () {
  # Tags routes
  Route::controller('tags', 'TagsController', [
                               'getIndex' => 'admin.tags.index',
                               'getView' => 'admin.tags.view'
                             ]);
  # Users routes
  Route::controller('users', 'UsersController');
});     
        
Route::group([ 'namespace' => 'Evolve\Render\Controllers\Web'], function () {
  # Home routes              
  Route::get('/', [ 'as' => 'home', 'uses' => 'HomeController@getIndex' ]);
  Route::get('recent', [ 'as' => 'browse.recent', 'uses' => 'BrowseController@getBrowseRecent' ]); 
  Route::get('about', [ 'as' => 'about', 'uses' => 'HomeController@getAbout' ]);
  Route::get('popular', [ 'as' => 'browse.popular', 'uses' => 'BrowseController@getBrowsePopular' ]);
  

  # Image routes
  Route::get('images/{image_slug?}', [ 'as' => 'images.show', 'uses' => 'ImagesController@getShow' ]);
  Route::post('images/{image_slug}/like', [ 'as' => 'images.like', 'uses' => 'ImagesController@postLike' ]); 
  Route::get('tags', [ 'as' => 'browse.tags', 'uses' => 'BrowseController@getTagIndex' ]); 
  Route::get('tags/{tag_slug}', [ 'as' => 'images.browse.tag', 'uses' => 'BrowseController@getBrowseTag' ]);

  # Search routes            
  Route::get('search', 'SearchController@getIndex');

  # Authentication and registration routes
  Route::get('login', [ 'as' => 'auth.login', 'uses' => 'AuthController@getLogin' ]);
  Route::post('login', 'AuthController@postLogin');
  Route::get('register', [ 'as' => 'auth.register', 'uses' => 'AuthController@getRegister']); 
  Route::post('register', 'AuthController@postRegister'); 
  Route::get('logout', [ 'as' => 'auth.logout', 'uses' => 'AuthController@getLogout' ]);

  # Password reminder routes                                                                                                      
  Route::controller('password', 'RemindersController', [                                                                          
                                  'getRemind' => 'auth.remind',                                                                                               
                                  'getReset'  => 'auth.reset'                                                                                                 
                                 ]);                                                                                                                             
                                                                                                                                  
  # User profile routes                                                                                                           
  Route::get('user', [ 'as' => 'user.index', 'uses' => 'UserController@getIndex' ]);                                              
  Route::get('user/settings', [ 'as' => 'user.settings', 'uses' => 'UserController@getSettings' ]);                               
  Route::post('user/settings', 'UserController@postSettings');                                                                    
  Route::get('user/favorites', [ 'as' => 'user.favorites', 'uses' => 'UserController@getFavorites' ]);                            
  Route::post('user/avatar', [ 'as' => 'user.avatar', 'uses' => 'UserController@postAvatar' ]);                             

  # Render creation route                                  
  Route::get('user/images/new', [ 'as' => 'images.new', 'uses' => 'RenderImagesController@getNew' ]);
  Route::post('user/images/new', 'RenderImagesController@postNew');
  Route::post('user/images/render', [ 'as' => 'images.render', 'uses' => 'RenderImagesController@postRender' ]);

  # Render editing route
  Route::get('user/images/{image_slug}', [ 'as' => 'images.edit', 'uses' => 'RenderImagesController@getEdit' ]);
  Route::post('user/images/{image_slug}', 'RenderImagesController@postEdit');

  # Render delete route
  Route::get('user/images/{image_slug}/delete', [ 'as' => 'images.delete', 'uses' => 'RenderImagesController@getDelete' ]);       

  # This route will match the user by username to display their public profile                                                    
  # (if we want people to see who favorites and who posts what)                                                                   
  Route::get('{user}', [ 'as' => 'user.profile', 'uses' => 'UserController@getPublic' ]);
});
