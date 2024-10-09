<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    // SpÃ©cifiez le nom de la table
    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        'role_id',
        'resource_id',
    ];
}