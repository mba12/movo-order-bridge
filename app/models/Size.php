<?php

class Size extends \Eloquent {
	protected $fillable = [];

	public static function getUnitSizes()
	{
		if (Cache::has("unit-sizes")) {
			return Cache::get("unit-sizes");
		}
		$unitSizes = Size::all();
		Cache::put("unit-sizes", $unitSizes, 1440);
		return $unitSizes;

	}

}