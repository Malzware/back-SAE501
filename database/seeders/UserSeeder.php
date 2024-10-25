<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'firstname' => $faker->firstName(),
            'lastname' => $faker->lastName(),
            'email' => $faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Utiliser un mot de passe par défaut
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}