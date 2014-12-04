<?php

class Item extends \Eloquent {
	protected $fillable = [
		"sku", "description"
	];

	public function order(){
		return $this->belongsTo("Order");
	}
}