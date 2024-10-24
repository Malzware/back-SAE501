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
        'resource_id',
    ];

    // Définir la relation avec le modèle User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Définir la relation avec le modèle Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Définir la relation avec le modèle Resource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
