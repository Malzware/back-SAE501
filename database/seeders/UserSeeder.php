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

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'lastname' => $faker->lastName(),
                'firstname' => $faker->firstName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('password'), // Utiliser bcrypt pour hacher le mot de passe
                // Les colonnes created_at et updated_at sont automatiquement gérées par Eloquent
            ]);
        }
    }
}
