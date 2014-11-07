<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingTable extends Migration {

	public function up()
	{
		Schema::create('shipping', function ($table) {
			$table->increments('id');
			$table->string('type');
			$table->double('rate');
			$table->integer('active');
			$table->timestamps();
		});
	}


	public function down()
	{
		Schema::drop('shipping');
	}

}
