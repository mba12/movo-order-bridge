<?php

class Item extends \Eloquent {
	protected $fillable = [
		"sku", "description", "amount", "tax", "discount", "quantity"
	];

	public function order(){
		return $this->belongsTo("Order");
	}
}