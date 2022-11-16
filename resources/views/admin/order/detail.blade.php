@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thông tin đơn hàng
            </div>
            <div class="card-body">
                <p class="cart-text font-weight-bold">Mã đơn hàng</p>
                <p class="card-text">{{ $order->id }}</p>
                <p class="cart-text font-weight-bold">Địa chỉ nhận hàng</p>
                <p class="card-text">{{ $order->guest->ship_address }}</p>
                <p class="cart-text font-weight-bold">Số điện thoại</p>
                <p class="card-text">{{ $order->guest->phone_number }}</p>
                <p class="cart-text font-weight-bold">Email</p>
                <p class="card-text">{{ $order->guest->email }}</p>
                <p class="cart-text font-weight-bold">Thông tin vận chuyển</p>
                <p class="card-text">{{ $order->status == "home_payment" ? "Thanh toán tại nhà": "Thanh toán tại cửa hàng" }}</p>
                <form action="{{ route('order.edit', $order->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="status" class="cart-text font-weight-bold">Tình trạng đơn hàng</label>
                        <select name="status" id="status" class="form-control">
                            <option {{ $order->status == "processing" ? "selected" : '' }} value="processing">Đang xử lý</option>
                            <option {{ $order->status == "being_transported" ? "selected" : ''}} value="being_transported">Đang vận chuyển</option>
                            <option {{ $order->status == "success" ? "selected" : ''}} value="success">Thành công</option>
                            <option {{ $order->status == "cancelled" ? "selected" : ''}} value="cancelled">Hủy đơn hàng</option>
                        </select>
                    </div>
                    <input type="submit" value="Cập nhật đơn hàng" name="btn_update" class="btn btn-primary">
                </form>
                <p class="card-text font-weight-bold text-uppercase mt-3">Sản phẩm đơn hàng</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh sản phẩm</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $temp = 0;
                        @endphp
                        @foreach ($order->order_detail as $item)
                            <tr>
                                <th scope="row">{{ ++$temp }}</th>
                                <td>
                                    <img src="{{ url($item->product->avatar) }}" style="width: 150px; height: 100px" alt="">
                                </td>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ number_format($item->price,0,'','.') }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total,0,'','.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="section pt-3 pb-3">
                    <p class="card-text font-weight-bold text-uppercase mt-3">Giá trị đơn hàng</p>
                    <div class="row">
                        <div class="col-2 text-right">Tổng số lượng:</div>
                        <div class="col-10">{{ $order->num_order }} sản phẩm</div>
                    </div>
                    <div class="row text-danger font-weight-bold">
                        <div class="col-2 text-right">Tổng đơn hàng: </div>
                        <div class="col-10">{{ number_format($order->total) }}đ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
