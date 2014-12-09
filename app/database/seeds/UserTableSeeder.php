<?php

use Faker\Factory;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;

class UserTableSeeder extends Seeder
{


    public function run()
    {


        Eloquent::unguard();

        DB::table('users')->delete();

        User::create(array(
            "id"=>"1",
            "name"=>"admin",
            "password"=>Hash::make("HrKwO4ApDutpwSLzMY7A"),
            "role"=>'admin',
        ));
    }
}