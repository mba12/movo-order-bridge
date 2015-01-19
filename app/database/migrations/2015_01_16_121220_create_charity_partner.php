<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharityPartner extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charity_partners', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('primary_contact');
			$table->string('primary_contact_email');
			$table->string('primary_contact_phone');
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
		Schema::drop('charity_partners');
	}

}
