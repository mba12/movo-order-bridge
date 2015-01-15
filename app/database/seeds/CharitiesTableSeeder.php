<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CharitiesTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();
		$faker = Faker::create();

		foreach(range(1, 4) as $index)
		{
			Charity::create([
				 "name"=>$faker->sentence(5)
			]);
		}
	}

}