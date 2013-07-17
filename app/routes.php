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

Route::get('/', 'IndexController@index');

Route::resource('/api/event', 'EventController', array('only' => array('index', 'show')));
Route::resource('/api/weather', 'WeatherController', array('only' => array('show')));
Route::controller('/api', 'APIController');

/**
 * Dashboard & UI
 */
Route::get('/ui', 'OverviewController@getOverview');
Route::post('/ui/create/screen', 'OverviewController@createScreen');
Route::get('/ui/screen/{screen_id}', array('as' => 'screen', 'uses' => 'DashboardController@buildDashboard'));
Route::post('/ui/screen/{screen_id}', array('before' => 'csrf', 'uses' => 'DashboardController@postSettings'));
Route::post('/ui/picasa/{screen_id}', array('before' => 'csrf', 'uses' => 'DashboardController@setAlbums'));
Route::post('/ui/weather/{screen_id}', array('before' => 'csrf', 'uses' => 'DashboardController@addWeather'));
Route::get('/ui/weather/{screen_id}/{weather_id}/remove', 'DashboardController@removeWeather');



Route::get('/ui/thumbs-up/{screen_id}/{event_name}', 'DashboardController@thumbsUp');
Route::get('/ui/thumbs-down/{screen_id}/{event_name}', 'DashboardController@thumbsDown');
Route::get('/ui/remove/{screen_id}/{event_name}', 'DashboardController@remove');