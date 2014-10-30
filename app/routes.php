<?php


Route::post('stripe/webhook', 'WebhookController@handleWebhook');

Route::get('/', 'OrderController@showForm');
Route::post('buy',  array(
	'as' => 'buy',
	'uses' => 'OrderController@buy',
));

Route::group(array('before' => 'admin'), function () {
	Route::get('/admin/orders', array(
		'as' => 'admin-orders',
		'uses' => 'AdminController@getOrders',
	));
});
