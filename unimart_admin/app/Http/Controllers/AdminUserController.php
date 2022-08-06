<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $key_word = '';
        $input = $request->all();
        if ((isset($input['btn-search'])) && ($request->isMethod('POST'))) {
            $key_word = $input['key-word'];
        }
        $active = User::where('name', 'LIKE', '%' . $key_word . '%')->paginate(10);
        $trashed = User::where('name', 'LIKE', '%' . $key_word . '%')->onlyTrashed()->paginate(10);
        $count_active = $active->count();
        $count_trash = $trashed->count();
        if ($request->input('status') == 'trash') {
            $users = $trashed;
        } else {
            $users = $active;
        }
        return view('admin.user.list', compact('users', 'count_active', 'count_trash'));
    }

    function add()
    {
        $roles = Role::get();
        return view('admin.user.add', compact('roles'));
    }

    function delete($id)
    {
        $name = '';
        $message = '';
        if (Auth::id() != $id) {
            $user = User::find($id);
            $user->delete();
            $name = 'success';
            $message = 'Đã đưa thành công thành viên ' . $user->name . ' vào thùng rác';
        } else {
            $name = 'error';
            $message = 'Bạn không thể tự xóa bản thân';
        }
        return redirect()->route('admin.user.list')->with($name, $message);
    }

    function update($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        return view('admin.user.update', compact('user', 'roles'));
    }

    function store(Request $request)
    {
        $input = $request->input();
        $old_pass = $input['password'];
        $date = date("Y-m-d H:i:s");
        $input['email_verified_at'] = $date;
        $input['password'] = Hash::make($old_pass);
        $message = '';
        if ($input['action'] == 'add') {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute bắt buộc là chuỗi',
                    'max' => ':attribute có độ dài không được vượt quá :max ký tự',
                    'min' => ':attribute có độ dài không được ít hơn :min ký tự',
                    'unique' => ':attribute đã được dùng trong hệ thống',
                    'confirmed' => 'Xác nhận mật khẩu không thành công'
                ],
                [
                    'name' => 'Họ tên',
                    'email' => 'Địa chỉ email',
                    'password' => 'Mật khẩu'
                ]
            );
        } elseif ($input['action'] == 'update') {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:8|confirmed',
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute bắt buộc là chuỗi',
                    'max' => ':attribute có độ dài không được vượt quá :max ký tự',
                    'min' => ':attribute có độ dài không được ít hơn :min ký tự',
                    'unique' => ':attribute đã được dùng trong hệ thống',
                    'confirmed' => 'Xác nhận mật khẩu không thành công'
                ],
                [
                    'name' => 'Họ tên',
                    'password' => 'Mật khẩu'
                ]
            );
        }
        $input['role_id'] == '' ? null : $input['role_id'];
        if ($input['action'] == 'add') {
            User::create($input);
            $message = 'Thêm thành công quản trị viên mới vào hệ thống';
        } elseif ($input['action'] == 'update') {
            $id = $input['id'];
            User::find($id)->update($input);
            $message = 'Cập nhật thành công';
            if (Auth::id() == $id) {
                return redirect()->route('logout');
            }
        }
        return redirect()->route('admin.user.list')->with('success', $message);
    }

    function action(Request $request)
    {
        // return dd($request->input());
        //  Đảm bảo không có id người đăng nhập
        $has_user = false;
        $list_ids = $request->input('list_check');
        $opt = $request->input('opt');
        $status_name = '';
        $message = '';
        if (!empty($list_ids) && !empty($request->input('btn-search'))) {
            if (is_array($list_ids)) {
                foreach ($list_ids as $key => $id) {
                    if (Auth::id() == $id) {
                        unset($list_ids[$key]);
                        $has_user = true;
                    }
                }
                // Kiểm tra tác vụ gì và thực hiện
                if ($has_user && empty($list_ids)) {
                    if ($opt == 'delete') {
                        $status_name = 'error';
                        $message = 'Bạn không thể xóa bản thân ra khỏi hệ thống';
                    }
                } else {
                    if ($opt == 'delete') {
                        User::destroy($list_ids);
                        $status_name = 'success';
                        $message = 'Đã thêm thành công các thành viên được chọn vào thùng rác';
                    } elseif ($opt == 'recover') {
                        User::onlyTrashed()->whereIn('id', $list_ids)->restore();
                        $status_name = 'success';
                        $message = 'Đã khôi phục thành công các thành viên từ thùng rác';
                    } elseif ($opt == 'permantly_del') {
                        User::onlyTrashed()->whereIn('id', $list_ids)->forceDelete();
                        $status_name = 'success';
                        $message = 'Đã xóa vĩnh viễn các thành viên được chọn';
                    }
                }
            }
        } else {
            $status_name = 'error';
            $message = 'Bạn chưa chọn người dùng';
        }

        // Trả về trang hiển thị
        return redirect()->route('admin.user.list')->with($status_name, $message);
    }

    function restore($id)
    {
        User::onlyTrashed()->find($id)->restore();
        return redirect('/admin/user/list?status=trash')->with('success', 'Khôi phục dữ liệu thành công');
    }

    function permantly_del($id)
    {
        User::onlyTrashed()->find($id)->forceDelete();
        return redirect('/admin/user/list?status=trash')->with('success', 'Xóa dữ liệu khỏi thùng rác thành công');
    }
}
