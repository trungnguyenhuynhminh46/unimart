@php
$pages = App\Page::get();
$product_categories = App\ProductCat::get();
$post_categories = App\PostCat::get();
$most_interested_products = App\Product::orderBy('num_views', 'DESC')
    ->limit(10)
    ->get();
$most_bought_products = App\Product::orderBy('num_purchases', 'DESC')
    ->limit(10)
    ->get();
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link href="{{ asset('css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{ asset('reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
        integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
</head>

<body>
    <div id="site">
        <div id="container">
            @include('components.header')
            <div id="main-content-wp" class="home-page clearfix">
                @section('inner')
                    <div class="wp-inner">
                        @yield('breadcrumb')
                        @yield('content')
                        @include('components.sidebar')
                    </div>
                @show
            </div>
            @include('components.footer')
        </div>
        @include('components.menu-respon')
        <div id="btn-top"><img src="{{ asset('images/icon-to-top.png') }}" alt="" /></div>
        <div id="fb-root"></div>
        {{-- <script src="{{ asset('js/jquery-2.2.4.min.js') }}" type="text/javascript"></script> --}}
        <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script src="{{ asset('js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
        @yield('js')
</body>

</html>
