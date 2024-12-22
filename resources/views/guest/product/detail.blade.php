@extends('layouts.guest')

@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Điện thoại</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                        <div class="thumb-wp fl-left">
                            <a href="" title="" id="main-thumb">
                                <img style="width: 350px; height: 350px; max-width: 350px; min-width: 350px;" id="zoom" src="{{ url($product->avatar) }}"
                                    data-zoom-image="{{ url($product->avatar) }}" />
                            </a>
                            <div id="list-thumb">
                                <a href="" data-image="{{ url($product->avatar) }}" data-zoom-image="{{ url($product->avatar) }}">
                                    <img style="width: 70px; height: 70px; max-width: 70px; min-width: 70px; object-fit: cover;" id="zoom"
                                    src="{{ url($product->avatar) }}" />
                                </a>
                                @foreach ($product->product_image as $value)
                                    <a href="" data-image="{{ url($value->link_image) }}" data-zoom-image="{{ url($value->link_image) }}">
                                        <img style="width: 70px; height: 70px; max-width: 70px; min-width: 70px; object-fit: cover;" id="zoom"
                                        src="{{ url($value->link_image) }}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="thumb-respon-wp fl-left">
                            <img src="images/img-pro-01.png" alt="">
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="GET">
                            <div class="info fl-right">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <div class="desc">
                                    {!! $product->describe !!}
                                </div>
                                <div class="num-product">
                                    <span class="title">Sản phẩm: </span>
                                    <span class="status">{{ $product->product_status == "stocking" ? 'Còn hàng' : 'Hết hàng' }}</span>
                                </div>
                                <p class="price">{{ number_format($product->price,0,'','.') }}đ </p>
                                <div id="num-order-wp">
                                    <span style="color: #666">Số lượng: </span>
                                    <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                    <input type="text" name="num_order" value="1" id="num-order">
                                    <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                </div>
                                <input type="submit" title="Thêm giỏ hàng" class="add-cart" style="border: none" value="Thêm giỏ hàng"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail">
                        {!! $product->detail !!}
                    </div>
                </div>
                @include('partials.same_category')
            </div>
            <div class="sidebar fl-left">
                @include('partials.category')
                @include('partials.banner')
            </div>
        </div>
    </div>
@endsection
