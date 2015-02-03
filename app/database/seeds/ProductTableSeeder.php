<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class ProductTableSeeder extends Seeder
{


    public function run()
    {


        Eloquent::unguard();

        DB::table('products')->delete();


        Product::create(array(
            "id" => 1,
            "name" => "Extra small (5.7\" -- Child)",
            "sku" => '857458005008',
            "price" => "29.99",
            "category" => "wave"
        ));

        Product::create(array(
            "name" => "Small (6.3\" -- Small Female Wrist)",
            "sku" => '857458005015',
            "price" => "29.99",
            "category" => "wave"
        ));

        Product::create(array(
            "name" => "Medium (6.9\" -- Average Male Wrist)",
            "sku" => '857458005022',
            "price" => "29.99",
            "category" => "wave"
        ));

        Product::create(array(
            "name" => "Large (7.5\" -- Large Male Wrist)",
            "sku" => '857458005039',
            "price" => "29.99",
            "category" => "wave"
        ));

        Product::create(array(
            "name" => "Extra Large (8.5\" -- NFL Player / Body Builder)",
            "sku" => '857458005046 ',
            "price" => "29.99",
            "category" => "wave"

        ));

        Product::create(array(
            "name" => "Standard Loops",
            "sku" => '857458005053',
            "price" => "5.00",
            "category" => "loop"
        ));

        Product::create(array(
            "name" => "Neon Loops",
            "sku" => '857458005060',
            "price" => "5.00",
            "category" => "loop"
        ));

       /* $option = new ProductOption();
        $option->name = "color";
        $option->description = 'red';
        $option->price = "10.00";
        $product=Product::find(1);
        $product->options()->save($option);*/

    }
}