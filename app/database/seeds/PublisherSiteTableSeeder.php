<?php

class PublisherSiteTableSeeder extends Seeder {

	public function run()
	{
		$listPublisher = PublisherBaseModel::where('status',3)->lists('id');
		$faker = Faker\Factory::create();

		for ($i = 0; $i < 1000; $i++)
		{
			$create = $faker->dateTimeThisMonth();

			DB::table('publisher_site')->insert(array(
				'name' 					=> 	$faker->domainWord,
				'publisher_id'			=>	$faker->randomElement($listPublisher),
				'created_at' 			=>	$create,
				'updated_at' 			=>	$create
			));
		}
	}

}