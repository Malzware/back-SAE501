<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\GivenHour;
use App\Models\RoleUser;  // Importer le modèle RoleUser
use Faker\Factory as Faker;

class GivenHoursSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Récupérer toutes les ressources
        $resources = Resource::all();

        foreach ($resources as $resource) {
            // Récupérer tous les utilisateurs associés à cette ressource
            $roleUsers = RoleUser::where('resource_id', $resource->id)->get();

            // Créer des heures données pour chaque utilisateur associé
            foreach ($roleUsers as $roleUser) {
                GivenHour::create([
                    'resource_id' => $resource->id, // Lier à la ressource
                    'user_id' => $roleUser->user_id, // Lier à l'utilisateur trouvé
                    'hours_cm' => rand(1, 10),       // Cours magistraux (entre 1 et 10 heures)
                    'hours_td' => rand(1, 10),       // Travaux dirigés (entre 1 et 10 heures)
                    'hours_tp' => rand(1, 10),       // Travaux pratiques (entre 1 et 10 heures)
                ]);
            }
        }
    }
}
