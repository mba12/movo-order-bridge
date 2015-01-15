<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->integer('charity_id')->unsigned();
            $table->double('amount');
            $table->timestamps();
        });

        Schema::table('donations', function($table) {
            $table->foreign('order_id')->unsigned()->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('charity_id')->unsigned()->references('id')->on('charities')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('donations');
    }

}
