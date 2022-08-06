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
                    <a href="{{ route('product.index') }}" title="">Sản phẩm</a>
                </li>
                <li>
                    <a href="#" class="active">Tag: {{ $tag }}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="list-product-wp">
            <div class="section-head clearfix">
                <h3 class="section-title fl-left">Các sản phẩm có tag: {{ $tag }}</h3>
                <div class="filter-wp fl-right">
                    <p class="desc">Hiển thị {{ $products->count() }} trên {{ $products->total() }} sản phẩm</p>
                    <div class="form-filter">
                        <form method="POST" action="{{ \URL::full() }}">
                            @csrf
                            <select name="select">
                                <option value="0" {{ $select == 0 ? 'selected' : '' }}>Sắp xếp</option>
                                <option value="1" {{ $select == 1 ? 'selected' : '' }}>Từ A-Z</option>
                                <option value="2" {{ $select == 2 ? 'selected' : '' }}>Từ Z-A</option>
                                <option value="3" {{ $select == 3 ? 'selected' : '' }}>Giá cao xuống thấp</option>
                                <option value="4" {{ $select == 4 ? 'selected' : '' }}>Giá thấp lên cao</option>
                                <option value="5" {{ $select == 5 ? 'selected' : '' }}>Mới nhất</option>
                            </select>
                            <button type="submit">Lọc</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="section-detail">
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
            <div class="section" id="paging-wp">
                {{ $products->withQueryString()->links() }}
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
