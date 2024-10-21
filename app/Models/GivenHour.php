<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivenHour extends Model
{
    protected $fillable = [
        'hours_cm', 'hours_td', 'hours_tp', 'comment', 'resource_id'
    ];

    // Relation avec Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
