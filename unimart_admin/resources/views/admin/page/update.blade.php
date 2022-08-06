@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật trang {{ strtolower($page->title) }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.page.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    <div class="form-group">
                        <label for="title">Tiêu đề trang</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ $page->title }}">
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
                        <label for="summary">Tóm tắt trang</label>
                        <textarea name="summary" class="form-control" id="summary" cols="30" rows="5">{{ $page->summary }}</textarea>
                    </div>
                    @error('summary')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <textarea name="content" class="form-control tiny" id="content" cols="30" rows="5">{!! $page->content !!}</textarea>
                    </div>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label for="author_id">Tác giả</label>
                        <select name="author_id" id="author_id" class='form-control'>
                            <option value="">Chọn tác giả</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if ($page->author_id == $user->id) selected @endif>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('author_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
