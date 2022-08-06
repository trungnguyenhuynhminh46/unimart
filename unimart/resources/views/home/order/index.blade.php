@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('inner')
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{ route('home') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="#" title="" class="active">Danh sách đơn hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <h1 class="title">Danh sách các hóa đơn</h1>
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Mã vận đơn</td>
                            <td>Ngày vận đơn</td>
                            <td>Thành tiền</td>
                            <td>Tình trạng</td>
                            <td>Tác vụ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->total() > 0)
                            @foreach ($orders as $order)
                                <tr>
                                    <input type="hidden" class="order_id" value="{{ $order->id }}">
                                    <td><a href="{{ route('order.detail', $order->id) }}"
                                            class="rm-link-style">{{ $order->id }}</a></td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ number_format($order->total) }}đ</td>
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
                                    @if ($order->status == 'waiting')
                                        <td><a href="#" data-url="{{ route('order.cancel') }}"
                                                class="rm-link-style cancel-order text-danger" title="Hủy đơn hàng"><i
                                                    class="fa-solid fa-ban"></i></a></td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Chưa có đơn hàng nào được thiết lập</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="fl-right mt-2">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('home/js/main.js') }}" type="text/javascript"></script>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@endsection
