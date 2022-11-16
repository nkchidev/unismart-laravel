<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_image;
use Illuminate\Support\Str;
use File;

class AdminProductController extends Controller
{
    private $htmlSelect = "";
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'product']);

            return $next($request);
        });
    }

    function categoryRecursive($parentId, $id = 0 , $text = ''){
        $data = Category::all();
        foreach($data as $value){
            if($value['parent_id'] == $id){
                if(!empty($parentId) && $value['id'] ==  $parentId){
                    $this->htmlSelect .= "<option selected value='{$value['id']}'>". $text . $value['cat_title'] . "</option>";
                }else{
                    $this->htmlSelect .= "<option value='{$value['id']}'>". $text . $value['cat_title'] . "</option>";
                }
                $this->categoryRecursive($parentId,$value['id'], $text . '--');
            }
        }
        return $this->htmlSelect;
    }

    function show(Request $request){
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }

        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];
        if($status == 'trash'){
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $products = Product::onlyTrashed()->where('name','like',"%{$keyword}%")->paginate(5);
        }else if($status == 'pending'){
            $products = Product::where([
                ['status','pending'],
                ['name', 'like', "%{$keyword}%"]
            ])->paginate(3);
        }else{
            $products = Product::where([
                ['status','public'],
                ['name', 'like', "%{$keyword}%"]
            ])->paginate(5);
        }
        $count_product_public = Product::where('status','public')->count();
        $count_product_pending = Product::where('status', 'pending')->count();
        $count_product_trash = Product::onlyTrashed()->count();
        $count = [$count_product_public,$count_product_pending,$count_product_trash];
        return view('admin.product.show', compact('products','count','list_act'));
    }

    function add(){
        $htmlOption = $this->categoryRecursive($parentId = '');
        return view('admin.product.add', compact('htmlOption'));
    }

    function store(Request $request){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required',
                'status' => 'required',
                'detail' => 'required|string',
                'product_status' => 'required'
            ],
            [
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'status' => 'Trạng thái',
                'detail' => 'Chi tiết sản phẩm',
                'product_status' => 'Trạng thái sản phẩm'
            ]
        );
        $input = $request->input();
        $input['slug'] = Str::slug($request->input('name'));

        if($request->hasFile('image')){
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $path = $file->move('public/uploads/product',$filename);
            $image = "public/uploads/product/". $filename;
            $input['avatar'] = $image;
        }
        $product = Product::create($input);
        if($request->hasFile('detail_image')){
            $files = $request->detail_image;
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $path = $file->move('public/uploads/product',$filename);
                $image = "public/uploads/product/". $filename;
                $data['link_image'] = $image;
                $data['product_id'] = $product->id;
                Product_image::create($data);
            }
        }
        return redirect('admin/product/list')->with('status','Thêm sản phẩm mới thành công');
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            $act = $request->input('act');
            if($act == "delete"){
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status', 'Xóa sản phẩm thành công');
            }

            if($act == "restore"){
                Product::withTrashed()
                ->whereIn('id',$list_check)
                ->restore();
                return redirect('admin/product/list')->with('status','Khôi phục sản phẩm thành công');
            }

            if($act == "forceDelete"){
                Product::withTrashed()
                ->whereIn('id',$list_check)
                ->forceDelete();
                return redirect('admin/product/list')->with('status', 'Đã xóa vĩnh viễn sản phẩm thành công');
            }
        }else{
            return redirect('admin/product/list')->with('status', 'Bạn cần chọn ít nhất một bản ghi để thao tác');
        }
    }

    function delete($id){
        Product::find($id)->delete();
        return redirect('admin/product/list')->with('status','Xóa sản phẩm thành công');
    }

    function edit($id){
        $product = Product::find($id);
        $htmlOption = $this->categoryRecursive($product->category->id);
        return view('admin.product.edit',compact('product', 'htmlOption'));
    }

    function update(Request $request,$id){
        $product = Product::find($id);
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required',
                'status' => 'required',
                'detail' => 'required|string',
                'product_status' => 'required'
            ],
            [
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'required' => ':attribute không được để trống',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'status' => 'Trạng thái',
                'detail' => 'Chi tiết sản phẩm',
                'product_status' => 'Trạng thái sản phẩm'
            ]
        );
        $input = $request->input();
        $input['slug'] = Str::slug($request->input('name'));

        if($request->hasFile('image')){
            File::delete($product->avatar);
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $path = $file->move('public/uploads/product',$filename);
            $image = "uploads/product/". $filename;
            $input['avatar'] = $image;
        }
        Product::find($id)->update($input);
        if($request->hasFile('detail_image')){
            // Xóa ảnh trên server
            foreach($product->product_image as $item){
                File::delete($item->link_image);
            }

            // Xóa dữ liệu ảnh cũ trên database
            foreach($product->product_image as $item){
                Product_image::find($item->id)->delete();
            }

            // Đưa ảnh mới lên server
            $files = $request->detail_image;
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $path = $file->move('public/uploads/product',$filename);
                $image = "public/uploads/product/". $filename;
                $data['link_image'] = $image;
                $data['product_id'] = $id;
                Product_image::create($data);
            }
        }
        return redirect('admin/product/list')->with('status','Cập nhật sản phẩm thành công');
    }
}
