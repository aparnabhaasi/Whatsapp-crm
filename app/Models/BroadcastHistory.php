<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastHistory extends Model
{
    use HasFactory;
    protected $table = 'broadcast_history';
    // Specify fillable fields for mass assignment
    protected $fillable = [
        'broadcast_id',
        'total_contacts',
        'accepted',
        'rejected',
        'is_read',
        'created_at',
        'updated_at',
    ];
    public $timestamps = true;
}