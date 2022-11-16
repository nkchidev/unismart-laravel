<div class="section" id="selling-wp">
    <div class="section-head">
        <h3 class="section-title">Sản phẩm bán chạy</h3>
    </div>
    @if ($list_product->count())
        <div class="section-detail">
            <ul class="list-item">
                @foreach ($list_product as $value)
                    @if ($value->celling == "yes" && $value->status == "public")
                        <li class="clearfix">
                            <a href="{{ route('product.detail', $value->id) }}" title="" class="thumb fl-left">
                                <img src="{{ url($value->avatar) }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('product.detail', $value->id) }}" title="" class="product-name">{{ $value->name }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($value->price,0,'','.') }}đ</span>
                                    {{-- <span class="old">7.190.000đ</span> --}}
                                </div>
                                <a href="{{ route('product.detail', $value->id) }}" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
</div>
