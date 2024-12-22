@extends('layouts.guest')

@section('content')
<div id="main-content-wp" class="checkout-success">
    <div class="wp-inner clearfix">
        <div class="section" id="success-notification">
            <div class="section-head">
                <h3 class="section-title">Đặt hàng thành công</h3>
            </div>
            <div class="section-detail">
                <p class="success-message">Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
                <p class="order-id">Mã đơn hàng: #{{ $orderData['id'] }}</p>
            </div>
        </div>

        <div class="section" id="order-detail">
            <div class="section-head">
                <h3 class="section-title">Chi tiết đơn hàng</h3>
            </div>
            <div class="section-detail">
                <table class="shop-table">
                    <thead>
                        <tr>
                            <td>Sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Giá</td>
                            <td>Tổng</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderData['items'] as $item)
                        <tr class="cart-item">
                            <td class="product-info">
                                <img src="{{ url($item['thumbnail']) }}" alt="" width="100">
                                <span class="product-name">{{ $item['name'] }}</span>
                            </td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ number_format($item['price'], 0, '', '.') }}đ</td>
                            <td>{{ number_format($item['total'], 0, '', '.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Tổng đơn hàng:</strong></td>
                            <td><strong>{{ number_format($orderData['total'], 0, '', '.') }}đ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="section" id="action-links">
            <a href="{{ route('home') }}" class="btn-return">Tiếp tục mua sắm</a>
        </div>
    </div>
</div>

<style>
.checkout-success {
    padding: 30px 0;
}
.section {
    margin-bottom: 30px;
}
.section-title {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}
.success-message {
    color: #28a745;
    font-size: 18px;
    margin-bottom: 10px;
}
.order-id {
    color: #666;
    font-size: 16px;
}
.shop-table {
    width: 100%;
    border-collapse: collapse;
}
.shop-table th,
.shop-table td {
    padding: 15px;
    border: 1px solid #ddd;
}
.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
}
.product-name {
    font-weight: 500;
}
.btn-return {
    display: inline-block;
    padding: 10px 20px;
    background: #d9263c;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.3s;
}
.btn-return:hover {
    background: #c11f33;
    color: #fff;
}
</style>
@endsection
