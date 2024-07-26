<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User_app extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'user_app_consumer';

    protected $fillable = [
        'mobile',
        'bearer_token',
        'location',
        'user_profile',
        'email',
        'name'

    ];
}
