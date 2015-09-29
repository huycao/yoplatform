<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFlightPublisher extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flight_publisher', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',255);
			$table->enum('platform', array('web','mobile'))->default('web');
			$table->enum('type', array('adnetwork','premium'))->default('adnetwork');
			$table->integer('flight_id');
			$table->integer('sale_id');
			$table->integer('category_id');
			$table->integer('campaign_id');
			$table->integer('publisher_id');
			$table->integer('publisher_site_id');
			$table->integer('publisher_ad_zone_id');
			$table->integer('total_inventory');
			$table->integer('value_added');
			$table->enum('cost_type', array('cpm','cpc','cpv','cpe','cpa'));
			$table->decimal('base_media_cost', 26, 10);
			$table->decimal('media_cost', 26, 10);
			$table->decimal('real_base_media_cost', 26, 10);
			$table->decimal('real_media_cost', 26, 10);			
			$table->decimal('discount', 26, 10);
			$table->decimal('cost_after_discount', 26, 10);
			$table->decimal('total_cost_after_discount', 26, 10);
			$table->decimal('agency_commission', 26, 10);
			$table->decimal('cost_after_agency_commission', 26, 10);
			$table->decimal('advalue_commission', 26, 10);
			$table->decimal('publisher_base_cost', 26, 10);
			$table->decimal('publisher_cost', 26, 10);
			$table->decimal('total_profit', 26, 10);
			$table->decimal('sale_profit', 26, 10);
			$table->decimal('company_profit', 26, 10);
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
		Schema::drop('flight_publisher');
	}

}
