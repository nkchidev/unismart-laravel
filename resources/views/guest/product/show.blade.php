@extends('layouts.guest')

@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">{{ $cate->cat_title }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left">{{ $cate->cat_title }}</h3>
                        <div class="filter-wp fl-right">
                            {{-- <p class="desc">Hiển thị 45 trên 50 sản phẩm</p>
                            <div class="form-filter">
                                <form method="POST" action="#">
                                    <select name="filter">
                                        <option value="0">Sắp xếp</option>
                                        <option value="1">Từ A-Z</option>
                                        <option value="2">Từ Z-A</option>
                                        <option value="3">Giá cao xuống thấp</option>
                                        <option value="3">Giá thấp lên cao</option>
                                    </select>
                                    <button type="submit">Lọc</button>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($list_product as $product)
                                <li>
                                    <a href="{{ route('product.detail', $product->id) }}" title="" class="thumb">
                                        <img style="height: 150px; width: auto" src="{{ url($product->avatar) }}">
                                    </a>
                                    <a style="height: 30px" href="{{ route('product.detail', $product->id) }}" title="" class="product-name">{{ $product->name }}</a>
                                    <div class="price">
                                        <span class="new">{{ number_format($product->price,0,'','.') }}đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart.add', $product->id) }}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                        <a href="{{ route('product.detail', $product->id) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section float-right" id="paging-wp">
                    {{ $list_product->links() }}
                </div>
            </div>
            <div class="sidebar fl-left">
                @include('partials.category')
                @include('partials.filter')
                @include('partials.banner')
            </div>

        </div>
    </div>
@endsection
