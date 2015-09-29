<?php

class PublisherSiteAdZoneTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 0; $i < 1000; $i++)
		{
			$create = $faker->dateTimeThisMonth();

			DB::table('publisher_ad_zone')->insert(array(
				'name' 					=> 	$faker->randomElement(array(
												'Leaderboard',
												'Rectangle',
												'Balloon',
												'header banner',
												'Skyscraper',
												'Pre-roll'
											)),
				'siteid'				=>	$faker->numberBetween(1,1000),
				'created_at' 			=>	$create,
				'updated_at' 			=>	$create
			));
		}
	}

}