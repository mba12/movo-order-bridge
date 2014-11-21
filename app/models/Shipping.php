<?php

use Movo\Helpers\Format;

class Shipping extends \Eloquent {
	protected $table="shipping";
	protected $fillable = [];

	public static function  createShippingDropdownData($shippingInfo)
	{
		$shippingTypes = "";
		$shippingIds = "";
		$shippingRates = "";
		$i = 0;
		foreach ($shippingInfo as $info) {
			if ($i > 0) {
				$shippingTypes .= '|';
				$shippingIds .= '|';
				$shippingRates .= '|';
			}
			$shippingTypes .= $info->type;
			$shippingIds .= $info->id;
			$shippingRates .= Format::FormatDecimals($info->rate);
			$i++;
		}
		$dropdownData = [
			'shippingTypes' => $shippingTypes,
			'shippingIds' => $shippingIds,
			'shippingRates' => $shippingRates,
		];
		return $dropdownData;
	}
}