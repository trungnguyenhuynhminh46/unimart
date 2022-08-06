@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-inline">
                    <form action="{{ request()->r }}" method="POST">
                        @csrf
                        <input type="" name="keyword" class="form-control" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            {!! Form::open(['route' => 'admin.post.action', 'method' => 'post']) !!}
            @csrf
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}" class="text-primary">Đã xác
                        nhận<span class="text-muted">({{ $number_approved }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chưa xác
                        nhận<span class="text-muted">({{ $number_pending }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'warning']) }}" class="text-primary">Cảnh
                        cáo<span class="text-muted">({{ $number_warning }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $number_trash }})</span></a>
                </div>
                <div class="form-action form-inline py-3">
                    @if (request()->input('status') == 'trash')
                        <select name='opt' class="form-control mr-1" id="">
                            <option value='permantly_del'>Xóa vĩnh viễn</option>
                            <option value='recover'>Khôi phục</option>
                        </select>
                    @elseif(request()->input('status') == 'pending')
                        <select name='opt' class="form-control mr-1" id="">
                            <option value="approved">Đánh dấu là đã xác nhận</option>
                            <option value="warning">Đánh dấu là bị cảnh cáo</option>
                            <option value='delete'>Xóa</option>
                        </select>
                    @elseif(request()->input('status') == 'warning')
                        <select name='opt' class="form-control mr-1" id="">
                            <option value="approved">Đánh dấu là đã xác nhận</option>
                            <option value="pending">Đánh dấu là chưa xác nhận</option>
                            <option value='delete'>Xóa</option>
                        </select>
                    @else
                        <select name='opt' class="form-control mr-1" id="">
                            <option value="pending">Đánh dấu là chưa xác nhận</option>
                            <option value="warning">Đánh dấu là bị cảnh cáo</option>
                            <option value='delete'>Xóa</option>
                        </select>
                    @endif
                    <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $key => $post)
                            <tr>
                                <td>
                                    <input type="checkbox" name="post_ids[]" value='{{ $post->id }}'>
                                </td>
                                <td scope="row">{{ $posts->firstItem() + $key }}</td>
                                <td><img class='thumbnail' src="{{ $post->thumbnail }}" alt=""></td>
                                <td><a href="{{ route('admin.post.update', $post->id) }}">{{ $post->title }}</a>
                                </td>
                                <td><a
                                        href="{{ route('admin.post.category.update', $post->category->id) }}">{{ $post->category->name }}</a>
                                </td>
                                <td>{{ $post->created_at }}</td>
                                @if ($post->status == 'approved')
                                    <td><span class="badge badge-success">Đã xác nhận</span></td>
                                @elseif($post->status == 'pending')
                                    <td><span class="badge badge-warning">Chưa xác nhận</span></td>
                                @elseif($post->status == 'warning')
                                    <td><span class="badge badge-danger">Cảnh cáo</span></td>
                                @endif
                                @if (request()->input('status') == 'trash')
                                    <td>
                                        <a href="{{ route('admin.post.restore', $post->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Khôi phục"><i
                                                class="fa-solid fa-trash-arrow-up"></i></a>
                                        <a href="{{ route('admin.post.permantly_del', $post->id) }}"
                                            onclick="return confirm('Bạn có chắc muốn xóa vĩnh viển bản ghi này?')"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                @else
                                    <td>
                                        <a href="{{ route('admin.post.update', $post->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.post.delete', $post->id) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Xóa"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->withQueryString()->links() }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
