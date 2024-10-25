<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivenHour extends Model
{
    protected $fillable = [
        'hours_cm', 'hours_td', 'hours_tp', 'resource_id', 'user_id'
    ];

    // Relation avec Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    // Relation avec User
    public function user()  // Correction de la relation avec User
    {
        return $this->belongsTo(User::class);
    }
}