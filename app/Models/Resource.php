<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $fillable = [
        'name', 'resource_code', 'title', 'id_semester', 'cm', 'td', 'tp',
        'national_total', 'national_tp', 'adapt', 'adapt_tp', 'projet_ne', 'projet_e', 'comment'
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester');
    }

    public function givenHours()
    {
        return $this->hasMany(GivenHour::class, 'resource_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'resource_id', 'user_id');
    }

    // Ajoutez cette méthode pour récupérer les RoleUser associés à cette ressource
    public function roleUsers()
    {
        return $this->hasMany(RoleUser::class, 'resource_id');
    }
}

