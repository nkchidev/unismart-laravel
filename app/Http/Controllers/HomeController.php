<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        // $product_celling = Product::where([
        //     ['celling','yes'],
        //     ['status', 'public']
        // ])->get();

        // $product_outstanding =Product::where([
        //     ['outstanding','yes'],
        //     ['status','public']
        // ])->get();
        $list_product = Product::select("products.*","categories.parent_id")
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('status','public')
        ->get();
        // foreach($list_product as $item){
        //     if($item->outstanding == "yes" && $item->status == "public"){
        //         echo $item->name;
        //     }
        // }
        // dd($list_product);
        return view('guest.home',compact('list_product','categories'));
    }

}
