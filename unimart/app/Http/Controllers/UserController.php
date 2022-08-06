<?php

namespace App\Http\Controllers;

use App\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function edit()
    {
        return view('home.user.edit');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'address' => ['required', 'string', 'max:1000'],
                'phone_number' => ['required', 'numeric'],
                'gender' => ['required']
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute bắt buộc là chuỗi',
                'max' => ':attribute có độ dài không được vượt quá :max ký tự',
                'min' => ':attribute có độ dài không được ít hơn :min ký tự',
                'unique' => ':attribute đã tồn tại',
                'numeric' => ':attribute bạn nhập không đúng định dạng',
                'confirmed' => 'Mật khẩu và mật khẩu xác nhận không khớp'
            ],
            [
                'name' => 'Họ và tên',
                'password' => 'Mật khẩu',
                'address' => 'Mật khẩu xác nhận',
                'phone_number' => 'Số điện thoại',
                'gender' => 'Giới tính'
            ]
        );
        $input = $request->input();
        $user = Accounts::find(Auth::id());
        $user->name = $input['name'];
        $user->username = $input['username'];
        $user->phone_number = $input['phone_number'];
        $user->address = $input['address'];
        $user->gender = $input['gender'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();
        return redirect()->route('home');
    }
}
