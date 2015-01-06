<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		 $this->call('ProductTableSeeder');
		 $this->call('UserTableSeeder');
		 $this->call('ShippingTableSeeder');
		 $this->call('SizeTableSeeder');
		 $this->call('CouponTableSeeder');
		 $this->call('TaxTableSeeder');
		 $this->call('AccessoryTableSeeder');
	}

}
