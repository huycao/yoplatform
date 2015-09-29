<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdFlight extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ad_flight', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('ad_id');
            $table->integer('flight_id');
            $table->integer('order');
			$table->timestamps();
			$table->engine = 'InnoDB';
		});						
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ad_flight');
	}

}
