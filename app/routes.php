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

Route::get('/mail',function(){
	$data[]=new Item("widget 1", 4, "$10.00");
	$data[]=new Item("widget 2", 3,  "$10.00");
	Mail::send('emails.receipt', array('items' => $data), function($message)
	{
		$message->to('alex@jumpkick.pro', 'John Smith')->subject('Welcome!')->from("orders@getmovo.com");
	});
});



