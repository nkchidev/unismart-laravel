<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = ['fullname','email','ship_address','phone_number'];

    function order(){
        return $this->hasMany('App\Models\Order');
    }
}
