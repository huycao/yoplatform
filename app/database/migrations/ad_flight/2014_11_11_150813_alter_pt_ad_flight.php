<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPtAdFlight extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ad_flight', function(Blueprint $table)
		{
			$table->integer('priority')->after('flight_id')->default(0);
		});				
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ad_flight', function(Blueprint $table)
		{
		 	$table->dropColumn('priority');
		});	
	}

}
