<?php

class CouponController extends \BaseController {


	public function check($code)
	{
		$coupon= Coupon::where("code", "=", $code)->first();
		return $coupon;
	}
}