<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    protected $fillable = [
        'user_id', 'pdf_name', 'pdf_path', 'pdf_token', 'signed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}