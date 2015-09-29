<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgencyContact extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agency_contact', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('agency_id');
			$table->integer('contact_id');
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
		Schema::drop('agency_contact');
	}

}
