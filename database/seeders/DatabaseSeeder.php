<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            SemesterSeeder::class,
            ResourceSeeder::class,
            RoleSeeder::class,
            GivenHoursSeeder::class,
            PdfSeeder::class,
            RoleUserSeeder::class,
            // Ajoutez d'autres seeders ici si nécessaire
        ]);
    }
}
