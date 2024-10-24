<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        'role_id',
        'resource_id', // Champ supplémentaire pour la ressource unique
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    // Relation avec plusieurs ressources (relation plusieurs à plusieurs)
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'resource_role_user');
    }
}
