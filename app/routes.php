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

Route::get('/order', function()
{
	return "order stuff here";
});

Route::group(array('before' => 'admin'), function () {
	Route::get('/admin/orders', array(
		'as' => 'admin-orders',
		'uses' => 'AdminController@getOrders',
	));
});
