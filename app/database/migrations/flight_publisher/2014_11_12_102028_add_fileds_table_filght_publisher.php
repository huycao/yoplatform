<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledsTableFilghtPublisher extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('flight_publisher', function(Blueprint $table)
		{
			$table->tinyInteger('status')->after('cost_type');
			$table->tinyInteger('sort')->after('status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('flight_publisher', function(Blueprint $table)
		{
			$table->dropColumn(['status','sort']);
		});
	}

}
