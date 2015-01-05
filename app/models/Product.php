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

    public static function waves(){
        if (Cache::has("waves")) {
            return Cache::get("waves");
        }
        $waves = Product::where("category", "=", "wave")->get();
        Cache::put("waves", $waves, 1440);
        return $waves;
    }

    public static function loops(){
        if (Cache::has("loops")) {
            return Cache::get("loops");
        }
        $loops = Product::where("category", "=", "loop");
        Cache::put("loops", $loops, 1440);
        return $loops;
    }

    public static function getAll()
    {
        if (Cache::has("all-products")) {
            return Cache::get("all-products");
        }
        $all = Product::all();
        Cache::put("all-products", $all, 1440);
        return $all;
    }
}