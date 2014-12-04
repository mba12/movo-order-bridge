<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSizesColumnFromOrders extends Migration {

	public function up()
	{
		Schema::table('orders', function($table)
		{
			$table->dropColumn('sizes');
		});
	}

	public function down()
	{
		Schema::table('orders', function($table)
		{
			$table->string('sizes');
		});
	}

}
