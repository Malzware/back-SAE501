<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleUser;
use App\Models\User; // Assurez-vous d'importer le modèle User
use App\Models\Role; // Assurez-vous d'importer le modèle Role
use Faker\Factory as Faker; // Importez Faker si vous l'utilisez

class RoleUserSeeder extends Seeder
{
    public function run()
    {
<<<<<<< Updated upstream
        foreach (range(1, 10) as $userId) {
            foreach (range(1, 3) as $roleId) { 
                RoleUser::create([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                    'resource_id' => rand(1, 10), 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
=======
        // Récupérer tous les rôles disponibles
        $roles = Role::all()->pluck('id')->toArray();

        // Associer un rôle aléatoire à chaque utilisateur
        foreach (User::all() as $user) {
            RoleUser::create([
                'user_id' => $user->id, // Utilisez l'identifiant de l'utilisateur
                'role_id' => random_int(1, count($roles)), // Assignation aléatoire d'un rôle
                'resource_id' => rand(1, 10), // Suppose que vous avez 10 ressources
                'created_at' => now(),
                'updated_at' => now(),
            ]);
>>>>>>> Stashed changes
        }
    }
}
