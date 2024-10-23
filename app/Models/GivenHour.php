<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivenHour extends Model
{
    protected $fillable = [
        'resource_id', 'user_id', 'semester_id', 'hours_cm', 'hours_td', 'hours_tp', 'comment'
        'hours_cm', 'hours_td', 'hours_tp', 'resource_id', 'user_id'
    ];

    // Relation avec Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    public function semester() {
        return $this->belongsTo(Semester::class);
    }
}
