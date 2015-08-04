<?php

class Product extends \Eloquent
{
    protected $fillable = ['name', 'price', 'sku', 'category'];

    public function options(){
        return $this->hasMany("ProductOption");
    }
    public static function getUnitPrice()
    {
        if (Cache::has("unit-price")) {
            return Cache::get("unit-price");
        }
        $product = DB::table('products')->first();
        Cache::put("unit-price", $product->price, 1440);
        return $product->price;
    }

    public static function allManual(){
        if (Cache::has("allManual")) {
            return Cache::get("allManual");
        }
        $products = Product::select( 'sku', 'name', 'price' )->get();
        Cache::put("allManual", $products, 1440);
        return $products;
    }


    public static function waves(){
        if (Cache::has("waves")) {
            return Cache::get("waves");
        }
        $waves = Product::where("category", "=", "wave")->with("options")->get();
        Cache::put("waves", $waves, 1440);
        return $waves;
    }

    public static function loops(){
        if (Cache::has("loops")) {
            return Cache::get("loops");
        }
        $loops = Product::where("category", "=", "loop")->with("options")->get();
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

    public static function getLargeBundle()
    {
        if (Cache::has("large-bundle")) {
            return Cache::get("large-bundle");
        }

        // TODO: add an inventory check for standard loops

        $bundle = Product::whereIn("id", [4,6])->get();
        Cache::put("large-bundle", $bundle, 1440);
        return $bundle;
    }

    public static function getMediumBundle()
    {
        if (Cache::has("medium-bundle")) {
            return Cache::get("medium-bundle");
        }

        // TODO: add an inventory check for standard loops

        $bundle = Product::whereIn("id", [3,6])->get();
        Cache::put("medium-bundle", $bundle, 1440);
        return $bundle;
    }

    public static function getProductById($id) {
        $bundle = Product::where("id", "=", $id)->get();
        return $bundle;
    }

    public static function getNameBySKU($sku) {

        if (Cache::has("name:" . $sku)) {
            return Cache::get("name:" . $sku);
        }

        $product = Product::where("sku", "=", $sku)->get()->first();
        Cache::put("name:" . $sku, $product->name, 1440);

        return $product->name;
    }


}