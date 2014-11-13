<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class CouponTableSeeder extends Seeder
{


    public function run()
    {

        Eloquent::unguard();
        DB::table('coupons')->delete();

        $coupon=new Coupon();
        $coupon->name="friends20";
        $coupon->code="friends20";
        $coupon->amount=20;
        $coupon->method="%";
        $coupon->limit=100;
        $coupon->min_units=3;
        $coupon->save();


        $coupon=new Coupon();
        $coupon->name="takeTen";
        $coupon->code="takeTen";
        $coupon->amount=10.00;
        $coupon->method="$";
        $coupon->limit=10;
        $coupon->min_units=1;
        $coupon->save();
    }
}