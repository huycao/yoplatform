<?php

class PaymentHistorySeeder extends Seeder {

    public function run() {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $create = $faker->dateTimeThisYear();
            $earning = $faker->numberBetween(8000, 12000);
            DB::table('payment_history')->insert(array(
                'publisher_id' => 11,
                'campaign_id' => $faker->numberBetween(1, 2),
                'earning' => $earning, 
                'balance' => $earning ,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => $create,
                'updated_at' => $create
            ));
        }
    }

}
