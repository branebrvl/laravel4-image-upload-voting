<?php


Route::get('/', ['as' => 'home', 'uses' => 'TasksController@index']);
Route::resource('tasks', 'TasksController');