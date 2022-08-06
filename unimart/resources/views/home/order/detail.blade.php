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
                        <a href="{{ route('order') }}">Danh sách đơn hàng</a>
                    </li>
                    <li>
                        <a href="#" title="" class="active">Chi tiết đơn hàng {{ $order->id }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <h1 class="title">Chi tiết hóa đơn {{ $order->id }}</h1>
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td>Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $orderItem)
                            <tr>
                                <td>
                                    <a href="{{ route('product.detail', $orderItem->product->slug) }}" title=""
                                        class="name-product rm-link-style">{{ $orderItem->product->name }}</a>
                                </td>
                                <td>{{ number_format($orderItem->product->price) }}đ</td>
                                <td>{{ $orderItem->qty }}</td>
                                <td>{{ number_format($orderItem->product->price * $orderItem->qty) }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng tiền:
                                        <span>{{ number_format($order->total) }}đ</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
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
