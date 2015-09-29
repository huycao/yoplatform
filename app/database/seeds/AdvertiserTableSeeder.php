<?php

class AdvertiserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 0; $i < 1000; $i++)
		{
			$create = $faker->dateTimeThisMonth();
			DB::table('advertiser')->insert(array(
				'name' 			=> 	$faker->company,
				'country_id'	=>	$faker->numberBetween(1,242),
				'status'		=>	$faker->numberBetween(0,1),
				'type'			=>	$faker->randomElement(array('agency','direct')),
				'created_at' 	=>	$create,
				'updated_at' 	=>	$create
			));
		}
	}

}