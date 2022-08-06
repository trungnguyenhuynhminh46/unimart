@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm danh mục
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('admin.product.category.add') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" id="title">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug">
                                @error('slug')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select name="parent_id" class="form-control" id="">
                                    <option value="">Chọn danh mục</option>
                                    {!! $htmlOptions !!}
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục sản phẩm</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                    $page = 1;
                                    $first = 1;
                                    if (request()->input('page') != null) {
                                        $page = request()->input('page');
                                        $first = ($page - 1) * $perPage + 1;
                                    }
                                @endphp
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <th scope="row">{{ $first + $i }}</th>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.product.category.update', $category->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                    class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.product.category.delete', $category->id) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Xóa"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
