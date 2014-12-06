<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class AccessoryTableSeeder extends Seeder
{


    public function run()
    {

        Eloquent::unguard();
        DB::table('accessories')->delete();
        Accessory::create(array(
            "name"=>"Movo Loops - Standard",
            "sku"=>'857458005053'
        ));

        Accessory::create(array(
            "name"=>"Movo Loops - Neon",
            "sku"=>'857458005060'
        ));

        Accessory::create(array(
            "name"=>"Movo Loops - USC",
            "sku"=>'857458005077'
        ));


    }
}