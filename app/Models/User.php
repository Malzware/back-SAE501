<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'password',
    ];

    // Relations
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
        // Relation avec Role via role_user
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withPivot('resource_id');
    }

    // Relation avec Resource via role_user
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'role_user', 'user_id', 'resource_id');
        return $this->belongsToMany(Resource::class, 'role_user');
    }

    // Relation avec GivenHour
    public function givenHours()
    {
        return $this->hasMany(GivenHour::class, 'user_id');
        return $this->hasMany(GivenHour::class);
    }

    // Relation avec Pdf
    public function pdfs()
    {
        return $this->hasMany(Pdf::class);
    }
}
