<?php

class CouponInstance extends \Eloquent {
	protected $fillable = ['code', 'token','used'];

	public function coupon(){
		return $this->belongsTo("Coupon");
	}
}