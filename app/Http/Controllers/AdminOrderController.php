<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'order']);
            return $next($request);
        });
    }

    function show(Request $request){
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }

        $status = $request->input('status');
        if($status == 'being_transported'){
            $list_act = [
                'processing' => 'Đang xử lý',
                'success' => 'Hoàn thành',
                'cancelled'=> 'Hủy đơn hàng',
            ];
            $orders = Order::where([
                ['status' , 'being_transported'],
                ['fullname' , 'like', "%{$keyword}%"]
                ])
            ->join('guests', 'guests.id', '=', 'orders.id')
            ->paginate(5);
        }else if($status == 'success'){
            $list_act = [
                'processing' => 'Đang xử lý',
                'being_transported' => 'Đang vận chuyển',
                'cancelled'=> 'Hủy đơn hàng'
            ];
            $orders = Order::where([
                ['status' , 'success'],
                ['fullname' , 'like', "%{$keyword}%"]
                ])
            ->join('guests', 'guests.id', '=', 'orders.id')
            ->paginate(5);
        }else if($status == 'cancelled'){
            $list_act = [
                'processing' => 'Đang xử lý',
                'being_transported' => 'Đang vận chuyển',
                'success' => 'Hoàn thành'
            ];
            $orders = Order::where([
                ['status' , 'cancelled'],
                ['fullname' , 'like', "%{$keyword}%"]
                ])
            ->join('guests', 'guests.id', '=', 'orders.id')
            ->paginate(5);
        }else{
            $list_act = [
                'being_transported' => 'Đang vận chuyển',
                'success' => 'Hoàn thành',
                'cancelled'=> 'Hủy đơn hàng'
            ];
            $orders = Order::where([
                ['status' , 'processing'],
                ['fullname' , 'like', "%{$keyword}%"],
            ])
            ->join('guests', 'guests.id', '=', 'orders.id')
            ->paginate(5);
        }
        $count_order_processing = Order::where('status', 'processing')->count();
        $count_order_being_transported = Order::where('status', 'being_transported')->count();
        $count_order_success = Order::where('status', 'success')->count();
        $count_order_cancelled = Order::where('status', 'cancelled')->count();
        $count = [
            $count_order_processing,
            $count_order_being_transported,
            $count_order_success,
            $count_order_cancelled
        ];
        return view('admin.order.show',compact('orders','count','list_act'));
    }

    function detail($id){
        $order = Order::find($id);
        return view('admin.order.detail', compact('order'));
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        $act = $request->input('act');
        if(!empty($list_check)){
            if($act == "processing"){
                Order::whereIn('id', $list_check)->update([
                    'status' => 'processing'
                ]);
                return redirect('admin/order/list?status=processing')->with('status', 'Cập nhật đơn hàng thành công');
            }

            if($act == "being_transported"){
                Order::whereIn('id', $list_check)->update([
                    'status' => 'being_transported'
                ]);
                return redirect('admin/order/list?status=being_transported')->with('status','Cập nhật đơn hàng thành công');
            }

            if($act == "success"){
                Order::whereIn('id', $list_check)->update([
                    'status' => 'success'
                ]);
                return redirect('admin/order/list?status=success')->with('status', 'Cập nhật đơn hàng thành công');
            }

            if($act == "cancelled"){
                Order::whereIn('id', $list_check)->update([
                    'status' => 'cancelled'
                ]);
                return redirect('admin/order/list?status=cancelled')->with('status', 'Cập nhật đơn hàng thành công');
            }
        }else{
            return redirect("admin/order/list")->with('status', 'Bạn cần chọn ít nhất một bản ghi để thao tác');
        }
    }

    function edit(Request $request,$id){
        $status = $request->input('status');
        Order::find($id)->update([
            'status' => $status
        ]);
        return redirect("admin/order/list?status={$status}")->with('status', 'Cập nhật đơn hàng thành công');
    }
}
