@extends('layouts.guest')

@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div id="wrapper" class="wp-inner clearfix">
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    <div class="section-detail">
                        <form method="POST" action="" name="form-checkout">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="fullname">Họ tên</label>
                                    <input type="text" name="fullname" id="fullname" value="{{ auth()->guard('web')->user()->fullname }}" readonly>
                                </div>
                                <div class="form-col fl-right">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="{{ auth()->guard('web')->user()->email }}" readonly>
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="address">Địa chỉ giao hàng</label>
                                    <input type="text" name="ship_address" id="address" required>
                                    @error('ship_address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" name="phone_number" id="phone" value="{{ auth()->guard('web')->user()->phone_number }}" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col">
                                    <label for="notes">Ghi chú</label>
                                    <textarea name="note"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="section" id="order-review-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin đơn hàng</h1>
                    </div>
                    <div class="section-detail">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $item)
                                    <tr class="cart-item">
                                        <td class="product-name">{{ $item->name }}<strong class="product-quantity">x {{ $item->qty }}</strong></td>
                                        <td class="product-total">{{ number_format($item->total,0,'','.') }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td><strong class="total-price">{{ number_format(Cart::total(),0,'','.') }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" id="direct-payment" name="payment-method" value="direct_payment">
                                    <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                </li>
                                <li>
                                    <input type="radio" id="payment-home" checked name="payment-method" value="home_payment">
                                    <label for="payment-home">Thanh toán tại nhà</label>
                                </li>
                                @error('payment-method')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </ul>
                        </div>
                        <div class="place-order-wp clearfix">
                            <input type="submit" id="order-now" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Loading overlay -->
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Modal OTP -->
    <div id="otpModal" class="modal-otp-checkout">
        <div class="modal-content">
            <h3>Xác Thực OTP</h3>
            <p>Mã OTP đã được gửi đến email của bạn</p>
            <form id="otpForm">
                <div class="form-group">
                    <input type="text" id="otp" name="otp" placeholder="Nhập mã OTP" required>
                </div>
                <button type="submit" class="submit-btn">Xác Nhận</button>
            </form>
            <div class="resend-otp">
                <span id="countdown">Gửi lại mã sau: <span id="timer">60</span>s</span>
                <button id="resendOtp" style="display: none;">Gửi lại mã</button>
            </div>
        </div>
    </div>

    <style>
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    
    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #d9263c;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    #customer-info-wp .section-detail {
        padding: 20px;
        background: #fff;
        border-radius: 4px;
    }

    .form-row {
        margin-bottom: 15px;
    }

    .form-row input,
    .form-row textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .form-row label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-col {
        margin-bottom: 15px;
    }

    #payment_methods {
        list-style: none;
        padding: 0;
    }

    #payment_methods li {
        margin-bottom: 10px;
    }

    #order-now {
        background: #d9263c;
        color: #fff;
        border: none;
        padding: 10px 30px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    #order-now:hover {
        background: #c11f33;
    }
    </style>

    <script>
    $(document).ready(function() {
        $('#order-now').on('click', function(e) {
            e.preventDefault();
            
            @if(!auth()->guard('web')->check())
                window.location.href = '{{ route("guest-login") }}';
                return;
            @endif

            let shipAddress = $('#address').val();
            if (!shipAddress) {
                alert('Vui lòng nhập địa chỉ giao hàng');
                return;
            }

            $('.loading-overlay').css('display', 'flex');

            $.ajax({
                url: '{{ route("checkout.verify") }}',
                method: 'POST',
                data: {
                    ship_address: shipAddress,
                    payment_method: $('input[name="payment-method"]:checked').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.loading-overlay').hide();
                    if (response.success) {
                        $('#otpModal').show();
                        startCountdown();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    $('.loading-overlay').hide();
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });

        $('#otpForm').on('submit', function(e) {
            e.preventDefault();
            
            $('.loading-overlay').css('display', 'flex');
            
            $.ajax({
                url: '{{ route("checkout.verify-otp") }}',
                method: 'POST',
                data: {
                    otp: $('#otp').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.loading-overlay').hide();
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    $('.loading-overlay').hide();
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });

        function startCountdown() {
            let timeLeft = 60;
            const $timer = $('#timer');
            const $resendButton = $('#resendOtp');
            const $countdownText = $('#countdown');

            const timer = setInterval(function() {
                timeLeft--;
                $timer.text(timeLeft);
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    $countdownText.hide();
                    $resendButton.show();
                }
            }, 1000);
        }
    });
    </script>
@endsection
