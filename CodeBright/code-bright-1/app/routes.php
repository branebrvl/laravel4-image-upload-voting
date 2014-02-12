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

Route::get('/', array(
    'before' => 'birthday',
    function()
    {
        return View::make('simple');
    }
));

Route::get('/{squirrel?}', function($squirrel = 'default')
{
    $data['squirrel'] = $squirrel;
	return View::make('example',$data);
});

Route::get('my/page', function(){
    return 'Hello world!';
});
