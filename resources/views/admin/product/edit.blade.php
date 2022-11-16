@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="name" value="{{ $product->name }}" id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input class="form-control" type="number" min="0" name="price" value="{{ $product->price }}" id="price">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Ảnh đại diện sản phẩm</label>
                                <input class="form-control-file" type="file" name="image" id="image">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img style="margin-top: 10px; width: 150px; height: 100px;" src="{{ url($product->avatar) }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="detail_image">Ảnh chi tiết sản phẩm</label>
                                <input class="form-control-file" multiple="" type="file" name="detail_image[]" id="detail_image">
                                <div class="row">
                                    @foreach ($product->product_image as $item)
                                        <div class="col-md-4">
                                            <img style="margin-top: 10px; width: 150px; height: 100px;" src="{{ url($item->link_image) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input name="outstanding" value="yes" class="form-check-input" {{ $product->outstanding == 'yes' ? 'checked' : '' }} type="checkbox" value="yes" id="outstanding">
                                    <label class="form-check-label" for="outstanding">
                                        Nổi bật
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input name="celling" value="yes" class="form-check-input" {{ $product->celling == 'yes' ? 'checked' : '' }} type="checkbox" value="yes" id="celling">
                                    <label class="form-check-label" for="celling">
                                        Bán chạy nhất
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="describe">Mô tả sản phẩm</label>
                                <textarea name="describe" id="describe" class="form-control" id="intro" cols="30" rows="5">{{ $product->describe }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="detail">Chi tiết sản phẩm</label>
                        <textarea name="detail" id="detail" class="form-control" id="intro" cols="30" rows="5">{{ $product->detail }}</textarea>
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
                            <input class="form-check-input" type="radio" {{ $product->status == "pending" ? "checked" : ''  }} name="status" id="pending" value="pending" checked>
                            <label class="form-check-label" for="pending">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" {{ $product->status == "public" ? "checked" : ''  }} name="status" id="public" value="public">
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái sản phẩm</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" {{ $product->product_status == "stocking" ? "checked" : ''  }} name="product_status" id="stocking" value="stocking" checked>
                            <label class="form-check-label" for="stocking">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" {{ $product->product_status == "out_of_stock" ? "checked" : ''  }} name="product_status" id="out_of_stock" value="out_of_stock">
                            <label class="form-check-label" for="out_of_stock">
                                Hết hàng
                            </label>
                        </div>
                    </div>
                    <input type="submit" name="btn_update" class="btn btn-primary" value="Cập nhật">
                </form>
            </div>
        </div>
    </div>
@endsection
