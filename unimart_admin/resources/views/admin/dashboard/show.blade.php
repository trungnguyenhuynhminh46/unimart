@extends('layouts.admin')
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($num_success) }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">CHỜ XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($num_waiting) }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $turnover }}</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($num_canceled) }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
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
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection
