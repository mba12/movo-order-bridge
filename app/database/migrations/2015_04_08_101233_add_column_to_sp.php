<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('standard_responses', function($table)
        {
            $table->integer('order_id', 20);
        });

        Schema::table('ship_notification', function($table)
        {
            $table->integer('order_id', 20);
        });

    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

        Schema::table('standard_responses', function(Blueprint $table) {
            $table->dropColumn('order_id');
        });

        Schema::table('ship_notification', function(Blueprint $table) {
            $table->dropColumn('order_id');
        });

    }

}
