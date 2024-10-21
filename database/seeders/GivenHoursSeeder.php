<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\GivenHour;
use Faker\Factory as Faker;

class GivenHoursSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Récupérer toutes les ressources
        $resources = Resource::all();

        foreach ($resources as $resource) {
            // Création d'un enregistrement pour les heures données
            GivenHour::create([
                'resource_id' => $resource->id, // Lier à la ressource
                'hours_cm' => rand(1, 10),      // Cours magistraux (entre 1 et 10 heures)
                'hours_td' => rand(1, 10),      // Travaux dirigés (entre 1 et 10 heures)
                'hours_tp' => rand(1, 10),      // Travaux pratiques (entre 1 et 10 heures)
                'comment' => $faker->sentence,  // Commentaire généré aléatoirement
            ]);
        }
    }
}
