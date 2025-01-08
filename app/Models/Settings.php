<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    use HasFactory;
    protected $fillable = [
        'account_id',
        'phone_number_id',
        'phone_number',
        'access_token',
        'meta_app_id',
        'app_id', // Make sure app_id is also in the fillable property
    ];
}
