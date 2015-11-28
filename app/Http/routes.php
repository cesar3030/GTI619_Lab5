<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('/circle',[
     'middleware' => ['auth', 'roles'],
     'uses' => 'CircleController@index',
     'roles' => ['root','circle']
]);

Route::get('/square',[
     'middleware' => ['auth', 'roles'],
     'uses' => 'SquareController@index',
     'roles' => ['root','square']
]);

Route::get('/admin', [
     'middleware' => ['auth', 'roles'],
     'uses' => 'AdminController@index',
     'roles' => ['root']
]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


