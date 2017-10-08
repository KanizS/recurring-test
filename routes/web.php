<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
	return view('welcome');
});

//Route::get('/test', 'OrderController@tag');

//Route::post('/shopify/webhook-tagger','OrderController@webhook_tagger');

Route::post('http://localhost:8081','OrderController@reorder');

//Route::post('/shopify/reorder','OrderController@reorder');
//Route::post('/shopify/reorder','ReorderController@reorder');
