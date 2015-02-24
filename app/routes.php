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

Route::get('/', function() { return View::make('index'); });
Route::get('v/{token}', 'ReportsController@getVerify');
Route::post('queue/receive', function() { return Queue::marshal(); });

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

Route::group(['prefix' => 'reports'], function()
{

	Route::post('signup', 'ReportsController@postSignup');
	Route::get('{token}/verify', 'ReportsController@getVerify');
	Route::get('{token}/remove', 'ReportsController@getRemove');
});
