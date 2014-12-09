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
        DB::table('coupon_instances')->delete();

        $coupon=new Coupon();
        $coupon->name="friends20";
        $coupon->code="friends20";
        $coupon->amount=20;
        $coupon->method="%";
        $coupon->limit=100;
        $coupon->min_units=1;
        $coupon->active=1;
        $coupon->start_time='2014-11-20';
        $coupon->end_time='2014-12-20';
        $coupon->time_constraint=0;
        $coupon->save();


        $coupon=new Coupon();
        $coupon->name="takeTen";
        $coupon->code="takeTen";
        $coupon->amount=10.00;
        $coupon->method="$";
        $coupon->limit=10;
        $coupon->min_units=1;
        $coupon->active=0;
        $coupon->start_time='2014-11-20';
        $coupon->end_time='2014-12-20';
        $coupon->time_constraint=0;
        $coupon->save();

        $coupon=new Coupon();
        $coupon->name="dummy";
        $coupon->code="dummy";
        $coupon->amount=10.00;
        $coupon->method="$";
        $coupon->limit=10;
        $coupon->min_units=1;
        $coupon->active=0;
        $coupon->start_time='2014-11-10';
        $coupon->end_time='2014-11-11';
        $coupon->time_constraint=1;
        $coupon->save();
    }
}