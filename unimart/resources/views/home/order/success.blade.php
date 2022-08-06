@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('inner')
    <div id="wrapper" class="wp-inner clearfix">
        <img src="{{ asset('images/circle-check.png') }}" alt="" class="mx-auto" style="width: 150px;">
        <h1 class="success">
            Đơn hàng {{ $order_id }} của bạn đã được xử lý thành công
        </h1>
        <div class="more-info">
            Để kiểm tra tình trạng đơn hàng của mình bạn có thể vào phần quản lý hóa đơn hoặc nhấn <a
                href="{{ route('order') }}">vào
                đây</a>
        </div>
        <div class="more-info">
            <a href="{{ route('home') }}">Tiếp tục mua sắm</a>
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
