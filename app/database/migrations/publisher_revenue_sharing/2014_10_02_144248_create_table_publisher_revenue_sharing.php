<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePublisherRevenueSharing extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publisher_revenue_sharing', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('publisher_id');
			$table->tinyInteger('tax');
			$table->tinyInteger('management_free');
			$table->boolean('split_billing');
			$table->tinyInteger('revenue_sharing');
			$table->boolean('primium_publisher');
			$table->boolean('domain_checking');
			$table->boolean('vast_tag');
			$table->boolean('network_publisher');
			$table->boolean('mobile_ad');
			$table->boolean('access_to_all_channels');
			$table->boolean('newsletter');
			$table->boolean('enable_report_by_model');
			$table->string('company_name',255);
			$table->string('name_contact',255);
			$table->string('email_contact',255);
			$table->string('phone_contact',255);
			$table->text('address_contact');
			$table->tinyInteger('flag_check_type_name_company');
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
		Schema::drop('publisher_revenue_sharing');
	}

}
