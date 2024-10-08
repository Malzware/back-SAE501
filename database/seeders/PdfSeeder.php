<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pdf;
use Faker\Factory as Faker;

class PdfSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Créer 10 PDFs
        for ($i = 0; $i < 10; $i++) {
            Pdf::create([
                'user_id' => rand(1, 10), // Supposant que vous avez 10 utilisateurs
                'pdf_name' => $faker->word . '.pdf',
                'pdf_path' => $faker->filePath(),
                'pdf_token' => $faker->uuid(), // Assurez-vous d'ajouter une valeur ici
                'signed' => $faker->boolean(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
