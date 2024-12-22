<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Guest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function guestLogin()
    {
        return view('guest.account.login');
    }

    public function guestRegister()
    {
        return view('guest.account.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:guests',
            'phone_number' => 'required|string|max:20',
            'ship_address' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ], [
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',
            'required' => 'Trường :attribute là bắt buộc.',
        ]);
        // Tạo OTP
        $otp = rand(100000, 999999);

        // Lưu thông tin user tạm thời vào session
        session([
            'temp_user' => [
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'ship_address' => $request->ship_address,
                'password' => Hash::make($request->password),
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5)
            ]
        ]);
        // Gửi email OTP
        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Mã xác thực OTP - Đăng ký tài khoản');
            });
        } catch (\Exception $e) {
            \Log::error('Mail error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi email OTP. Vui lòng thử lại sau.'
            ], 500);
        }
        return response()->json([
            'success' => true,
            'message' => 'OTP đã được gửi đến email của bạn'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $tempUser = session('temp_user');

        if (!$tempUser) {
            return response()->json([
                'success' => false,
                'message' => 'Phiên đăng ký đã hết hạn'
            ]);
        }
        if ($request->otp != $tempUser['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP không chính xác'
            ]);
        }
        if (now()->isAfter($tempUser['otp_expires_at'])) {
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP đã hết hạn'
            ]);
        }

        try {
            // Tạo guest mới
            $guest = Guest::create([
                'fullname' => $tempUser['fullname'],
                'email' => $tempUser['email'],
                'phone_number' => $tempUser['phone_number'],
                'ship_address' => $tempUser['ship_address'],
                'password' => $tempUser['password'],
            ]);

            // Xóa thông tin tạm thời
            session()->forget('temp_user');

            return response()->json([
                'success' => true,
                'message' => 'Đăng ký thành công',
                'redirect_url' => route('guest-login')
            ]);
        } catch (\Exception $e) {
            \Log::error('Guest creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo tài khoản. Vui lòng thử lại.'
            ], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        $tempUser = session('temp_user');

        if (!$tempUser) {
            return response()->json([
                'success' => false,
                'message' => 'Phiên đăng ký đã hết hạn'
            ]);
        }
        // Tạo OTP mới
        $otp = rand(100000, 999999);

        // Cập nhật OTP mới
        $tempUser['otp'] = $otp;
        $tempUser['otp_expires_at'] = now()->addMinutes(5);
        session(['temp_user' => $tempUser]);

        try {
            // Gửi email OTP mới
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($tempUser) {
                $message->to($tempUser['email'])
                    ->subject('Mã xác thực OTP - Đăng ký tài khoản');
            });
        } catch (\Exception $e) {
            \Log::error('Mail error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi lại mã OTP. Vui lòng thử lại sau.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi lại mã OTP'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $guest = Guest::where('email', $credentials['email'])->first();

            if (!$guest || !Hash::check($credentials['password'], $guest->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email hoặc mật khẩu không chính xác'
                ], 401);
            }

            // Tạo OTP
            $otp = rand(100000, 999999);
            
            // Lưu thông tin login tạm thời vào session
            session([
                'login_temp' => [
                    'guest_id' => $guest->id,
                    'otp' => $otp,
                    'otp_expires_at' => now()->addMinutes(5)
                ]
            ]);
            
            // Gửi email OTP
            try {
                Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($guest) {
                    $message->to($guest->email)
                        ->subject('Mã xác thực OTP - Đăng nhập');
                });
            } catch (\Exception $e) {
                \Log::error('Mail error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể gửi email OTP. Vui lòng thử lại sau.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP đã được gửi đến email của bạn',
                'show_otp' => true
            ]);

        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đăng nhập. Vui lòng thử lại.'
            ], 500);
        }
    }

    public function verifyLoginOtp(Request $request)
    {
        $loginTemp = session('login_temp');

        if (!$loginTemp) {
            return response()->json([
                'success' => false,
                'message' => 'Phiên đăng nhập đã hết hạn'
            ]);
        }

        if ($request->otp != $loginTemp['otp']) {
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP không chính xác'
            ]);
        }

        if (now()->isAfter($loginTemp['otp_expires_at'])) {
            return response()->json([
                'success' => false,
                'message' => 'Mã OTP đã hết hạn'
            ]);
        }

        try {
            $guest = Guest::find($loginTemp['guest_id']);
            
            if (!$guest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy tài khoản'
                ]);
            }

            // Đăng nhập thành công
            Auth::guard('guest')->login($guest);
            
            // Xóa thông tin tạm thời
            session()->forget('login_temp');

            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'redirect_url' => route('home')
            ]);
        } catch (\Exception $e) {
            \Log::error('Login verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xác thực. Vui lòng thử lại.'
            ], 500);
        }
    }

    public function logout()
    {
        try {
            Auth::guard('guest')->logout();
            
            return response()->json([
                'success' => true,
                'message' => 'Đăng xuất thành công',
                'redirect_url' => url('/')
            ]);
        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đăng xuất'
            ], 500);
        }
    }

    protected function guard()
    {
        return Auth::guard('guest');
    }
}
