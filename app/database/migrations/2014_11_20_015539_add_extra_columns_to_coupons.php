<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnsToCoupons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('coupons', function($table)
		{
			$table->datetime('start_time');
			$table->datetime('end_time');
			$table->integer('time_constraint');
			$table->integer('active');
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('coupons', function($table)
		{
			$table->dropColumn('start_time');
			$table->dropColumn('end_time');
			$table->dropColumn('active');
			$table->dropColumn('time_constraint');
		});
	}

}
