<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePublisherInfoPayment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publisher_info_payment', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('publisher_id');
			$table->string('bank',255);
			$table->string('payment_preference',255);
			$table->string('account_number',255);
			$table->string('account_name',255);
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
		Schema::drop('publisher_info_payment');
	}

}
