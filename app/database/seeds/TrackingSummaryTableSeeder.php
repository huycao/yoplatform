<?php
class TrackingSummaryTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();
        $date_begin = strtotime('2014-10-08 00:00:00');
        $date_end = strtotime(date('2014-12-16 00:00:00'));
        for ($i = $date_begin; $i < $date_end; $i+= 86400)
        {   
            $date = strtotime($i);
            $flight_id = 3;
            $ad_flight = array(
                1   =>  1,
                2   =>  1,
                3   =>  2
            );

            $campaign_flight = array(
                1   =>  1,
                2   =>  1,
                3   =>  2,
                4   =>  2,
                5   =>  2
            );
			 
            $impression = $faker->numberBetween(4000,40000);

            $date = date('Y-m-d', $i);
            for($h = 0; $h < 24; $h++){
                $create = $faker->dateTimeThisMonth();
                DB::table('tracking_summary')->insert(array(
                    'ad_id'         => $ad_flight[$flight_id] ,
                    'flight_id'     => $faker->numberBetween(1,5) ,
                    'ad_format_id'     => $faker->numberBetween(1,5) ,
                    'publisher_site_id'     => $faker->numberBetween(1,5) ,
                    'flight_publisher_id'     => $faker->numberBetween(1,5) ,
                    'publisher_id'     =>$faker->numberBetween(1,5),
                    'campaign_id'   => $campaign_flight[$flight_id] ,
                    'impression'    => $impression,
                    'unique_impression'    => $impression -  $faker->numberBetween(1000,3000),
                    'click'         => $faker->numberBetween(300,800),
                    'firstquartile' => $faker->numberBetween(8000,12000),
                    'midpoint'      => $faker->numberBetween(2000,4000),
                    'thirdquartile' => $faker->numberBetween(1000,2000),
                    'complete'      => $faker->numberBetween(500,1000),
                    'mute'          => $faker->numberBetween(300,800),
                    'fullscreen'    => $faker->numberBetween(300,800),
                    'hour'          => $h,
                    'date'          => $date
                ));
            }
        }

        $this->command->info('tracking_summary table seeded!');
    }

}

