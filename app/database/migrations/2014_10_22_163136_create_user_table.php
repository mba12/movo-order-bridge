<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	public function up()
	{
		Schema::create('users', function ($table) {
			$table->increments('id');
			$table->string('name');
			$table->string('password');
			$table->string('role');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}

}
