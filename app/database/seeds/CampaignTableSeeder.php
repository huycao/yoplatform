<?php
class CampaignTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 50; $i++)
        {
            $create = $faker->dateTimeThisMonth();
            DB::table('campaign')->insert(array(
                'title'          => $faker->sentence(rand(3,6)) ,
                'start_campaign' => $faker->dateTimeThisMonth() ,
                'end_campaign'   => $faker->dateTimeBetween('+1 day','+2 month') ,
                'status'         => $faker->numberBetween(0,1),
                'created_at'     => $create,
                'updated_at'     => $create
            ));
        }

        $this->command->info('Campaign table seeded!');
    }

}

