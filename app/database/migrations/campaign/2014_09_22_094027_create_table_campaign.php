<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCampaign extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id');
			$table->integer('agency_id');
			$table->integer('advertiser_id');
			$table->integer('contact_id');
			$table->integer('country_id')->default(233);
			$table->integer('currency_id')->default(1);
			$table->string('name',255);
			$table->integer('campaign_manager_id');
			$table->integer('sale_id');
			$table->date('expected_close_month');
			$table->date('start_date');
			$table->date('end_date');
			$table->boolean('sale_status')->default(0);
			$table->boolean('status')->default(0);
			$table->string('invoice_number');
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
		Schema::drop('campaign');
	}

}
