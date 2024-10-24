<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesters = [
            ['name' => '1', 'career' => ''],
            ['name' => '2', 'career' => ''],
            ['name' => '3', 'career' => ''],
            ['name' => '4', 'career' => 'Commun'],
            ['name' => '4', 'career' => 'Créa'],
            ['name' => '4', 'career' => 'Dev'],
            ['name' => '5', 'career' => 'Commun'],
            ['name' => '5', 'career' => 'Créa'],
            ['name' => '5', 'career' => 'Dev'],
            ['name' => '6', 'career' => 'Commun'],
            ['name' => '6', 'career' => 'Créa'],
            ['name' => '6', 'career' => 'Dev'],
        ];

        foreach ($semesters as $semester) {
            Semester::create($semester);
        }
    }
}
