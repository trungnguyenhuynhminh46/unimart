@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa danh mục bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('admin.post.category.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_cat_id" value="{{ $category->id }}">
                    <div class="form-group">
                        <label for="title">Tên danh mục</label>
                        <input class="form-control" type="text" name="name" id="title"
                            value="{{ $category->name }}">
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
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
