<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast_messages extends Model
{
    use HasFactory;

    protected $table = 'broadcast_messages';

    public function broadcast()
    {
        return $this->belongsTo(Broadcasts::class, 'broadcast_id');
    }
}
