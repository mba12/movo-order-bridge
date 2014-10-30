<?php

class Order extends \Eloquent {

	protected $fillable = [
		'amount',
		'quantity',
		'first_name',
		'last_name',
		'shipping_address_1',
		'shipping_address_2',
		'shipping_city',
		'shipping_state',
		'shipping_zip',
		'shipping_country',
		'phone',
		'email',
		'shipping_service',
		'stripe_charge_id',
		'ingram_order_id',
		'status',
		'tracking_code',
		'error_flag',
	];
}
