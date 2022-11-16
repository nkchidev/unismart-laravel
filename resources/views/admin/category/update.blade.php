@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cat.update', $cat_update->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="cat_title">Tên danh mục</label>
                                <input class="form-control" type="text" name="cat_title" value="{{ $cat_update->cat_title }}" id="cat_title">
                            </div>
                            <div class="form-group">
                                <label for="cat_parent">Danh mục cha</label>
                                <select class="form-control" id="cat_parent" name="parent">
                                    <option value="0">Chọn danh mục</option>
                                    {!! $htmlOption !!}
                                </select>
                            </div>
                            <button type="submit" name="btn_update" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                {!! $tablecategory !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
