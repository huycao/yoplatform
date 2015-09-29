<?php

class PublisherTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 0; $i < 100; $i++)
		{
			$create = $faker->dateTimeThisMonth();

			DB::table('publisher')->insert(array(
				'first_name' 			=> 	$faker->firstName($gender = null|'male'|'female'),
				'last_name' 			=> 	$faker->lastName,
				//'title' 				=> 	$faker->title($gender = 'Mr'|'Mrs'|'Ms'),
				'company' 				=> 	$faker->company,
				'city' 				 	=> 	$faker->city,
				'address' 				=> 	$faker->address,
				'postcode' 				=> 	$faker->postcode,
				'country' 				=> 	$faker->country,
				'payment_to' 			=> 	$faker->creditCardNumber,
				'phone' 				=> 	$faker->phoneNumber,
				'fax' 					=> 	$faker->phoneNumber,
				
				'site_name' 			=> 	$faker->domainName,
				'site_url' 				=> 	$faker->url,
				'site_description' 		=> 	$faker->state,
				'category' 				=> 	$faker->numberBetween(1,3),
				
				'traffic_report_file' 	=> 	$faker->md5,
				'pageview' 				=>	$faker->numberBetween(5000,10000000),
				'unique_visitor' 		=> 	$faker->numberBetween(5000,10000000),
				'email' 				=> 	$faker->email,
				'status'				=>	$faker->numberBetween(0,3),
				'created_at' 			=>	$create,
				'updated_at' 			=>	$create
			));
		}
	}

}