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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-inline">
                    <form action="{{ request()->r }}" method="POST">
                        @csrf
                        <input type="" name="keyword" class="form-control" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            {!! Form::open(['route' => 'admin.product.action', 'method' => 'post']) !!}
            @csrf
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'available']) }}" class="text-primary">Còn
                        hàng<span class="text-muted">({{ $available_count }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'sold_out']) }}" class="text-primary">Hết
                        hàng<span class="text-muted">({{ $sold_out_count }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $trash_count }})</span></a>
                </div>
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
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                            @php
                                $status = $product->qty > 0 ? 'available' : 'sold_out';
                            @endphp
                            <tr class="">
                                <td>
                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}">
                                </td>
                                <td>{{ $products->firstItem() + $key }}</td>
                                <td><img class="thumbnail" src="{{ url($product->thumbnail) }}" alt=""></td>
                                <td><a href="{{ route('admin.product.update', $product->id) }}">{{ $product->name }}</a>
                                </td>
                                <td>{{ number_format($product->price, 0, '.', ',') }}đ</td>
                                <td><a
                                        href="{{ route('admin.product.category.update', $product->category->id) }}">{{ $product->category->name }}</a>
                                </td>
                                <td>{{ $product->created_at }}</td>
                                @if ($status == 'available')
                                    <td><span class="badge badge-success">Còn hàng</span></td>
                                @elseif($status == 'sold_out')
                                    <td><span class="badge badge-light">Bán hết</span></td>
                                @endif
                                @if (request()->input('status') == 'trash')
                                    <td>
                                        <a href="{{ route('admin.product.restore', $product->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Khôi phục"><i
                                                class="fa-solid fa-trash-arrow-up"></i></a>
                                        <a href="{{ route('admin.product.permantly_del', $product->id) }}"
                                            onclick="return confirm('Bạn có chắc muốn xóa vĩnh viển bản ghi này?')"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Xóa vĩnh viễn"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                @else
                                    <td>
                                        <a href="{{ route('admin.product.update', $product->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Chỉnh sửa"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.product.delete', $product->id) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Xóa"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->withQueryString()->links() }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
