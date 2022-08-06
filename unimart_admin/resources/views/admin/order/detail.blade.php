@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card mb-4">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Họ và tên</th>
                            <th scope="col" class="text-center">Địa chỉ email</th>
                            <th scope="col" class="text-center">Địa chỉ nhận hàng</th>
                            <th scope="col" class="text-center">Số điện thoại</th>
                            <th scope="col" class="text-center">Chú thích</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">{{ $order->name }}</td>
                            <td class="text-center">{{ $order->email }}</td>
                            <td class="text-center">{{ $order->address }}</td>
                            <td class="text-center">{{ $order->phone_number }}</td>
                            <td class="text-center">
                                @if (!empty($order->note))
                                    {{ $order->note }}
                                @else
                                    Không có
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Chi tiết đơn hàng {{ $order->id }}
                    @if ($order->status == 'waiting')
                        <span class="badge badge-warning">Chờ xác nhận</span>
                    @elseif($order->status == 'canceled')
                        <span class="badge badge-danger">Đã hủy</span>
                    @elseif($order->status == 'confirmed')
                        <span class="badge badge-success">Đã xác nhận</span>
                    @elseif($order->status == 'success')
                        <span class="badge badge-primary">Giao hàng thành công</span>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Mã hàng</th>
                            <th scope="col" class="text-center">Tên hàng</th>
                            <th scope="col" class="text-center">Số lượng</th>
                            <th scope="col" class="text-center">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td class="text-center">{{ $item->product->id }}</td>
                                <td class="text-center">{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-center">{{ $item->qty * $item->product->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="p-0">
                                <div class="clear-fix">
                                    <p class='total-bill'>Tổng tiền: {{ number_format($order->total) }}đ</p>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
