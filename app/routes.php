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

Route::get('/', function()
{

	return View::make('hello');
});

Route::api('v1', function()
{

	Route::group(['prefix' => 'watershed'], function()
	{

		Route::get('/', 'WatershedController@getIndex');		
		Route::get('current', 'WatershedController@getCurrent');
	});

	Route::group(['prefix' => 'reservoirs'], function()
	{

		Route::get('/', 'ReservoirsController@getIndex');		
		Route::get('{id}', 'ReservoirsController@getId')
			->where(['id' => '[0-9]+']);
	});
});
