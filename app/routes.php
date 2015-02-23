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

	return View::make('index');
});

Route::get('sitemap.xml', function()
{

	$sitemap = App::make("sitemap");
	$sitemap->setCache('laravel.sitemap', 3600);

	if ( ! $sitemap->isCached())
	{

		$sitemap->add(URL::to('/'), '2015-01-10T00:00:00+02:00', '1.0', 'daily');
	}

	return $sitemap->render('xml');
});

Route::group(['prefix' => 'api'], function()
{

	Route::api('v1', function()
	{

		Route::group(['prefix' => 'watershed'], function()
		{

			Route::get('/', 'Api\WatershedController@getIndex');
			Route::get('history', 'Api\WatershedController@getHistory');
		});

		Route::group(['prefix' => 'reservoirs'], function()
		{

			Route::get('/', 'Api\ReservoirsController@getIndex');
			Route::get('{id}', 'Api\ReservoirsController@getId')
				->where(['id' => '[0-9]+']);

			Route::get('google-chart', 'Api\ReservoirsController@getGoogleChart');
		});
	});
});

Route::get('wpp', function()
{

	$username = "14387001374";
	$identity = "%f1%e9%12%1f%b3%f1m%cc%dc%7b%14j%99m%f0%3d%11%06%b3%2e";
	$nickname = "Vai ter agua";
	$password = "jrotTvQe4sfZpB5d6rCUDXPDv7g=";
	$debug = true;

	// Create a instance of WhastPort.
	$w = new WhatsProt($username, $identity, $nickname, $debug);

	$w->connect(); // Connect to WhatsApp network
	$w->loginWithPassword($password); // logging in with the password we got!

	$w->sendMessage("553199821215" , "Eae babaca.");
});
