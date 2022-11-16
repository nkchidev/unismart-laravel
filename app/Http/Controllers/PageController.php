<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Product;

class PageController extends Controller
{
    function show($id){
        $list_product = Product::select("products.*","categories.parent_id")
        ->join('categories', 'categories.id', '=', 'products.category_id')
        ->where('status','public')
        ->paginate(12);
        $page = Page::find($id);
        return view('guest.page.show',compact('page','list_product'));
    }
}
