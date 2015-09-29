<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrackingSummary extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracking_summary', function(Blueprint $table){
			$table->increments('id');
			$table->integer('ad_id');
			$table->integer('publisher_site_id');			
			$table->integer('ad_format_id');			
			$table->integer('campaign_id');
			$table->integer('flight_id');
			$table->integer('flight_publisher_id');
			$table->integer('publisher_id');
			$table->integer('impression')->default(0);
			$table->integer('unique_impression')->default(0);
			$table->integer('click')->default(0);
			$table->integer('start')->default(0);
			$table->integer('firstquartile')->default(0);
			$table->integer('midpoint')->default(0);
			$table->integer('thirdquartile')->default(0);
			$table->integer('complete')->default(0);
			$table->integer('mute')->default(0);
			$table->integer('fullscreen')->default(0);
			$table->integer('hour');
			$table->date('date');
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
		Schema::drop('tracking_summary');
	}

}
