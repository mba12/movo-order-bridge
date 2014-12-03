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
            "name"=>"Extra small (5.7\" -- Youth / Young Adult)",
            "sku"=>'857458005008'
        ));

        Size::create(array(
            "name"=>"Small (6.3\" -- Small Female Wrist)",
            "sku"=>'857458005015'
        ));

        Size::create(array(
            "name"=>"Medium (6.9\" -- Average Male Wrist)",
            "sku"=>'857458005022'
        ));

        Size::create(array(
            "name"=>"Large (7.5\" -- Large Male Wrist)",
            "sku"=>'857458005039'
        ));

        Size::create(array(
            "name"=>"Extra Large (8.5\" -- NFL Player / Body Builder)",
            "sku"=>'857458005046 '
        ));
    }
}