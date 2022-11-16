<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller
{
    function show($slug,$cate_id){
        $cate = Category::find($cate_id);
        $categories = Category::all();
        $list_product = Product::select('products.*')
        ->join('categories', 'categories.id','=', 'products.category_id')
        ->where([
            ['categories.id',$cate_id],
            ['status','public']
        ])
        ->orWhere([
            ['categories.parent_id', $cate_id],
            ['status','public']
        ])
        ->paginate(20);
        return view('guest.product.show',compact('categories', 'list_product', 'cate'));
    }

    function detail($id){
        $categories = Category::all();
        $product = Product::find($id);
        $same_category = Product::whereNotIn('id',[$id])
        ->where('status','public')
        ->get();
        // return view('guest.cart.show');
        return view('guest.product.detail', compact('categories','product','same_category'));
    }

    function search(Request $request){
        $categories = Category::all();
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        $list_product = Product::where([
            ['status','public'],
            ['name', 'like', "%{$keyword}%"]
        ])->paginate(10);
        return view('guest.product.search', compact('categories', 'list_product'));
    }

}
