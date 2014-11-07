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
            "id" => "1",
            "name" => "One Movo watch",
            "price" => '29.99',
            "quantity" => '1',
        ));

    }
}