@extends('layouts.guest')

@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="slider-wp">
                    <div class="section-detail">
                        <div class="item">
                            <img src="public/images/slider-01.png" alt="">
                        </div>
                        <div class="item">
                            <img src="public/images/slider-02.png" alt="">
                        </div>
                        <div class="item">
                            <img src="public/images/slider-03.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-1.png">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-2.png">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-3.png">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-4.png">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-5.png">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm nổi bật</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($list_product as $item)
                                @if ($item->outstanding == "yes" && $item->status == "public")
                                    <li>
                                        <a href="{{ route('product.detail', $item->id) }}" title="" class="thumb">
                                            <img style="height: 150px; width: auto" src="{{ url($item->avatar) }}">
                                        </a>
                                        <a style="height: 30px" href="{{ route('product.detail', $item->id) }}" title="" class="product-name">{{ $item->name }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($item->price,0,'','.') }}đ</span>
                                            {{-- <span class="old">6.190.000đ</span> --}}
                                        </div>
                                        <div class="action clearfix">
                                            <a href="{{ route('cart.add', $item->id) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                            <a href="{{ route('product.detail', $item->id) }}" title="" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Điện thoại</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($list_product as $item)
                                @if($item->category_id == 1 || $item->parent_id == 1)
                                    <li>
                                        <a href="{{ route('product.detail',$item->id) }}" title="" class="thumb">
                                            <img style="height: 150px; width: auto" src="{{ url($item->avatar) }}">
                                        </a>
                                        <a style="height: 30px" href="{{ route('product.detail',$item->id) }}" title="" class="product-name">{{ $item->name }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($item->price,0,'','.') }}đ</span>
                                            {{-- <span class="old">8.990.000đđ</span> --}}
                                        </div>
                                        <div class="action clearfix">
                                            <a href="{{ route('cart.add', $item->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                            <a href="{{ route('product.detail',$item->id) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Laptop</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($list_product as $item)
                                @if($item->category_id == 14 || $item->parent_id == 14)
                                    <li>
                                        <a href="{{ route('product.detail',$item->id) }}" title="" class="thumb">
                                            <img style="height: 150px; width: auto" src="{{ url($item->avatar) }}">
                                        </a>
                                        <a style="height: 30px" href="{{ route('product.detail',$item->id) }}" title="" class="product-name">{{ $item->name }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($item->price,0,'','.') }}đ</span>
                                            {{-- <span class="old">8.990.000đđ</span> --}}
                                        </div>
                                        <div class="action clearfix">
                                            <a href="{{ route('cart.add', $item->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                            <a href="{{ route('product.detail',$item->id) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @include('partials.sidebar')
        </div>
    </div>
@endsection
