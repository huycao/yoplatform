<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePublisher extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('publisher', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name',35)->default('');
			$table->string('last_name',35)->default('');			
			$table->enum('title', array('Mr', 'Mrs', 'Ms'));
			$table->string('company',255)->default('');
			$table->string('name_of_owner',255);
			$table->string('city',255)->default('');
			$table->text('address');
			$table->string('state',255)->default('');
			$table->string('postcode',16);
			$table->string('country',255)->default('');
			$table->string('payment_to',255)->default('');
			$table->string('phone',16)->default('');
			$table->string('fax',16);
			$table->string('email',128);
			$table->string('site_name',128)->default('');	
			$table->string('site_url',128)->default('');		
			$table->text('site_description');
			$table->string('other_lang',255);
			$table->integer('category');
			$table->string('other_category',255);
			$table->integer('pageview');
			$table->integer('unique_visitor');
			$table->string('traffic_report_file',255);
			$table->text('reason');
			$table->boolean('status')->default(0);
			$table->string('name_contact',255);
			$table->string('email_contact',255);
			$table->string('phone_contact',255);
			$table->text('address_contact');
			$table->string('tmp_password',255);				
			$table->text('remark');
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
		Schema::drop('publisher');
	}

}
