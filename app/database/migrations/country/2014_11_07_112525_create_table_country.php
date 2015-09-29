<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCountry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Schema::create('country', function(Blueprint $table)
		// {
		// 	$table->increments('id');
		// 	$table->string('country_code',2);
		// 	$table->string('country_name',100);
		// 	$table->integer('created_by');
		// 	$table->integer('updated_by');
		// 	$table->timestamps();
		// 	$table->engine = 'InnoDB';
		// });				
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('country');
	}

}
