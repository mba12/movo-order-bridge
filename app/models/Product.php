<?php

class Product extends \Eloquent
{
    protected $fillable = [];

    public static function getUnitPrice()
    {
        if (Cache::has("unit-price")) {
            return Cache::get("unit-price");
        }
        $product = DB::table('products')->first();
        Cache::put("unit-price", $product->price, 1440);
        return $product->price;
    }
}