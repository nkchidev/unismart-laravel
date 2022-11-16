@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách các trang</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" class="form-control form-search" name="keyword" value="{{ request()->input('keyword') }}"  placeholder="Tìm kiếm">
                        <input type="hidden" name="status" value="{{ request()->input('status') }}">
                        <input type="submit" name="btn_search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ url('admin/page/list?status=public') }}" class="text-primary">Công khai<span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ url('admin/page/list?status=pending') }}" class="text-primary">Chờ duyệt<span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ url('admin/page/list?status=trash') }}" class="text-primary">Thùng rác<span class="text-muted">({{ $count[2] }})</span></a>
                </div>
                <form action="{{ url('admin/page/action') }}" method="POST">
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
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pages->total() > 0)
                                @php
                                $temp = 0;
                                @endphp
                                @foreach ($pages as $page)
                                @php
                                    $temp++;
                                @endphp
                                    <tr>
                                        <td>
                                            <input name="list_check[]" value="{{ $page->id }}" type="checkbox">
                                        </td>
                                        <td scope="row">{{ $temp }}</td>
                                        <td><a href="">{{ $page->title }}</a></td>
                                        <td>{{ $page->slug }}</td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>
                                            <a href="{{ route('page.edit', $page->id ) }}" class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('page.delete', $page->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này không?')" class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="bg-white">Không tìm thấy trang cần tìm kiếm</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $pages->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection

