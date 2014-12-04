<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTaxColumnInOrders extends Migration {


	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->double('tax');
			$table->double('discount');
			$table->double('unit_price');
		});
	}


	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
			$table->dropColumn('tax');
			$table->dropColumn('discount');
			$table->dropColumn('unit_price');
		});
	}

}
