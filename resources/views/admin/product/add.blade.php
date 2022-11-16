@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ url('admin/product/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="name" id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input class="form-control" type="number" min="0" name="price" id="price">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Ảnh đại diện sản phẩm</label>
                                <input class="form-control-file" type="file" name="image" id="image">
                            </div>
                            <div class="form-group">
                                <label for="detail_image">Ảnh chi tiết sản phẩm</label>
                                <input class="form-control-file" multiple="" type="file" name="detail_image[]" id="detail_image">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="outstanding" value="yes" id="outstanding">
                                    <label class="form-check-label" for="outstanding">
                                        Nổi bật
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="celling" value="yes" id="celling">
                                    <label class="form-check-label" for="celling">
                                        Bán chạy nhất
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="describe">Mô tả sản phẩm</label>
                                <textarea name="describe" id="describe" class="form-control" id="intro" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <textarea name="detail" id="detail" class="form-control" id="intro" cols="30" rows="5"></textarea>
                        @error('detail')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Danh mục</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Chọn danh mục</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pending" value="pending">
                            <label class="form-check-label" for="pending">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="public" value="public" checked>
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái sản phẩm</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="stocking" value="stocking" checked>
                            <label class="form-check-label" for="stocking">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="product_status" id="out_of_stock" value="out_of_stock">
                            <label class="form-check-label" for="out_of_stock">
                                Hết hàng
                            </label>
                        </div>
                    </div>
                    <input type="submit" name="btn_add" class="btn btn-primary" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>
@endsection
