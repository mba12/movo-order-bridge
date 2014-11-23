<?php

class Tax extends \Eloquent {
	protected $fillable = [];

	public static function getStateTaxMethods()
	{
		if (Cache::has("state-tax-methods")) {
			return Cache::get("state-tax-methods");
		}
		$stateTaxMethods = Tax::all();
		Cache::put("state-tax-methods", $stateTaxMethods, 1440);
		return $stateTaxMethods;
	}
}