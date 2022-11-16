@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" name="keyword" value="{{ request()->input('keyword') }}" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="hidden" name="status" value="{{ request()->input('status') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ url('admin/order/list?status=processing') }}" class="text-primary">Đang xử lý<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ url('admin/order/list?status=being_transported') }}" class="text-primary">Đang vận chuyển<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ url('admin/order/list?status=success') }}" class="text-primary">Hoàn thành<span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ url('admin/order/list?status=cancelled') }}" class="text-primary">Đã hủy<span class="text-muted">({{ $count[3] }})</span></a>
                </div>
                <form action="{{ url('admin/order/action') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="act" name="act">
                            <option>Chọn</option>
                            @foreach ($list_act as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Chi tiết</th>
                                {{-- <th scope="col">Tác vụ</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->total() > 0)
                                @php
                                    $temp = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <input name="list_check[]" value="{{ $order->id }}" type="checkbox">
                                        </td>
                                        <td>{{ ++$temp }}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->guest->fullname }} <br>
                                            {{ $order->guest->phone_number }}
                                        </td>
                                        <td>{{ $order->num_order }}</td>
                                        <td>{{ number_format($order->total, 0,'','.') }}đ</td>
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
                            @else
                                <tr>
                                    <td colspan="9">Không tìm thấy đơn hàng cần tìm</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </form>
                {{ $orders->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection
