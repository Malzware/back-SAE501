<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class db_create_account extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = new User;
        $user->lastname = "admin";
        $user->firstname = "admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt("admin");
        $user->save();

        $user->roles()->attach(1);
    }
}
