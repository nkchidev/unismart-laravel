<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','slug','price','describe', 'detail','avatar', 'outstanding','celling','category_id','product_status','status'];
    function category(){
        return $this->belongsTo('App\Models\Category');
    }

    function product_image(){
        return $this->hasMany('App\Models\Product_image');
    }

    function order_detail(){
        return $this->hasOne('App\Models\OrderDetail');
    }
}
