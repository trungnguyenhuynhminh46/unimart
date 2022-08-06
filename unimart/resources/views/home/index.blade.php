@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="slider-wp">
            <div class="section-detail">
                <div class="item">
                    <img src="{{ asset('images/slider-01.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('images/slider-02.png') }}" alt="">
                </div>
                <div class="item">
                    <img src="{{ asset('images/slider-03.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="section" id="support-wp">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <div class="thumb">
                            <img src="public/images/icon-1.png">
                        </div>
                        <h3 class="title">Miễn phí vận chuyển</h3>
                        <p class="desc">Tới tận tay khách hàng</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/images/icon-2.png">
                        </div>
                        <h3 class="title">Tư vấn 24/7</h3>
                        <p class="desc">1900.9999</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/images/icon-3.png">
                        </div>
                        <h3 class="title">Tiết kiệm hơn</h3>
                        <p class="desc">Với nhiều ưu đãi cực lớn</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/images/icon-4.png">
                        </div>
                        <h3 class="title">Thanh toán nhanh</h3>
                        <p class="desc">Hỗ trợ nhiều hình thức</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/images/icon-5.png">
                        </div>
                        <h3 class="title">Đặt hàng online</h3>
                        <p class="desc">Thao tác đơn giản</p>
                    </li>
                </ul>
            </div>
        </div>
        {{-- list-product-wp : Không phải slider --}}
        {{-- Danh sách sản phẩm bán chạy --}}
        <div class="section" id="feature-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm bán chạy</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @php
                        $most_bought_products = App\Product::orderBy('num_purchases', 'DESC')
                            ->limit(10)
                            ->get();
                    @endphp
                    @foreach ($most_bought_products as $product)
                        <li>
                            <a href="{{ route('product.detail', $product->slug) }}" title="" class="thumb">
                                <img src="{{ url($product->thumbnail) }}">
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
        </div>
        {{-- Danh sách các sản phẩm còn lại --}}
        @foreach ($product_root_ids as $category_id => $list_product_ids)
            @php
                $category = App\ProductCat::find($category_id);
                $products = App\Product::find($list_product_ids);
            @endphp
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">{{ $category->name }}</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($products as $product)
                            <li>
                                <a href="{{ route('product.detail', $product->slug) }}" title="" class="thumb">
                                    <img src="{{ url($product->thumbnail) }}">
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
                                        class="add-cart fl-left">Thêm giỏ
                                        hàng</a>
                                    <a href="{{ route('cart.buyNow', $product->id) }}" title=""
                                        class="buy-now fl-right">Mua
                                        ngay</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('js')
    <script src="{{ asset('home/js/main.js') }}" type="text/javascript"></script>
    <script></script>
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
