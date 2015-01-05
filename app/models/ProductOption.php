<?php

class ProductOption extends \Eloquent {
	protected $fillable = [];

	public function product(){
		return $this->belongsTo("Product");
	}
}