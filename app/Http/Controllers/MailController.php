<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AccuracyMail;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

class MailController extends Controller
{
    function sendmail($order_id){
        $order = Order::find($order_id);
        Mail::to($order->guest->email)->send(new AccuracyMail($order));
        return redirect()->route('checkout.success');
    }
}
