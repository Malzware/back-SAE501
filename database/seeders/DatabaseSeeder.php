<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Appel des seeders dans le bon ordre
        $this->call([
            UserSeeder::class,        // Crée les utilisateurs
            SemesterSeeder::class,    // Crée les semestres (si nécessaire)
            ResourceSeeder::class,    // Crée les ressources
            RoleSeeder::class,        // Crée les rôles
            RoleUserSeeder::class,    // Associe les rôles aux utilisateurs (doit se faire après UserSeeder)
            GivenHoursSeeder::class,  // Je crée les ressources, je les associes aux users et ensuite j'attribue des heures
            PdfSeeder::class,         // Crée les PDFs si nécessaire
        ]);
    }
}
