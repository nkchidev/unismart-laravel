<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Guest;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guest');
    }

    function show(){
        if (!auth()->guard('guest')->check()) {
            return redirect()->route('guest-login')->with('error', 'Vui lòng đăng nhập để tiếp tục thanh toán');
        }
        return view('guest.checkout.show');
    }

    function store(Request $request){
        $request->validate(
            [
                'ship_address' => 'required',
                'payment-method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'ship_address' => 'Địa chỉ',
                'payment-method' => 'Phương thức thanh toán',
            ]
        );

        $dataOrder = [
            'guest_id' => auth()->guard('guest')->id(),
            'ship_address' => $request->input('ship_address'),
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
        if (!session()->has('last_order')) {
            return redirect()->route('home');
        }
        
        $orderData = session('last_order');
        Cart::destroy(); // Xóa giỏ hàng sau khi hiển thị trang success
        session()->forget('last_order'); // Xóa session order
        
        return view('guest.checkout.success', compact('orderData'));
    }

    public function verify(Request $request)
    {
        if (!auth()->guard('guest')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để tiếp tục'
            ], 401);
        }

        $request->validate([
            'ship_address' => 'required',
            'payment_method' => 'required'
        ]);

        try {
            // Tạo OTP
            $otp = rand(100000, 999999);
            
            // Lưu thông tin đơn hàng tạm thời vào session
            session([
                'checkout_temp' => [
                    'ship_address' => $request->ship_address,
                    'payment_method' => $request->payment_method,
                    'otp' => $otp,
                    'otp_expires_at' => now()->addMinutes(5)
                ]
            ]);
            
            // Gửi email OTP
            Mail::send('emails.otp', ['otp' => $otp], function ($message) {
                $message->to(auth()->guard('guest')->user()->email)
                    ->subject('Mã xác thực OTP - Xác nhận đơn hàng');
            });

            return response()->json([
                'success' => true,
                'message' => 'OTP đã được gửi đến email của bạn'
            ]);
        } catch (\Exception $e) {
            \Log::error('Checkout verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $checkoutTemp = session('checkout_temp');

        if (!$checkoutTemp) {
            return response()->json([
                'success' => false,
                'message' => 'Phiên đã hết hạn'
            ]);
        }

        if ($request->otp != $checkoutTemp['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP không chính xác'
            ]);
        }

        if (now()->isAfter($checkoutTemp['otp_expires_at'])) {
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP đã hết hạn'
            ]);
        }

        try {
            // Tạo đơn hàng
            $order = Order::create([
                'guest_id' => auth()->guard('guest')->id(),
                'ship_address' => $checkoutTemp['ship_address'],
                'payment_method' => $checkoutTemp['payment_method'],
                'total' => Cart::total(),
                'num_order' => Cart::count(),
                'status' => 'processing',
                'note' => null
            ]);

            // Tạo order details và lưu thông tin cart items
            $cartItems = Cart::content()->map(function($item) {
                return [
                    'name' => $item->name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->total,
                    'thumbnail' => $item->options->thumbnail
                ];
            })->toArray();
            
            session(['last_order' => [
                'id' => $order->id,
                'items' => $cartItems,
                'total' => Cart::total()
            ]]);

            foreach(Cart::content() as $product){
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $product->qty,
                    'total' => $product->total
                ]);
            }

            // Xóa session checkout
            session()->forget('checkout_temp');
            Cart::destroy();

            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công',
                'redirect_url' => route('checkout.success')
            ]);

        } catch (\Exception $e) {
            \Log::error('Order creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo đơn hàng'
            ], 500);
        }
    }
}
