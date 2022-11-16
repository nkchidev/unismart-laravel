<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Guest;
use App\Models\Order;
use App\Models\OrderDetail;

class CheckoutController extends Controller
{
    function show(){
        return view('guest.checkout.show');
    }

    function store(Request $request){
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'ship_address' => 'required',
                'phone_number' => 'required|numeric|digits:10',
                'payment-method' => 'required'
            ],
            [
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'required' => ':attribute không được để trống',
                'numeric' => 'Dữ liệu này không phải là số điện thoại :attribute',
                'digits' => ':attribute có độ dài là :digits ký tự'
            ],
            [
                'fullname' => 'Họ và tên',
                'ship_address' => 'Địa chỉ',
                'phone_number' => 'Số điện thoại',
                'payment-method' => 'Phương thức thanh toán',
            ]
        );
        $input = $request->input();
        $guest = Guest::create($input);
        $dataOrder = [
            'guest_id' => $guest->id,
            'num_order' => Cart::count(),
            'total' => Cart::total(),
            'status' => 'processing',
            'payment_method' => $request->input('payment-method'),
            'note' => $request->input('note'),
        ];
        $order = Order::create($dataOrder);
        foreach(Cart::content() as $product){
            $dataOrderDetail = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $product->qty,
                'total' => $product->total
            ];
            OrderDetail::create($dataOrderDetail);
        }
        return redirect()->route('sendmail', $order->id);
    }

    function success(){
        Cart::destroy();
        return view('guest.checkout.success');
    }
}
