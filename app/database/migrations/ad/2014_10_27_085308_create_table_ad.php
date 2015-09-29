<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAd extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ad', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->integer('campaign_id');
            $table->integer('ad_format_id');
            $table->enum('ad_type', array('image','flash','video'));
            $table->integer('width');
            $table->integer('height');
            $table->string('source_url');
            $table->string('destination_url');
            $table->enum('flash_wmode', array('window', 'direct', 'opaque', 'transparent', 'gpu'));
            $table->integer('video_duration')->default(0);
            $table->enum('video_linear', array('linear','non-linear'));
            $table->enum('video_type_vast', array('inline','wrapper'));
            $table->text('video_wrapper_tag');
            $table->integer('video_bitrate')->default(0);
            $table->text('video_impression_track');
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
		Schema::drop('ad');
	}

}
