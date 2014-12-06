<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccessoryTable extends Migration {

	public function up()
	{
		Schema::create("accessories", function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('sku');
			$table->timestamps();
		});
	}


	public function down()
	{
		Schema::drop("accessories");
	}

}
