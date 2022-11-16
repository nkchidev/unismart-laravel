<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Guest;
use App\Models\Order;
use App\Models\OrderDetail;

class CartController extends Controller
{
    //
    function add(Request $request, $id){
        $num_order = 1;
        if($request->input('num_order')){
            $num_order = $request->input('num_order');
        }
        $product = Product::find($id);
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $num_order,
            'price' => $product->price,
            'options' => ['thumbnail' => $product->avatar]
        ]);
        return redirect()->route('cart.show');
    }

    function show(){
        return view('guest.cart.show');
    }

    function delete($rowId){
        Cart::remove($rowId);
        return redirect()->route('cart.show');
    }

    function destroy(){
        Cart::destroy();
        return redirect()->route('cart.show');
    }

    function update(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        $item = Cart::get($rowId);
        $sub_total = $item->total;
        $total = Cart::total();
        $data = array(
            'sub_total' => number_format($sub_total,0,'','.'),
            'total' => number_format($total,0,'','.')
        );
        echo json_encode($data);
    }

}
