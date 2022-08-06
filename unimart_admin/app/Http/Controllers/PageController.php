<?php

namespace App\Http\Controllers;

use App\Page;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $input = $request->input();
        $keyword = '';
        if (!empty($input['keyword'])) {
            $keyword = $input['keyword'];
        }
        // Trả về danh sách id của các tác giả có tên chứa keyword
        $list_author_ids = [];
        $authors = User::where('name', 'LIKE', "%{$keyword}%")->get();
        foreach ($authors as $author) {
            $list_author_ids[] = $author->id;
        }
        // 
        $active = Page::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('summary', 'LIKE', "%{$keyword}%")
            ->orWhere('content', 'LIKE', "%{$keyword}%")
            ->orWhereIn('author_id', $list_author_ids)
            ->paginate(10);
        $trashed = Page::onlyTrashed()->where(function ($query) use ($keyword, $list_author_ids) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('summary', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%")
                ->orWhereIn('author_id', $list_author_ids);
        })->paginate(10);
        $count_active = $active->count();
        $count_trash = $trashed->total();
        $pages = null;
        if ($request->input('status') == 'trash') {
            $pages = $trashed;
        } else {
            $pages = $active;
        }
        return view('admin.page.list', compact('pages', 'count_active', 'count_trash'));
    }

    function add()
    {
        $users = User::get();
        return view('admin.page.add', compact('users'));
    }

    function update(Request $request)
    {
        $users = User::get();
        $page = Page::find($request->id);
        return view('admin.page.update', compact('page', 'users'));
    }

    function store(Request $request)
    {
        $status_name = '';
        $message = '';
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'summary' => 'required|string|max:500',
                'content' => 'required|string|min:100',
                'author_id' => 'required',
                'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute bắt buộc là chuỗi',
                'max' => ':attribute có độ dài không được vượt quá :max ký tự',
                'min' => ':attribute có độ dài không được ít hơn :min ký tự'
            ],
            [
                'title' => 'Tiêu đề',
                'summary' => 'Tóm tắt trang',
                'content' => 'Nội dung trang',
                'author_id' => 'Tác giả',
                'slug' => 'Slug'
            ]
        );
        $input = $request->input();
        $action = $request->input('action');
        if ($request->input('page_id')) {
            $page_id = $request->input('page_id');
        }
        if ($action == 'add') {
            Page::create($input);
            $status_name = 'succcess';
            $message = 'Thêm trang vào hệ thống thành công';
        } elseif ($action == 'update') {
            Page::find($page_id)->update($input);
            $status_name = 'succcess';
            $message = 'Cập nhật trang trong hệ thống thành công';
        }
        return redirect()->route('admin.page.list')->with($status_name, $message);
    }

    function delete($id)
    {
        Page::destroy([$id]);
        return redirect()->route('admin.page.list')->with('success', 'Xóa trang thành công ra khỏi hệ thống');
    }

    function action(Request $requests)
    {
        $status_name = '';
        $message = '';
        $input = $requests->input();
        $opt = $input['opt'];
        if (!isset($input['page_id'])) {
            $status_name = 'error';
            $message = 'Bạn phải chọn ít nhất một trang để thực hiện các tác vụ';
        } else {
            $pages_id = $input['page_id'];
            if ($opt == 'delete') {
                Page::destroy($pages_id);
                $status_name = 'success';
                $message = 'Xóa bản ghi thành công';
            } elseif ($opt == 'permantly_del') {
                Page::onlyTrashed()->whereIn('id', $pages_id)->forceDelete();
                $status_name = 'success';
                $message = 'Các bản ghi đã được xóa vĩnh viễn';
            } elseif ($opt == 'recover') {
                Page::onlyTrashed()->whereIn('id', $pages_id)->restore();
                $status_name = 'success';
                $message = 'Khôi phục các bản ghi thành công';
            }
        }
        return redirect()->route('admin.page.list')->with($status_name, $message);
    }

    function restore($id)
    {
        Page::where('id', '=', $id)->restore();
        return redirect(route('admin.page.list') . '?status=trash')->with('success', 'Khôi phục trang đã xóa thành công!');
    }

    function permantly_del($id)
    {
        Page::where('id', '=', $id)->forceDelete();
        return redirect(route('admin.page.list') . '?status=trash')->with('success', 'Xóa vĩnh viễn trang thành công');
    }
}
