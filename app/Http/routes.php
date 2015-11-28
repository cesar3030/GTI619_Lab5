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


/*
 |-------- Admin routes
 */
	Route::get('/admin', [
		 'middleware' => ['auth', 'roles'],
		 'uses' => 'AdminController@index',
		 'roles' => ['root']
	]);
	Route::get('/admin/config/attempt/{nbAttempts}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setNumberAttemptAllowed',
			'roles' => ['root']
	]);
	Route::get('/admin/config/restriction/{nbSeconds}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setTimeRestriction',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/disallow/{nbPasswordDisallow}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setNumberLastPasswordDisallowed',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/life/{nbDays}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setPasswordTimeLife',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/length/{length}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setPasswordMinLength',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/character/lower/{isRequired}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setPasswordLowerCaseRequired',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/character/upper/{isRequired}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setPasswordUpperCaseRequired',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/character/special/{isRequired}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setPasswordSpecialCharactersRequired',
			'roles' => ['root']
	]);
	Route::get('/admin/config/password/character/number/{isRequired}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'AdminController@setPasswordNumberRequired',
			'roles' => ['root']
	]);

/*
 |-------- Admin routes
 */
	Route::get('/user/{userId}/role/{roleId}', [
			'middleware' => ['auth', 'roles'],
			'uses' => 'UserController@updateRole',
			'roles' => ['root']
	]);




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


