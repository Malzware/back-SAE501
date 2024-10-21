<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleUser;
use App\Models\User;
use App\Models\Role;
use App\Models\Resource;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    public function run()
    {
        // Récupérer tous les rôles disponibles sous forme d'un tableau d'identifiants
        $roles = Role::all()->pluck('id')->toArray();

        // Récupérer tous les utilisateurs
        $users = User::all();

        // Récupérer toutes les ressources
        $resources = Resource::all()->pluck('id')->toArray();

        // Associer un rôle aléatoire et plusieurs ressources (ou aucune) à chaque utilisateur
        foreach ($users as $user) {
            // Choisir un rôle aléatoire pour cet utilisateur
            $roleId = $roles[array_rand($roles)];

            // Choisir aléatoirement 0 à 5 ressources à associer (ou laisser null)
            $randomResourceIds = rand(0, 1) ? array_rand($resources, rand(1, 5)) : null;

            // Si plusieurs ressources sont choisies, s'assurer que c'est un tableau
            if ($randomResourceIds !== null && !is_array($randomResourceIds)) {
                $randomResourceIds = [$randomResourceIds];
            }

            // Insérer une entrée dans role_user pour chaque ressource choisie
            if ($randomResourceIds) {
                foreach ($randomResourceIds as $resourceIndex) {
                    DB::table('role_user')->insert([
                        'user_id' => $user->id,
                        'role_id' => $roleId,
                        'resource_id' => $resources[$resourceIndex], // Associer une ressource spécifique
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                // Si pas de ressource choisie, créer avec resource_id NULL
                DB::table('role_user')->insert([
                    'user_id' => $user->id,
                    'role_id' => $roleId,
                    'resource_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
