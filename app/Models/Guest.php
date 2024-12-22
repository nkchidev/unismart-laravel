<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Guest extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guard = 'guest';

    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'ship_address',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
