<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GivenHour;
use Faker\Factory as Faker;

class GivenHoursSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            GivenHour::create([
                'resource_id' => rand(1, 10), 
                'user_id' => rand(1, 10), 
                'hours_cm' => $faker->randomDigit(),
                'hours_td' => $faker->randomDigit(),
                'hours_tp' => $faker->randomDigit(),
                'comment' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
