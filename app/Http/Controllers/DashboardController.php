<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function show(){
        $orders = Order::orderBy('id','desc')->paginate(10);
        $sales = Order::all()->sum('total');
        $count_order_success = Order::where('status', 'success')->count();
        $count_order_processing = Order::where('status', 'processing')->count();
        $count_order_cancelled = Order::where('status', 'cancelled')->count();
        $count = [
            $count_order_success,
            $count_order_processing,
            $count_order_cancelled
        ];
        return view('admin.dashboard',compact('orders','count','sales'));
    }
}
