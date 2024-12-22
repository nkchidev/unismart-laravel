<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="loading">
        <div class="loading-spinner"></div>
    </div>
    <div class="register-container">
        <div class="back-home">
            <a href="{{ route('home') }}" title="Về trang chủ">
                <i class="fa fa-arrow-left"></i> Về trang chủ
            </a>
        </div>
        <h2>Đăng Ký Tài Khoản</h2>
        <form id="registerForm" action="{{ route('guest-register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="fullname">Họ và Tên</label>
                <input type="text" id="fullname" name="fullname" placeholder="Nhập họ và tên của bạn" required>
            </div>
            <div class="form-group">
                <label for="email">Địa Chỉ Email</label>
                <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Số Điện Thoại</label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="Nhập số điện thoại" required>
            </div>
            <div class="form-group">
                <label for="ship_address">Địa Chỉ Giao Hàng</label>
                <input type="text" id="ship_address" name="ship_address" placeholder="Nhập địa chỉ giao hàng" required>
            </div>
            <div class="form-group">
                <label for="password">Mật Khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Xác Nhận Mật Khẩu</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button type="submit" class="submit-btn">Tạo Tài Khoản</button>
            <div class="login-link">
                Bạn đã có tài khoản? <a href="{{ route('guest-login') }}">Đăng nhập</a>
            </div>
        </form>
    </div>

    <!-- Modal OTP -->
    <div id="otpModal" class="modal">
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

    <!-- Thêm JavaScript -->
    <script>
    $(document).ready(function() {
        // Xử lý form đăng ký
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();
            $('.loading').css('display', 'flex');
            
            $.ajax({
                url: '{{ route("guest-register") }}',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.loading').hide();
                    if (response.success) {
                        $('#otpModal').show();
                        startCountdown();
                    } else {
                        console.log(response.message);
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    $('.loading').hide();
                    console.error('Error:', xhr.responseJSON);
                    let errorMessage = 'Có lỗi xảy ra. Vui lòng thử lại.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors)
                            .flat()
                            .join('\n');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    alert(errorMessage);
                }
            });
        });

        // Xử lý form OTP
        $('#otpForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '{{ route("verify-otp") }}',
                method: 'POST',
                data: JSON.stringify({ otp: $('#otp').val() }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('Đăng ký thành công!');
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });

        // Xử lý gửi lại OTP
        $('#resendOtp').on('click', function() {
            $.ajax({
                url: '{{ route("resend-otp") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#resendOtp').hide();
                        $('#countdown').show();
                        startCountdown();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
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
</body>
</html>
