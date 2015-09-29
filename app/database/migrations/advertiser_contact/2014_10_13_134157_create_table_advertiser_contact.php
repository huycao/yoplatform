<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdvertiserContact extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advertiser_contact', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('advertiser_id');
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
		Schema::drop('advertiser_contact');
	}

}
