<?php

class Order extends \Eloquent
{

    protected $fillable = [
        'amount',
        'quantity',
        'sizes',
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

    public function saveOrder($amount,$chargeID)
    {
		$this->amount = $amount;
		$this->quantity = Input::get("quantity");
		$this->first_name = Input::get("first_name");
		$this->last_name = Input::get("last_name");
		$this->shipping_address_1 = Input::get("shipping_address_1");
		$this->shipping_address_2 = Input::get("shipping_address_2");
		$this->shipping_city = Input::get("shipping_city");
		$this->shipping_state = Input::get("shipping_state");
		$this->shipping_zip = Input::get("shipping_zip");
		$this->shipping_country = Input::get("shipping_country");
		$this->phone = Input::get("phone");
		$this->email = Input::get("email");
		$this->shipping_service = "";
		$this->stripe_charge_id = $chargeID;
		$this->ingram_order_id = "";
		$this->status = 1;
		$this->tracking_code = "";
		$this->error_flag = "";
		$this->save();
    }
}
