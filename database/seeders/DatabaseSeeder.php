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
            GivenHoursSeeder::class,  // Crée les heures données (doit se faire après ResourceSeeder)
            RoleUserSeeder::class,    // Associe les rôles aux utilisateurs (doit se faire après UserSeeder)
            PdfSeeder::class,         // Crée les PDFs si nécessaire
        ]);
    }
}
