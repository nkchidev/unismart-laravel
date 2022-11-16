@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form action="{{ url('admin/post/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="title">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Danh mục</label>
                        <select class="form-control" id="category" name="category">
                            <option value="">Chọn danh mục</option>
                            {!! $htmlOption !!}
                        </select>
                        @error('category')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="post_thumb" class="form-label">Hình ảnh bài viết</label>
                        <input class="form-control-file" name="post_thumb" type="file" id="post_thumb">
                        @error('post_thumb')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pending" value="pending" checked>
                            <label class="form-check-label" for="pending">Chờ duyệt</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public">
                            <label class="form-check-label" for="public">Công khai</label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" name="btn_add" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>

@endsection
