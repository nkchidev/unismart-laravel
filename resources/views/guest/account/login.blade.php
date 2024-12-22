<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="loading">
        <div class="loading-spinner"></div>
    </div>
    
    <div class="login-container">
        <div class="back-home">
            <a href="{{ route('home') }}" title="Về trang chủ">
                <i class="fa fa-arrow-left"></i> Về trang chủ
            </a>
        </div>
        <h2>Đăng Nhập</h2>
        <form id="loginForm" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật Khẩu</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Đăng Nhập</button>
            <div class="register-link">
                Chưa có tài khoản? <a href="{{ route('guest-register') }}">Đăng ký</a>
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

    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            $('.loading').css('display', 'flex');

            $.ajax({
                url: '{{ route("guest-login-post") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('.loading').hide();
                    if (response.success) {
                        if (response.show_otp) {
                            $('#otpModal').show();
                            startCountdown();
                        } else {
                            window.location.href = response.redirect_url;
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    $('.loading').hide();
                    let errorMessage = 'Có lỗi xảy ra. Vui lòng thử lại.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    alert(errorMessage);
                }
            });
        });

        // Xử lý form OTP
        $('#otpForm').on('submit', function(e) {
            e.preventDefault();
            $('.loading').css('display', 'flex');
            
            $.ajax({
                url: '{{ route("verify-login-otp") }}',
                method: 'POST',
                data: JSON.stringify({ otp: $('#otp').val() }),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('.loading').hide();
                    if (response.success) {
                        alert('Đăng nhập thành công!');
                        window.location.href = response.redirect_url;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    $('.loading').hide();
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
