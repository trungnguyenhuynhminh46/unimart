@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('breadcrumb')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{ route('home') }}" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="#" title="" class="active">Sản phẩm</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="list-product-wp">
            @foreach ($product_root_ids as $root_id => $product_ids)
                @php
                    $category = App\ProductCat::find($root_id);
                    $products = App\Product::find($product_ids);
                @endphp
                <div class="section-detail">
                    <a href="{{ route('product.show_by_cat', [$category->id, $category->slug]) }}"
                        class="section-title fl-left">
                        {{ $category->name }}
                    </a>
                    <ul class="list-item clearfix">
                        @foreach ($products as $product)
                            <li>
                                <a href="{{ route('product.detail', $product->slug) }}" title="" class="thumb">
                                    <img src="{{ $product->thumbnail }}">
                                </a>
                                <a href="{{ route('product.detail', $product->slug) }}" title=""
                                    class="product-name">{{ $product->name }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($product->price) }}đ</span>
                                    <span class="old">{{ number_format($product->old_price) }}đ</span>
                                </div>
                                <div class="action clearfix">
                                    <input type="hidden" class="product_id" value="{{ $product->id }}">
                                    <input type="hidden" class="qty" value="1">
                                    <a href="#" data-url="{{ route('cart.add') }}" title=""
                                        class="add-cart fl-left">Thêm
                                        giỏ
                                        hàng</a>
                                    <a href="{{ route('cart.buyNow', $product->id) }}" title=""
                                        class="buy-now fl-right">Mua
                                        ngay</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
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
