<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    private $htmlSelect = "";
    private $htmlTable = "";
    private $htmlList = "";

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

    private $count = 0;
    function tableCategories($categories, $parent_id = 0, $char = ''){
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item->parent_id == $parent_id)
            {
                $this->htmlTable .=
                "<tr>".
                    "<th scope='row'>" . ++$this->count . "</th>" .
                    "<td>". $char . $item->cat_title  ."</td>" .
                    "<td>". $item->slug  ."</td>" .
                    "<td>".
                    "<a href=" . route('cat.edit', $item->id) . " class='btn btn-success btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-edit'></i></a> " .
                    "<a href=" . route('cat.delete', $item->id) ." class='btn btn-danger btn-sm rounded-0' type='button' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash'></i></a>".
                    "</td>"
                . "</tr>";
                // Xóa chuyên mục đã lặp
                unset($categories[$key]);
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                $this->tableCategories($categories, $item->id, $char.'---');
            }
        }
        return $this->htmlTable;
    }



    function show(){
        $htmlOption = $this->categoryRecursive($parentId = '');
        $categories =  Category::paginate(10);
        $tablecategory = $this->tableCategories($categories);
        return view('admin.category.show', compact('categories', 'htmlOption', 'tablecategory'));
    }

    function add(Request $request){
        $request->validate(
            [
                'cat_title' => 'required|string|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'cat_title' => 'Tên danh mục',
            ]
        );
        Category::create([
            'cat_title' => $request->input('cat_title'),
            'slug' => Str::slug($request->input('cat_title')),
            'parent_id' => $request->input('parent')
        ]);
        return redirect('admin/post/cat/list')->with('status', "Thêm danh mục mới thành công");
    }

    function delete($id){
        $cat = Category::find($id)->delete();
        return redirect('admin/post/cat/list')->with('status', "Xóa danh mục thành công");
    }

    function edit($id){
        $cat_update = Category::find($id);
        $categories = Category::paginate(5);
        $htmlOption = $this->categoryRecursive($cat_update->parent_id);
        $tablecategory = $this->tableCategories($categories);
        return view('admin.category.update', compact('cat_update','categories','htmlOption','tablecategory'));
    }

    function update(Request $request, $id){
        $request->validate(
            [
                'cat_title' => 'required|string|max:255',
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'cat_title' => 'Tên danh mục',
            ]
        );
        Category::find($id)->update([
            'cat_title' => $request->input('cat_title'),
            'slug' => Str::slug($request->input('cat_title')),
            'parent_id' => $request->input('parent')
        ]);
        return redirect('admin/post/cat/list')->with('status', "Cập nhật danh mục thành công");
    }

}
