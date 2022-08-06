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
                <h5 class="m-0 ">Danh sách trang</h5>
                <div class="form-inline">
                    <form action="{{ request()->r }}" method="POST" class="">
                        @csrf
                        <input type="" name='keyword' class="form-control" placeholder="Tìm kiếm">
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
                {!! Form::open(['route' => 'admin.page.action', 'method' => 'post']) !!}
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
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Tóm tắt</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác giả</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($pages->count() > 0)
                            @foreach ($pages as $key => $page)
                                @php
                                    $author = App\User::find($page->author_id);
                                @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="page_id[]" value={{ $page->id }}>
                                    </td>
                                    <td scope="row">{{ $pages->firstItem() + $key }}</td>
                                    <td><a href="#">{{ $page->title }}</a>
                                    </td>
                                    <td><span class="text">{{ $page->summary }}</span>
                                    </td>
                                    <td class='list-date'>{{ $page->created_at }}</td>
                                    <td class='list-name'>{{ $author->name }}</td>
                                    @if (request()->input('status') == 'trash')
                                        <td class='list-function'>
                                            <a href="{{ route('admin.page.restore', $page->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" title="Edit"><i
                                                    class="fa-solid fa-trash-arrow-up"></i></a>
                                            <a href="{{ route('admin.page.permantly_del', $page->id) }}"
                                                onclick="return confirm('Bạn có chắc muốn xóa vĩnh viển bản ghi này?')"
                                                class="btn btn-danger btn-sm rounded-0 text-white" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    @else
                                        <td class='list-function'>
                                            <a href="{{ route('admin.page.update', $page->id) }}"
                                                class="btn btn-success btn-sm rounded-0" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.page.delete', $page->id) }}"
                                                class="btn btn-danger btn-sm rounded-0" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class='bg-white' colspan="7">Không tìm thấy bản ghi trả về</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $pages->withQueryString()->links() }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
