<?php

class Accessory extends \Eloquent {
	protected $fillable = [];

	public static function getColors()
	{
		if (Cache::has("loop-colors")) {
			return Cache::get("loop-colors");
		}
		$colors = Accessory::all();
		Cache::put("loop-colors", $colors, 1440);
		return $colors;

	}
}