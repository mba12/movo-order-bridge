<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddProductOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("product_id")->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->string('name');
			$table->string('description');
			$table->double('price');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_options');
	}

}
