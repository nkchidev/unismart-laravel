@extends('layouts.guest')

@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @if(Cart::count())
            <div id="wrapper" class="wp-inner clearfix">
                <div class="section" id="info-cart-wp">
                    <div class="section-detail table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Số thứ tự</td>
                                    <td>Ảnh sản phẩm</td>
                                    <td>Tên sản phẩm</td>
                                    <td>Giá sản phẩm</td>
                                    <td>Số lượng</td>
                                    <td colspan="2">Thành tiền</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $temp = 0;
                                @endphp
                                @foreach (Cart::content() as $item)
                                    <tr>
                                        <td>{{ ++$temp }}</td>
                                        <td>
                                            <a href="" title="" class="thumb">
                                                <img style="height: 100px;; object-fit: cover" src="{{ url($item->options->thumbnail) }}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('product.detail', $item->id) }}" title="" class="name-product">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ number_format($item->price,0, '','.') }}đ</td>
                                        <td>
                                            <input type="number" name="num-order" data-id="{{ $item->rowId }}" min="1" value="{{ $item->qty }}" class="num-order">
                                        </td>
                                        <td id="sub_total_{{ $item->rowId }}">{{ number_format($item->total , 0, '' , '.') }}đ</td>
                                        <td>
                                            <a href="{{ route('cart.delete', $item->rowId) }}" title="" class="del-product"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-right">Tổng giá: <span class="total">{{ number_format(Cart::total(),0,'','.') }}đ</span></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <div class="fl-right">
                                                {{-- <a href="" title="" id="update-cart">Cập nhật giỏ hàng</a> --}}
                                                <a href="{{ route('checkout.show') }}" title="" id="checkout-cart">Thanh toán</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="section" id="action-cart-wp">
                    <div class="section-detail">
                        {{-- <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số lượng
                            <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.</p> --}}
                        <a href="{{ url('home') }}" title="" id="buy-more">Mua tiếp</a><br />
                        <a href="{{ route('cart.destroy') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                    </div>
                </div>
            </div>
        @else
            <div id="wrapper" class="wp-inner clearfix">
                <div class="section" id="action-cart-wp">
                    <div class="section-detail">
                        <a href="{{ url('home') }}" title="" id="buy-more">Mua tiếp</a><br />
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
