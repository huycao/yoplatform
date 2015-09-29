<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePublisherLanguage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publisher_language', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('publisher_id');
			$table->integer('language_id');
			$table->string('language_name',255);
			$table->integer('created_by');
			$table->integer('updated_by');
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
		Schema::drop('publisher_language');
	}

}
