<?php



class ShippingTableSeeder extends Seeder
{


    public function run()
    {

        Eloquent::unguard();

        DB::table('shipping')->delete();

        Shipping::create(array(
            "id"=>"1",
            "type"=>"SmartPost",
            "rate"=>'5.75',
            "active"=>1
        ));

        Shipping::create(array(
            "id"=>"2",
            "type"=>"7-10 Day Ground",
            "rate"=>'8.50',
            "active"=>1
        ));

        Shipping::create(array(
            "id"=>"3",
            "type"=>"3-5 Day Ground",
            "rate"=>'12.00',
            "active"=>1
        ));

        Shipping::create(array(
            "id"=>"4",
            "type"=>"2 Day|Priority Overnight",
            "rate"=>'18.00',
            "active"=>1
        ));

        Shipping::create(array(
            "id"=>"5",
            "type"=>"International",
            "rate"=>'17.00',
            "active"=>1
        ));

    }
}