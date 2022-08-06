@extends('layouts/admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="#" class='search-box' method="POST">
                        @csrf
                        <input type="" class="form-control form-search" name='key-word'
                            value='{{ request()->input('key-word') }}' placeholder="Tìm kiếm theo tên">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Active<span
                            class="text-muted">({{ $count_active }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count_trash }})</span></a>
                </div>
                {!! Form::open(['route' => 'admin.user.action', 'method' => 'post']) !!}
                @csrf
                <div class="form-action form-inline py-3">
                    @if (request()->input('status') == 'trash')
                        <select name='opt' class="form-control mr-1" id="">
                            <option value='permantly_del'>Xóa vĩnh viễn</option>
                            <option value='recover'>Khôi phục</option>
                        </select>
                    @else
                        <select name='opt' class="form-control mr-1" id="">
                            <option value='delete'>Xóa</option>
                        </select>
                    @endif
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->total() > 0)
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" name='list_check[]' value='{{ $user->id }}'>
                                    </td>
                                    <th scope="row">{{ $users->firstItem() + $key }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role_id != null)
                                            {{ $user->role->name }}
                                        @else
                                            Chưa cấp quyền
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    @if (request()->input('status') == 'trash')
                                        <td>
                                            <a href="{{ route('admin.user.restore', $user->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa-solid fa-trash-arrow-up"></i></a>
                                            @if (Auth::id() != $user->id)
                                                <a href="{{ route('admin.user.permantly_del', $user->id) }}"
                                                    onclick="return confirm('Bạn có chắc muốn xóa vĩnh viển bản ghi này?')"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ route('admin.user.update', $user->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::id() != $user->id)
                                                <a href="{{ route('admin.user.delete', $user->id) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="bg-white">Không tìm thấy bản ghi trả về</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                {{ $users->withQueryString()->links() }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
