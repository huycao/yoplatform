<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePublisherAdzone extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('publisher_ad_zone', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',200)->default(''); 
			$table->integer('publisher_site_id');
			$table->integer('publisher_id');
			$table->integer('platform');
			$table->integer('ad_format_id');
			$table->integer('adplacement');
			$table->integer('alternateadtype');
			$table->string('alternatead',255); 
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
	Schema::drop('publisher_ad_zone');
	}

}
