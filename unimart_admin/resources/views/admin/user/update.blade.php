@extends('layouts/admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa thông tin {{ $user->name }}
            </div>
            <div class="card-body">

                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value='update'>
                    <input type="hidden" name="id" value='{{ $user->id }}'>
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name"
                            value='{{ $user->name }}'>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" value="{{ $user->email }}" type="text" name="email" id="email"
                            disabled>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input class="form-control" value="" type="password" name="password" id="password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Xác nhận mật khẩu</label>
                        <input class="form-control" value="" type="password" name="password_confirmation"
                            id="password-confirm">
                    </div>

                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        <select name='role_id' class="form-control" id="">
                            <option value=''>Chọn quyền</option>
                            @foreach ($roles as $role)
                                <option value='{{ $role->id }}'
                                    @isset($user->role->id) @if ($user->role->id == $role->id)
                                            selected @endif
                                @endisset>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
