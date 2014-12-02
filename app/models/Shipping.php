<?php

use Movo\Helpers\Format;

class Shipping extends \Eloquent {
	protected $table="shipping";
	protected $fillable = [];

	public static function getShippingMethod($shippingType)
	{
		if (Cache::has("shipping-method-" . $shippingType)) {
			return Cache::get("shipping-method-" . $shippingType);
		}
		$shipping = Shipping::find($shippingType);
		Cache::put("shipping-method-" . $shippingType, $shipping, 1440);
		return $shipping;
	}

	public static function getShippingMethodsAndPrices()
	{
		if (Cache::has("shipping-info")) {
			return Cache::get("shipping-info");
		}
		$shippingInfo = Shipping::all();
		Cache::put("shipping-info", $shippingInfo, 1440);
		return $shippingInfo;
	}
}