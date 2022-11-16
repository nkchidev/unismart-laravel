<div class="section" id="same-category-wp">
    <div class="section-head">
        <h3 class="section-title">Cùng chuyên mục</h3>
    </div>
    <div class="section-detail">
        <ul class="list-item">
            @foreach ($same_category as $item)
                <li>
                    <a href="" title="" class="thumb">
                        <img style="height: 150px; width: auto" src="{{ url($item->avatar) }}">
                    </a>
                    <a href="" title="" class="product-name">{{ $item->name }}</a>
                    <div class="price">
                        <span class="new">{{ number_format($item->price, 0, '','.') }}đ</span>
                        {{-- <span class="old">20.900.000đ</span> --}}
                    </div>
                    <div class="action clearfix">
                        <a href="{{ route('cart.add', $item->id) }}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                        <a href="{{ route('product.detail',$item->id) }}" title="" class="buy-now fl-right">Mua ngay</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
