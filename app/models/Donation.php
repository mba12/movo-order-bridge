<?php

class Donation extends \Eloquent {
	protected $fillable = ["charity_id", "order_id", "amount"];

	public  function saveDonation($order, $charity, $loopCount){

		Donation::create(
			[
				"charity_id"=> $charity,
				"order_id"=> $order->id,
				"amount"=> $loopCount>0?200:100,

			]
		);
	}
}