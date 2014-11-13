<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class SizeTableSeeder extends Seeder
{


    public function run()
    {

        Eloquent::unguard();
        DB::table('sizes')->delete();
        Size::create(array(
            "name"=>"Extra Small (14.5 cm - Small Female Wrist)",
            "sku"=>'11111'
        ));

        Size::create(array(
            "name"=>"Small (16 cm - Average Female Wrist)",
            "sku"=>'22222'
        ));

        Size::create(array(
            "name"=>"Medium (17.5 cm - Avg. Male Wrist / Large Female Wrist)",
            "sku"=>'33333'
        ));

        Size::create(array(
            "name"=>"Large (19 cm - Large Male Wrist)",
            "sku"=>'44444'
        ));

        Size::create(array(
            "name"=>"Extra Large (21.5 cm - Very Large Male Wrist)",
            "sku"=>'55555'
        ));
    }
}