<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class OrderTableSeeder extends Seeder
{


    public function run()
    {


        Eloquent::unguard();

        DB::table('orders')->delete();
        DB::table('items')->delete();

    }
}