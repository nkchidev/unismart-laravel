<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['cat_title', 'slug','parent_id'];

    function post(){
        return $this->hasMany('App\Models\Post');
    }

    function product(){
        return $this->hasMany('App\Models\Product');
    }
}
