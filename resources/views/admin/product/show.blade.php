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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
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
                    <a href="{{ url('admin/product/list?status=public') }}" class="text-primary">Công khai<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ url('admin/product/list?status=pending') }}" class="text-primary">Chờ duyệt<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ url('admin/product/list?status=trash') }}" class="text-primary">Thùng rác<span class="text-muted">({{ $count[2] }})</span></a>
                </div>
                <form action="{{ url('admin/product/action') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" id="" name="act">
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
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->total() > 0)
                                @php
                                    $temp = 0;
                                @endphp
                                @foreach ($products as $product)
                                @php
                                    $temp++;
                                @endphp
                                    <tr class="">
                                        <td>
                                            <input name="list_check[]" value="{{ $product->id }}" type="checkbox">
                                        </td>
                                        <td>{{ $temp }}</td>
                                        <td><img style="width: 150px; height: 100px; object-fit: cover;" src="{{ url($product->avatar) }}" alt=""></td>
                                        <td><a href="#">{{ $product->name }}</a></td>
                                        <td>{{ number_format($product->price,0,'','.') }}đ</td>
                                        <td>{{ $product->category->cat_title }}</td>
                                        <td>{{ $product->created_at }}</td>
                                        <td>
                                            @if ($product->product_status == "stocking")
                                                <span class="badge badge-success">Còn hàng</span>
                                            @else
                                                <span class="badge badge-dark">Hết hàng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('product.delete', $product->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">Không tìm thấy sản phẩm cần tìm</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </form>
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection
