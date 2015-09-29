<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePublisherAlternateAd extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publisher_alternate_ad', function(Blueprint $table)
		{
			$table->increments('id'); 
			$table->string('name',200)->default(''); 
			$table->integer('publisher_id');			 
			$table->integer('ad_format_id');  
			$table->string('url',255); 
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
		Schema::drop('publisher_alternate_ad');
	}

}
