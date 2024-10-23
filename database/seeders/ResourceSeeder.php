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

        // Tableaux pour garder une trace des noms et des codes uniques
        $uniqueNames = [];
        $uniqueCodes = [];

        // Boucle pour créer 10 ressources
        for ($i = 0; $i < 10; $i++) {
            // Générer un nom unique
            do {
                $name = $faker->word();
            } while (in_array($name, $uniqueNames));
            $uniqueNames[] = $name; // Ajouter le nom au tableau des noms uniques

            // Générer un code de ressource unique
            do {
                $resourceCode = $faker->unique()->word();
            } while (in_array($resourceCode, $uniqueCodes));
            $uniqueCodes[] = $resourceCode; // Ajouter le code au tableau des codes uniques

            Resource::create([
                'name' => $name, // Nom de la ressource
                'resource_code' => $resourceCode, // Code de la ressource
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
