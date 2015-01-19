<?php
use Faker\Factory as Faker;
class CharityCalculationTableSeeder extends Seeder
{

    public function run()
    {

        $faker = Faker::create();
        Eloquent::unguard();
        DB::table('charity_partners')->delete();

        CharityPartner::create([
            "id"=>1,
            "name"=>$faker->name,
            "primary_contact"=>$faker->name,
            "primary_contact_email"=>$faker->companyEmail,
            "primary_contact_phone"=>$faker->phoneNumber,

        ]);
        Campaign::create([
            "id" => 1,
            "partner_id" => 1,
            "name" => $faker->company,
            "description" =>  $faker->sentence(5),
            "active" =>  1,
            "start_date" =>  date("Y-m-d H:i:s"),
            "end_date"=>date("Y-m-d H:i:s"),


        ]);
        CharityCalculation::create([
            "item_sku" => "857458005053",
            "campaign_id" => 1,
            "start_date" =>  date("Y-m-d H:i:s"),
            "end_date"=>date("Y-m-d H:i:s"),
            "calculation_type"=>"fixed",
            "percent_amt"=>0,
            "fixed_amt"=>100,

        ]);
    }

}