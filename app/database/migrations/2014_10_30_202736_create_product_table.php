<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration {

	public function up()
	{
		Schema::create('products', function ($table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('price');
			$table->integer('quantity');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}

}
