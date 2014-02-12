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
// Simulate a logged in user

Auth::loginUsingId(5);

Route::get('/', function()
{
  $posts = Post::all();

	return View::make('posts.index', compact('posts'));
});


Route::post('favorites',['as' => 'favorites.store', function()
{
  Auth::user()->favorites()->attach(Input::get('post-id'));

  return Redirect::back();
}]);
