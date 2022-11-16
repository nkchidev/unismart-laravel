@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($sales,0,'','.') }}đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $temp = 0;
                        @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row">{{ ++$temp }}</th>
                                <td>{{ $order->id }}</td>
                                <td>
                                    {{ $order->guest->fullname }} <br>
                                    {{ $order->guest->phone_number }}
                                </td>
                                <td>{{ $order->num_order }}</td>
                                <td>{{ number_format($order->total,0,'','.') }}đ</td>
                                <td>
                                    @if ($order->status == "processing")
                                                <span class="badge badge-warning">Đang xử lý</span>
                                            @elseif($order->status == "being_transported")
                                                <span class="badge badge-primary">Đang vận chuyển</span>
                                            @elseif ($order->status == "cancelled")
                                                <span class="badge badge-dark">Đã hủy</span>
                                            @else
                                                <span class="badge badge-success">Hoàn thành</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('order.detail', $order->id) }}" class="text-primary">Chi tiết</a>
                                </td>
                                {{-- <td>
                                    <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orders->links(); }}
            </div>
        </div>

    </div>

@endsection

