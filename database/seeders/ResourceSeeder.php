<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use Faker\Factory as Faker;

class ResourceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Créer 10 ressources
        for ($i = 0; $i < 10; $i++) {
            Resource::create([
                'name' => $faker->word(),
                'resource_code' => $faker->unique()->word(),
                'title' => $faker->sentence(),
                'id_semester' => rand(1, 5), // Assume there are 5 semesters
                'cm' => $faker->randomDigit(),
                'td' => $faker->randomDigit(),
                'tp' => $faker->randomDigit(),
                'national_total' => $faker->randomDigit(),
                'national_tp' => $faker->randomDigit(),
                'adapt' => $faker->randomDigit(),
                'adapt_tp' => $faker->randomDigit(),
                'projet_ne' => $faker->randomDigit(),
                'projet_e' => $faker->randomDigit(),
                'comment' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
