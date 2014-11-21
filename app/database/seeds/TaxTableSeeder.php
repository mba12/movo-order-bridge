<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class TaxTableSeeder extends Seeder
{


    public function run()
    {

        Eloquent::unguard();
        DB::table('taxes')->delete();
        Tax::create(array(
            "state" => "AK",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "AL",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "AZ",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "AR",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "CA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "CO",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "CT",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "DE",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "FL",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "GA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "HI",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "ID",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "IL",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "IN",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "IA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "KS",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "KY",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "LA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "ME",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "MD",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "MA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "MI",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "MS",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "MO",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "MT",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NE",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NV",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NH",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NJ",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NM",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NY",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "NC",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "ND",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "OH",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "OK",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "OR",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "PA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "RI",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "SC",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "SD",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "TN",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "TX",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "UT",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "VT",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "VA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "WA",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "WV",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "WI",
            "rate" => '0'
        ));
        Tax::create(array(
            "state" => "WY",
            "rate" => '0'
        ));
    }
}