<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTableUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			// $table->integer("publisher_id")->after('id');
			// $table->integer('country_id')->after('id');
			// $table->text('address')->after('email');
   //          $table->string('phone',255)->after('email');
			// $table->string('phone_contact',255)->after('phone');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn(['publisher_id','country_id','address','phone','phone_contact']);
		});
	}

}
