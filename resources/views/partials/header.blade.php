<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('responsive.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{ route('home') }}" title="">Trang chủ</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ url('san-pham') }}" title="">Sản phẩm</a>
                                </li> --}}
                                <li>
                                    <a href="{{ url('tin-tuc') }}" title="">Tin tức</a>
                                </li>
                                <li>
                                    <a href="{{ route('page.about', 1) }}" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="{{ route('page.contact', 2) }}" title="">Liên hệ</a>
                                </li>
                                @if(auth()->guard('web')->check())
                                <li class="user-account">
                                    <a href="#" title="">Xin chào, {{ auth()->guard('web')->user()->fullname }}</a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="#" id="logout-link" title="">Đăng xuất</a>
                                        </li>
                                    </ul>
                                </li>
                                @else
                                <li>
                                    <a href="{{ route('guest-login') }}" title="">Đăng nhập</a>
                                </li>
                                <li>
                                    <a href="{{ route('guest-register') }}" title="">Đăng ký</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{ route('home') }}" title="" id="logo" class="fl-left"><img
                                src="{{ asset('images/logo.png') }}" /></a>
                        <div id="search-wp" class="fl-left">
                            <form method="POST" action="{{ url('san-pham/tim-kiem') }}">
                                @csrf
                                <input type="text" name="keyword" id="s"
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" id="sm-s">Tìm kiếm</button>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0987.654.321</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="?page=cart" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">{{ Cart::count() }}</span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num">{{ Cart::count() }}</span>
                                </div>
                                @if (Cart::count())
                                    <div id="dropdown">
                                        <p class="desc">Có <span>{{ Cart::count() }} sản phẩm</span> trong giỏ hàng
                                        </p>
                                        <ul class="list-cart">
                                            @foreach (Cart::content() as $item)
                                                <li class="clearfix">
                                                    <a href="" title="" class="thumb fl-left">
                                                        <img src="{{ url($item->options->thumbnail) }}"
                                                            alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="" title=""
                                                            class="product-name">{{ $item->name }}</a>
                                                        <p class="price">{{ number_format($item->price, 0, '', '.') }}đ
                                                        </p>
                                                        <p class="qty">Số lượng:
                                                            <span>{{ number_format($item->qty) }}</span></p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right">{{ number_format(Cart::total(), 0, '', '.') }}đ
                                            </p>
                                        </div>
                                        <div class="action-cart clearfix">
                                            <a href="{{ route('cart.show') }}" title="Giỏ hàng"
                                                class="view-cart fl-left">Giỏ hàng</a>
                                            <a href="{{ route('checkout.show') }}" title="Thanh toán"
                                                class="checkout fl-right">Thanh toán</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(auth()->guard('web')->check())
            <script>
            $(document).ready(function() {
                $('#logout-link').on('click', function(e) {
                    e.preventDefault();
                    
                    $.ajax({
                        url: '{{ route("guest-logout") }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                window.location.href = response.redirect_url;
                            }
                        },
                        error: function(xhr) {
                            console.error('Logout error:', xhr);
                            alert('Có lỗi xảy ra khi đăng xuất');
                        }
                    });
                });
            });
            </script>
            @endif
        </div>
    </div>
</body>
</html>
