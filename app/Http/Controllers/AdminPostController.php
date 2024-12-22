<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    private $htmlSelect = "";
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'post']);
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
        // Lấy keyword từ form tìm kiếm
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        // Lấy ra trạng thái hiện tại trên url
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Xóa tạm thời'
        ];
        if($status == 'trash'){
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $posts = Post::onlyTrashed()->where('title','like',"%{$keyword}%")->paginate(5);
        }else if($status == 'pending'){
            $posts = Post::where([
                ['status','pending'],
                ['title', 'like', "%{$keyword}%"]
            ])->paginate(5);
        }else{
            $posts = Post::where([
                ['status','public'],
                ['title', 'like', "%{$keyword}%"]
            ])->paginate(5);
        }
        $count_post_public = Post::where('status','public')->count();
        $count_post_pending = Post::where('status','pending')->count();
        $count_post_trash = Post::onlyTrashed()->count();
        $count = [$count_post_public,$count_post_pending, $count_post_trash];
        return view('admin.post.show', compact('posts', 'count', 'list_act'));
    }


    function add(){
        $htmlOption = $this->categoryRecursive($parentId = '');
        return view('admin.post.add', compact('htmlOption'));
    }

    function store(Request $request){
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'status' => 'required',
                'post_thumb' => 'required',
                'category' => 'required'
            ],
            [
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'content' => 'Nội dung bài viết',
                'status' => 'Trạng thái',
                'post_thumb' => 'Hình ảnh bài viết',
                'category' => 'Danh mục bài viết'
            ]
        );

        $input = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'slug' => Str::slug($request->input('title')),
            'category_id' => $request->input('category'),
            'status' => $request->input('status'),
        ];

        if($request->hasFile('post_thumb')){
            $file = $request->post_thumb;
            $filename = $file->getClientOriginalName();
            $path = $file->move('public/uploads/post',$filename);
            $thumbnail = "public/uploads/post/". $filename;
            $input['post_thumb'] = $thumbnail;
        }
        Post::create($input);
        return redirect('admin/post/list')->with('status', 'Thêm bài viết mới thành công');
    }

    function edit($id){
        $post = Post::find($id);
        $htmlOption = $this->categoryRecursive($post->category->id);
        return view('admin.post.edit', compact('post', 'htmlOption'));
    }

    function update(Request $request, $id){
        $post = Post::find($id);
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'status' => 'required',
                'category' => 'required'
            ],
            [
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'content' => 'Nội dung bài viết',
                'status' => 'Trạng thái',
                'category' => 'Danh mục bài viết'
            ]
        );

        $input = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'slug' => Str::slug($request->input('title')),
            'category_id' => $request->input('category'),
            'status' => $request->input('status'),
        ];

        if($request->hasFile('post_thumb')){
            $file = $request->post_thumb;
            $filename = $file->getClientOriginalName();
            $path = $file->move('public/uploads/post',$filename);
            $thumbnail = "public/uploads/post/". $filename;
            $input['post_thumb'] = $thumbnail;
        }
        Post::find($id)->update($input);
        return redirect('admin/post/list')->with('status', 'Cập nhật bài viết thành công');
    }

    function delete($id){
        Post::find($id)->delete();
        return redirect('admin/post/list')->with('status', 'Xóa bài viết thành công');
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            $act = $request->input('act');
            if($act == "delete"){
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status', 'Xóa bài viết thành công');
            }

            if($act == "restore"){
                Post::withTrashed()
                ->whereIn('id',$list_check)
                ->restore();
                return redirect('admin/post/list')->with('status','Khôi phục bài viết thành công');
            }

            if($act == "forceDelete"){
                Post::withTrashed()
                ->whereIn('id',$list_check)
                ->forceDelete();
                return redirect('admin/post/list')->with('status', 'Đã xóa vĩnh viễn bài viết thành công');
            }
        }else{
            return redirect('admin/post/list')->with('status', 'Bạn cần chọn ít nhất một bản ghi để thao tác');
        }
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('uploads'), $fileName);
       
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/'.$fileName); 
            $msg = 'Tải ảnh lên thành công'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
}
