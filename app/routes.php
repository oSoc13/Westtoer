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
    return 'Hello World';
});


Route::resource('/api/event', 'EventController', array('only' => array('index', 'show')));
Route::controller('/api', 'APIController');

Route::get('/ui/screen/{id}', 'DashboardController@buildDashboard');
Route::post('/ui/screen/{id}', array('before' => 'csrf', 'uses' => 'DashboardController@postSettings'));