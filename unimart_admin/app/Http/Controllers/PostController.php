<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCat;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    // Nhóm các hàm chính

    function list(Request $request)
    {
        $number_approved = Post::where('status', 'approved')->get()->count();
        $number_pending = Post::where('status', 'pending')->get()->count();
        $number_warning = Post::where('status', 'warning')->get()->count();
        $number_trash = Post::onlyTrashed()->get()->count();
        // Trả về keyword
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
        // Trả về danh sách id các danh mục có tên chứa keyword
        $list_categories_ids = [];
        $categories = PostCat::where('name', 'LIKE', "%{$keyword}%")->get();
        foreach ($categories as $category) {
            $list_categories_ids[] = $category->id;
        }
        // Xử lý theo biến status
        $status = 'approved';
        if ($request->input('status') != null) {
            $status = $request->input('status');
        }
        $posts = Post::where(function ($query) use ($keyword, $list_author_ids, $list_categories_ids) {
            $query->where('title', 'LIKE', "%{$keyword}%")
                ->orWhereIn('cat_id', $list_categories_ids)
                ->orWhereIn('user_id', $list_author_ids)
                ->orWhere('summary', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%");
        });
        if ($status == 'approved') {
            $posts = $posts->where('status', 'approved')->paginate(10);
        } elseif ($status == 'pending') {
            $posts = $posts->where('status', 'pending')->paginate(10);
        } elseif ($status == 'warning') {
            $posts = $posts->where('status', 'warning')->paginate(10);
        } elseif ($status == 'trash') {
            $posts = $posts->onlyTrashed()->paginate(10);
        }
        return view('admin.post.list', compact('posts', 'number_approved', 'number_pending', 'number_warning', 'number_trash'));
    }

    function add()
    {
        $users = User::get();
        $categories = PostCat::get();
        return view('admin.post.add', compact('categories', 'users'));
    }

    function update($post_id)
    {
        $users = User::get();
        $categories = PostCat::get();
        $post = Post::find($post_id);
        return view('admin.post.update', compact('users', 'categories', 'post'));
    }

    function delete($id)
    {
        Post::destroy($id);
        return redirect(url()->previous())->with('success', 'Xóa bài viết thành công');
    }

    function restore($id)
    {
        Post::where('id', $id)->restore();
        return redirect()->route('admin.post.list')->with('success', 'Khôi phục bài viết thành công');
    }

    function permantly_del($id)
    {
        Post::where('id', $id)->forceDelete();
        return redirect()->route('admin.post.list')->with('success', 'Đã xóa vĩnh viễn bài viết khỏi hệ thống');
    }

    function store(Request $request)
    {
        // Validation
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'summary' => 'required|string|max:1000',
                'content' => 'required|string|min:100',
                'user_id' => 'required',
                'cat_id' => 'required',
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
                'summary' => 'Tóm tắt bài viết',
                'content' => 'Nội dung bài viết',
                'user_id' => 'Tác giả',
                'cat_id' => 'Danh mục',
                'slug' => 'Slug'
            ]
        );
        $status_name = 'error';
        $message = "Không có thay đổi nào được diễn ra";
        $input = $request->input();
        $action = $input['action'];
        if (isset($input['post_id'])) {
            $post_id = $input['post_id'];
        }

        if ($action == 'update') {
            Post::find($post_id)->update($input);
            $status_name = 'success';
            $message = "Cập nhật bài viết thành công";
        } elseif ($action == 'add') {
            Post::create($input);
            $status_name = 'success';
            $message = "Thêm bài viết thành công";
        }
        return redirect(route('admin.post.list') . "?status={$input['status']}")->with($status_name, $message);
    }
    // Nhóm các hàm tương tác với danh mục bài viết
    function listCat()
    {
        $post_cats = PostCat::paginate(5);
        return view('admin.post.category.list', compact('post_cats'));
    }

    function addCat(Request $request)
    {
        $request->validate(
            [
                'name' => ['required'],
                'slug' => ['required'],
            ],
            [
                'required' => ':attribute không được để trống'
            ],
            [
                'name' => 'Tên danh mục bài viết',
                'slug' => 'Slug'
            ]
        );
        $input = $request->input();
        PostCat::create($input);
        return redirect()->route('admin.post.category.list')->with('success', 'Thêm danh mục bài viết thành công');
    }

    function updateCat($cat_id)
    {
        $category = PostCat::find($cat_id);
        return view('admin.post.category.update', compact('category'));
    }

    function storeCat(Request $request)
    {
        $request->validate(
            [
                'name' => ['required']
            ],
            [
                'required' => ':attribute không được để trống'
            ],
            [
                'name' => 'Tên danh mục bài viết'
            ]
        );
        $input = $request->input();
        $post_cat_id = $input['post_cat_id'];
        PostCat::find($post_cat_id)->update($input);
        return redirect()->route('admin.post.category.list')->with('success', 'Cập nhật danh mục bài viết thành công');
    }

    function deleteCat($cat_id)
    {
        PostCat::find($cat_id)->delete();
        return redirect()->route('admin.post.category.list')->with('success', 'Xóa danh mục bài viết thành công');
    }
    // Nhóm các hàm thực hiện các tác vụ nhiều đối tượng
    function action(Request $request)
    {
        $status_name = "";
        $message = "";
        $input = $request->input();
        if (isset($input['post_ids'])) {
            $post_ids = $input['post_ids'];
            $opt = $input['opt'];
            if ($opt == 'approved') {
                Post::whereIn('id', $post_ids)->update(['status' => 'approved']);
                $status_name = "success";
                $message = "Các bài viết được chọn vừa được chuyển sang mục các trang được xác nhận";
            } elseif ($opt == 'pending') {
                Post::whereIn('id', $post_ids)->update(['status' => 'pending']);
                $status_name = "success";
                $message = "Các bài viết được chọn vừa được chuyển sang mục các trang chưa được xác nhận";
            } elseif ($opt == 'warning') {
                Post::whereIn('id', $post_ids)->update(['status' => 'warning']);
                $status_name = "success";
                $message = "Các bài viết được chọn vừa được chuyển sang mục các trang bị cảnh cáo";
            } elseif ($opt == 'delete') {
                Post::whereIn('id', $post_ids)->delete();
                $status_name = "success";
                $message = "Các bài viết được chọn vừa được chuyển vào thùng rác";
            } elseif ($opt == 'permantly_del') {
                Post::whereIn('id', $post_ids)->forceDelete();
                $status_name = "success";
                $message = "Các bài viết được chọn vừa được xóa vĩnh viễn";
            } elseif ($opt == 'recover') {
                Post::whereIn('id', $post_ids)->restore();
                $status_name = "success";
                $message = "Các bài viết được chọn vừa được khôi phục";
            }
        } else {
            $status_name = "error";
            $message = "Bạn phải chọn ít nhất một bản ghi để thực hiện các tác vụ!";
        }
        return redirect(url()->previous())->with($status_name, $message);
    }
}
