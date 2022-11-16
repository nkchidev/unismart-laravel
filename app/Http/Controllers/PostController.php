<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Str;


class PostController extends Controller
{
    //
    function show(){
        $list_product = Product::select("products.*","categories.parent_id")
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('status','public')
        ->paginate(12);
        $posts = Post::paginate(5);
        return view('guest.post.show',compact('posts','list_product'));
    }

    function detail($category = "danh-muc",$slug,$id){
        $list_product = Product::select("products.*","categories.parent_id")
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('status','public')
        ->paginate(12);
        $post = Post::find($id);
        return view('guest.post.detail',compact('post','list_product'));
    }
}
