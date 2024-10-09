<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['name', 'career'];

    // Relation avec Resource
    public function resources()
    {
        return $this->hasMany(Resource::class, 'id_semester');
    }
}