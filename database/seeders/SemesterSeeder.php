<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;
use Faker\Factory as Faker;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 6; $i++) {
            Semester::create([
                'name' => $faker->word(),
                'career' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
