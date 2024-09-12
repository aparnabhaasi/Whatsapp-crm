<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcasts extends Model
{
    use HasFactory;

    protected $table = 'broadcast';

    protected $fillable = ['contact_id', 'broadcast_name'];

    protected $casts = [
        'contact_id' => 'array',  // This will ensure it's treated as an array
    ];
}



