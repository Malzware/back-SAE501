<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users'; // Nom de la table (par défaut 'users' pour le modèle User)
    
    protected $fillable = [
        'lastname', 'firstname', 'email', 'password'
    ];

    // Relation avec Role via role_user
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
                    ->withPivot('resource_id');
    }

    // Relation avec Resource via role_user
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'role_user');
    }

    // Relation avec GivenHour
    public function givenHours()
    {
        return $this->hasMany(GivenHour::class);
    }

    // Relation avec Pdf
    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }
}