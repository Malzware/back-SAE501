<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GivenHour extends Model
{
    protected $fillable = [
        'resource_id', 'user_id', 'semester_id', 'hours_cm', 'hours_td', 'hours_tp', 'comment'
    ];

    // Relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    public function semester() {
        return $this->belongsTo(Semester::class);
    }
}