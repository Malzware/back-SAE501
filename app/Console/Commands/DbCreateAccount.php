<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DbCreateAccount extends Command
{
    protected $signature = 'app:create_account';
    protected $description = 'Create a new admin account';

    public function handle()
    {
        $user = new User;
        $user->lastname = "admin";
        $user->firstname = "admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt("admin");
        $user->save();

        $user->roles()->attach(1);

        $this->info('Admin account created successfully!');
    }
}