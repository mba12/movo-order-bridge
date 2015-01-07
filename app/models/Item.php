<?php

class Item extends \Eloquent {
	protected $fillable = [
		"sku", "description", "amount", "tax", "discount", "quantity", "shipping"
	];

	public function order(){
		return $this->belongsTo("Order");
	}
}