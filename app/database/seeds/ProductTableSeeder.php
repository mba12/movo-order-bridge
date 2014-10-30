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
            "id"=>"1",
            "name"=>"One Movo watch",
            "price"=>'3000',
            "quantity"=>'1',
        ));

        Product::create(array(
            "id"=>"2",
            "name"=>"Two Movo watches",
            "price"=>'2500',
            "quantity"=>'2',
        ));

        Product::create(array(
            "id"=>"3",
            "name"=>"Three or more Movo watches",
            "price"=>'2000',
            "quantity"=>'3',
        ));




    }
}