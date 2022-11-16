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
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="#">
                        <input type="text" class="form-control form-search" name="keyword" value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                        <input type="hidden" name="status" value="{{ request()->input('status') }}">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ url('admin/post/list?status=public') }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ url('admin/post/list?status=pending') }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ url('admin/post/list?status=trash') }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[2] }})</span></a>
                </div>
                <form action="{{ url('admin/post/action') }}" method="POST">
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
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($posts->total() > 0)
                                @php
                                    $temp = 0;
                                @endphp
                                @foreach ($posts as $post)
                                    @php
                                        $temp++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input name="list_check[]" value="{{ $post->id }}" type="checkbox">
                                        </td>
                                        <td scope="row">{{ $temp }}</td>
                                        <td><img style="width: 150px; height: 100px; object-fit: cover;"
                                                src="{{ url($post->post_thumb) }}" alt=""></td>
                                        <td><a href="">{{ $post->title }}</a></td>
                                        <td>{{ $post->category->cat_title }}</td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>
                                            <a href="{{ route('post.edit', $post->id) }}"
                                                class="btn btn-success btn-sm rounded-0" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('post.delete', $post->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này không?')"
                                                class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
                                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="bg-white">Không tìm thấy bài viết cần tìm kiếm</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </form>
                {{ $posts->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
