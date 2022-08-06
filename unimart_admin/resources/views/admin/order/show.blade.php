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
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-inline">
                    <form action="{{ request()->r }}" method="POST">
                        @csrf
                        <input type="" class="form-control" name="keyword" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="text-primary">Tất cả<span
                            class="text-muted">({{ $num_all }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'waiting']) }}" class="text-primary">Chờ xác
                        nhận<span class="text-muted">({{ $num_waiting }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}" class="text-primary">Đã xác
                        nhận<span class="text-muted">({{ $num_confirmed }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'canceled']) }}" class="text-primary">Đã hủy<span
                            class="text-muted">({{ $num_canceled }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'success']) }}" class="text-primary">Giao hàng
                        thành công<span class="text-muted">({{ $num_success }})</span></a>
                </div>
                <form action="{{ route('admin.order.action') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select name="opt" class="form-control mr-1" id="">
                            <option value="waiting">Chờ xác nhận</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="canceled">Đã hủy</option>
                            <option value="success">Giao hàng thành công</option>
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">Mã vận đơn</th>
                                <th scope="col">Khách hàng</th>
                                <th scope="col">Thông tin khách hàng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời điểm vận đơn</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->total() > 0)
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="order_ids[]" value="{{ $order->id }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.order.detail', $order->id) }}">{{ $order->id }}</a>
                                        </td>
                                        @if ($order->username != null)
                                            <td>{{ $order->username }}</td>
                                        @else
                                            <td>[Guest]</td>
                                        @endif
                                        <td>
                                            {{ $order->name }} <br>
                                            {{ $order->phone_number }}
                                        </td>
                                        <td>
                                            @if ($order->status == 'waiting')
                                                <span class="badge badge-warning">Chờ xác nhận</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge badge-danger">Đã hủy</span>
                                            @elseif($order->status == 'confirmed')
                                                <span class="badge badge-success">Đã xác nhận</span>
                                            @elseif($order->status == 'success')
                                                <span class="badge badge-primary">Giao hàng thành công</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            <input type="hidden" class="order-id" value="{{ $order->id }}">
                                            @if ($order->status == 'confirmed')
                                                <a href="#"
                                                    class="btn btn-primary btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="success" data-toggle="tooltip" data-placement="top"
                                                    title="Giao hàng thành công"><i class="fa-solid fa-check"></i></a>
                                                <a href="#"
                                                    class="btn btn-danger btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="canceled" data-toggle="tooltip" data-placement="top"
                                                    title="Hủy"><i class="fa-solid fa-xmark"></i></a>
                                            @elseif ($order->status == 'waiting')
                                                <a href="#"
                                                    class="btn btn-success btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="confirmed" data-toggle="tooltip" data-placement="top"
                                                    title="Xác nhận"><i class="fa-solid fa-check"></i></a>
                                                <a href="#"
                                                    class="btn btn-danger btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="canceled" data-toggle="tooltip" data-placement="top"
                                                    title="Hủy"><i class="fa-solid fa-xmark"></i></a>
                                            @elseif ($order->status == 'canceled')
                                                <a href="#"
                                                    class="btn btn-warning btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="waiting" data-toggle="tooltip" data-placement="top"
                                                    title="Chờ xác nhận"><i class="fa-regular fa-circle"></i></i></a>
                                                <a href="#"
                                                    class="btn btn-success btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="confirmed" data-toggle="tooltip" data-placement="top"
                                                    title="Xác nhận"><i class="fa-solid fa-check"></i></a>
                                            @elseif($order->status == 'success')
                                                <a href="#"
                                                    class="btn btn-warning btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="waiting" data-toggle="tooltip" data-placement="top"
                                                    title="Chờ xác nhận"><i class="fa-regular fa-circle"></i></i></a>
                                                <a href="#"
                                                    class="btn btn-success btn-sm rounded-0 text-white change-status-order"
                                                    type="button" data-url="{{ route('admin.order.changeStatus') }}"
                                                    data-status="confirmed" data-toggle="tooltip" data-placement="top"
                                                    title="Xác nhận"><i class="fa-solid fa-check"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class='bg-white' colspan="10">Không tìm thấy bản ghi trả về</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </form>
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
