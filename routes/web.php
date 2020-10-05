<?php

use Illuminate\Support\Facades\Route;

date_default_timezone_set('America/Los_Angeles');

Route::get('/', 'HomeController@index');

Route::get('/page/{page}', 'HomeController@indexOnPage');

Route::get('/top', 'HomeController@top');

Route::get('/top/page/{page}', 'HomeController@topOnPage');

Route::post('/', 'HomeController@upvote');

Route::get('/create', 
            [
                'middleware' => 'auth', 
                'uses' => 'CreateController@index'
            ])
            ->name('create');

Route::post('/create', 'CreateController@insert'); 

Route::get('/comment/{id}', 'CommentController@index');

Route::get('/comment/{id}/top', 'CommentController@top');

Route::post('/comment/{id}/reply', ['middleware' => 'auth', 'uses' => 'CommentController@reply']);

Route::post('/comment/{id}', 'CommentController@upvote');

Route::get('/delete/{id}', 'CreateController@delete')->middleware('auth');

Route::get('/profile/{id}', 'ProfileController@index');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
