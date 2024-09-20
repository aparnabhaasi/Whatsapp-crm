<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'message_id',
        'sender',
        'message',
        'type',
        'media_url',
        'media_type',
        'media_caption',
        'is_read',
    ];

    // Relationship with Contacts
    public function contact()
    {
        return $this->belongsTo(Contacts::class, 'contact_id');
    }
}
