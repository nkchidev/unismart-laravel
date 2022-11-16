<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'guest_id',
        'num_order',
        'total',
        'status',
        'payment_method',
        'note',
        'created_at'
    ];
    function guest(){
        return $this->belongsTo('App\Models\Guest');
    }

    function order_detail(){
        return $this->hasMany('App\Models\OrderDetail');
    }
}
