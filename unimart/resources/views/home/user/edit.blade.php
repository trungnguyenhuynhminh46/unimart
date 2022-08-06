@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('inner')
    @php
    $user = Auth::user();
    @endphp
    <div id="wrapper" class="wp-inner clearfix">
        <h1 class="title">Trang chỉnh sửa thông tin người dùng</h1>
        <div class="card">
            <div class="card-header">Chỉnh sửa thông tin</div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="form-group row no-gutters">
                                <label for="name">Họ và tên</label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $user->name }}" autocomplete="name" autofocus>
                            </div>
                            @error('name')
                                <p class="text-danger my-1">{{ $message }}</p>
                            @enderror
                            <div class="form-group row no-gutters">
                                <label for="username">Tên đăng nhập</label>
                                <input type="text" id="username"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ $user->username }}" autocomplete="username" autofocus readonly>
                            </div>
                            @error('username')
                                <p class="text-danger my-1">{{ $message }}</p>
                            @enderror
                            <div class="form-group row no-gutters">
                                <label for="phone_number">Số điện thoại</label>
                                <input type="number" id="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror" name="phone_number"
                                    value="{{ $user->phone_number }}" autocomplete="phone_number" autofocus>
                            </div>
                            @error('phone_number')
                                <p class="text-danger my-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 pl-4">
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <textarea name="address" class="form-control" id="address" cols="30" rows="5"
                                    placeholder="Địa chỉ vận chuyển">{{ $user->address }}</textarea>
                            </div>
                            @error('address')
                                <p class="text-danger my-1">{{ $message }}</p>
                            @enderror
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                                    {{ $user->gender == 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">
                                    Nam
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                                    {{ $user->gender == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">
                                    Nữ
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row no-gutters">
                        <label for="email">Địa chỉ email</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" autocomplete="email" value="{{ $user->email }}" readonly>
                    </div>
                    @error('email')
                        <p class="text-danger my-1">{{ $message }}</p>
                    @enderror
                    <div class="form-group row no-gutters">
                        <label for="password">Mật khẩu</label>

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="new-password">
                    </div>
                    @error('password')
                        <p class="text-danger my-1">{{ $message }}</p>
                    @enderror
                    <div class="form-group row no-gutters">
                        <label for="password-confirm">Nhập lại mật khẩu</label>

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            autocomplete="new-password">

                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('home/js/main.js') }}" type="text/javascript"></script>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
