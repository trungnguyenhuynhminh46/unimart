@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Chỉnh sửa thông tin sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title">Tên sản phẩm</label>
                                <input class="form-control" type="text" name="name" value="{{ $product->name }}"
                                    id="title">
                            </div>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug">
                            </div>
                            @error('slug')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="old_price">Giá cũ</label>
                                        <input class="form-control" type="number" name="old_price" id="old_price"
                                            value="{{ $product->old_price }}">
                                    </div>
                                    @error('old_price')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="price">Giá</label>
                                        <input class="form-control" type="number" name="price" id="price"
                                            value="{{ $product->price }}">
                                    </div>
                                    @error('price')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="qty">Số lượng</label>
                                        <input class="form-control" type="number" name="qty" id="qty"
                                            value="100">
                                    </div>
                                    @error('qty')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="description">Mô tả sản phẩm</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="8">{{ $product->description }}</textarea>
                            </div>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Ảnh đại diện sản phẩm</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm-product-add" data-input="thumbnail" data-preview="holder" class="btn btn-light">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" name="thumbnail"
                                value="{{ url($product->thumbnail) }}">
                        </div>
                        <img id="holder" style="margin-top:15px;max-height:100px;">
                    </div>

                    <div class="form-group">
                        <label for="summary">Tóm tắt chi tiết sản phẩm</label>
                        <textarea name="summary" class="form-control" id="summary" cols="30" rows="5">{{ $product->summary }}</textarea>
                    </div>
                    @error('summary')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="form-group">
                        <label for="content">Chi tiết sản phẩm</label>
                        <textarea name="content" class="form-control tiny" id="content" cols="30" rows="5">{!! $product->content !!}</textarea>
                    </div>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input class="form-control" type="text" name="tags" id="tags"
                            value="{{ $product->tags }}" title="Các tags cách nhau bởi dấu phẩy" data-role="tagsinput">
                    </div>
                    <div class="form-group">
                        <label for="">Người tạo</label>
                        <select class="form-control" name="user_id" id="user_id">
                            <option value="">Chọn danh mục</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $product->user->id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('user_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror

                    <div class="form-group">
                        <label for="">Danh mục sản phẩm</label>
                        <select class="form-control" name="cat_id" id="cat_id">
                            <option value="">Chọn danh mục</option>
                            {!! $htmlOptions !!}
                        </select>
                    </div>
                    @error('cat_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
