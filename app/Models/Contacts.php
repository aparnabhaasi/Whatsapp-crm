<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    public function chats()
    {
        return $this->hasMany(Chats::class, 'contact_id');
    }

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'tags',
        'app_id',
    ];
}
