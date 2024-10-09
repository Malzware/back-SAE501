<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleUser;

class RoleUserSeeder extends Seeder
{
    public function run()
    {
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
        }
    }
}
