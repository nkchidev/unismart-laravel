<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class AdminPageController extends Controller
{
    //
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'page']);

            return $next($request);
        });
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
            $pages = Page::onlyTrashed()->where('title','like',"%{$keyword}%")->paginate(5);
        }else if($status == 'pending'){
            $pages = Page::where([
                ['status','pending'],
                ['title', 'like', "%{$keyword}%"]
            ])->paginate(5);
        }else{
            // $pages = Page::where('title','like', "%{$keyword}%")->paginate(5);
            $pages = Page::where([
                ['status','public'],
                ['title', 'like', "%{$keyword}%"]
            ])->paginate(5);
        }

        $count_page_public = Page::where('status','public')->count();
        $count_page_pending = Page::where('status','pending')->count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count = [$count_page_public,$count_page_pending, $count_page_trash];
        return view('admin.page.show', compact('pages', 'list_act', 'count'));
    }

    function add(){
        return view('admin.page.add');
    }

    function store(Request $request){
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'string|max:255',
                'status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'status' => 'Trạng thái',
                'slug' => 'Link thân thiện'
            ]
        );
        Page::create([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'content' => $request->input('content'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/page/list')->with('status' , 'Thêm trang mới thành công');
    }

    function delete($id){
        $page = Page::find($id);
        $page->delete();
        return redirect('admin/page/list')->with('status', 'Xóa trang thành công');
    }

    function edit($id){
        $page = Page::find($id);
        return view('admin.page.edit', compact('page'));
    }

    function update(Request $request,$id){
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'string|max:255',
                'status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'status' => 'Trạng thái'
            ]
        );
        Page::find($id)->update([
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'content' => $request->input('content'),
            'status' => $request->input('status')
        ]);
        return redirect('admin/page/list')->with('status' , 'Cập nhật thông tin trang thành công');
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        if(!empty($list_check)){
            $act = $request->input('act');
            if($act == "delete"){
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Xóa trang thành công');
            }

            if($act == "restore"){
                Page::withTrashed()
                ->whereIn('id',$list_check)
                ->restore();
                return redirect('admin/page/list')->with('status','Khôi phục trang thành công');
            }

            if($act == "forceDelete"){
                Page::withTrashed()
                ->whereIn('id',$list_check)
                ->forceDelete();
                return redirect('admin/page/list')->with('status', 'Đã xóa vĩnh viễn trang thành công');
            }
        }else{
            return redirect('admin/page/list')->with('status', 'Bạn cần chọn ít nhất một bản ghi để thao tác');
        }
    }
}
