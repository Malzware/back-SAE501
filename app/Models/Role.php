<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // Relation avec User via la table pivot role_user
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user')
                    ->withPivot('resource_id')
                    ->withTimestamps();
    }
}