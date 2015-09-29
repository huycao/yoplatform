<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 // Schema::create('category', function(Blueprint $table)
		 // {
		 // 	$table->increments('id');
		 // 	$table->string('name',255);
		 // 	$table->integer('parent_id');
		 // 	$table->text('path');
		 // 	$table->boolean('status')->default(1);	
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
		Schema::drop('category');
	}

}
