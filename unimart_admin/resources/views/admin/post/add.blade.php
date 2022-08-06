@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ old('title') }}">
                    </div>
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input class="form-control" type="text" name="slug" id="slug">
                    </div>
                    @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="user_id">Tác giả</label>
                        <select name="user_id" id="user_id" class='form-control user_id'>
                            <option value="">Chọn tác giả</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if (old('user_id') == $user->id) selected @endif>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('user_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="summary">Tóm tắt bài viết</label>
                        <textarea name="summary" class="form-control" id="summary" cols="30" rows="5">{{ old('summary') }}</textarea>
                    </div>
                    @error('summary')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control tiny" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                    </div>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input class="form-control" type="text" name="tags" id="tags"
                            value="{{ empty(old('tags')) ? 'Bài viết' : old('tags') }}"
                            title="Các tags cách nhau bởi dấu phẩy" data-role="tagsinput">
                    </div>
                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select name="cat_id" class="form-control" id="">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (old('cat_id') == $category->id) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('cat_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="">Chọn ảnh đại diện cho bài viết</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm-update" data-input="thumbnail" data-preview="holder" class="btn btn-light">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="thumbnail"
                                value="{{ empty(old('thumbnail')) ? url('storage/app/public/photos/9/images/default_thumbnail.png') : old('thumbnail') }}">
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;">
                    </div>
                    @error('file')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="pending"
                                @if (empty(old('status')) || old('status') == 'pending') checked @endif>
                            <label class="form-check-label" for="status1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="approved"
                                @if (old('status') == 'approved') checked @endif>
                            <label class="form-check-label" for="status2">
                                Đã duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status3"
                                value="warning" @if (old('status') == 'warning') checked @endif>
                            <label class="form-check-label" for="status3">
                                Cảnh cáo
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
