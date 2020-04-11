<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::get('/top', 'HomeController@top');

Route::post('/', 'HomeController@upvote');

Route::get('/create', 'CreateController@index');

Route::post('/create', 'CreateController@insert'); 

Route::get('/comment/{id}', 'CommentController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
