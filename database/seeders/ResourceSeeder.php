<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource; // Assurez-vous que le modèle est bien importé
use App\Models\Semester;
use Faker\Factory as Faker;

class ResourceSeeder extends Seeder
{
    public function run()
    {
        // Créer une instance de Faker
        $faker = Faker::create();

        // Boucle pour créer 10 ressources
        for ($i = 0; $i < 10; $i++) {
            Resource::create([
                'name' => $faker->word(), // Nom de la ressource
                'resource_code' => $faker->unique()->word(), // Code de la ressource
                'title' => $faker->sentence(), // Titre de la ressource
                'id_semester' => Semester::inRandomOrder()->first()->id,
                'national_total' => $faker->randomDigit(), // Total national (ex: heures)
                'national_tp' => $faker->randomDigit(), // Total TP national
                'adapt' => $faker->randomDigit(), // Adaptation
                'adapt_tp' => $faker->randomDigit(), // Adaptation TP
                'projet_ne' => $faker->randomDigit(), // Projet NE
                'projet_e' => $faker->randomDigit(), // Projet E
                'comment' => $faker->sentence(), // Commentaire
                // 'created_at' et 'updated_at' sont gérés automatiquement
            ]);
        }
    }
}
