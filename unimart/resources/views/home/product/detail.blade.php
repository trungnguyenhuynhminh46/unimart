@extends('layouts.master')
@section('css')
    <link href="{{ asset('home/css/jquery.exzoom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@endsection
@php
$cat_ids = [];
$tmp = $product->category;
$cat_ids[] = $tmp->id;
while ($tmp->parent_id != null) {
    $tmp = $tmp->parentCat;
    $cat_ids[] = $tmp->id;
}
$cat_ids = array_reverse($cat_ids);
@endphp
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
                @foreach ($cat_ids as $cat_id)
                    @php
                        $cat = App\ProductCat::find($cat_id);
                    @endphp
                    <li>
                        <a href="{{ route('product.show_by_cat', [$cat->id, $cat->slug]) }}"
                            title="">{{ $cat->name }}</a>
                    </li>
                @endforeach
                <li>
                    <a href="#" title="" class="active">{{ $product->name }}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')
    <div class="main-content fl-right">
        <div class="section" id="detail-product-wp">
            <div class="section-detail clearfix">
                <div class="thumb-wp fl-left">
                    <div class="exzoom" id="exzoom">
                        <!-- Images -->
                        <div class="exzoom_img_box">
                            <ul class='exzoom_img_ul'>
                                @for ($i = 0; $i < 5; $i++)
                                    <li><img src="{{ $product->thumbnail }}" /></li>
                                @endfor
                            </ul>
                        </div>
                        <!-- <a href="https://www.jqueryscript.net/tags.php?/Thumbnail/">Thumbnail</a> Nav-->
                        <div class="exzoom_nav"></div>
                        <!-- Nav Buttons -->
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn">
                                < </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                        </p>
                    </div>
                    <script src="jquery.exzoom.js"></script>
                    <script src="main.js"></script>
                </div>
                <div class="thumb-respon-wp fl-left">
                    <img src="{{ $product->thumbnail }}" alt="">
                </div>
                <div class="info fl-right">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="desc">
                        @php
                            $rows = explode("\n", $product->description);
                        @endphp
                        @foreach ($rows as $row)
                            <p>{{ $row }}</p>
                        @endforeach
                    </div>
                    <div class="num-product">
                        <span class="title">Tình trạng: </span>
                        @php
                            $available = $product->qty > 0;
                        @endphp
                        @if ($available)
                            <span class="status bg-success">Còn hàng</span>
                        @else
                            <span class="status">Hết hàng</span>
                        @endif
                    </div>
                    <div class="tags">
                        <span>Tags: </span>
                        <i class="fa-solid fa-tags"></i>
                        @php
                            $tags = explode(',', $product->tags);
                        @endphp
                        @foreach ($tags as $tag)
                            <a href="{{ route('product.show_by_tag', Str::slug($tag, '-')) }}"
                                class="tag">{{ $tag }}</a>
                        @endforeach
                    </div>
                    <p class="price">{{ number_format($product->price) }}đ</p>
                    <form action="#" method="post" class="form-add-cart">
                        @csrf
                        <input type="hidden" class="product-id" value="{{ $product->id }}">
                        <div id="num-order-wp" class="noselect">
                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                            <input type="text" name="qty" class="qty" value="1" id="num-order">
                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                        </div>
                        <a href="#" data-url="{{ route('cart.add') }}" title="Thêm giỏ hàng"
                            class="detail-add-cart">Thêm giỏ hàng</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="section" id="post-product-wp">
            <div class="section-head">
                <h3 class="section-title">Mô tả sản phẩm</h3>
            </div>
            <div class="section-detail" id="check-height">
                {!! $product->content !!}
                <a href="javascript:void();" class="btn readmore-btn readmore">Xem thêm</a>
            </div>
        </div>
        <div class="section" id="same-category-wp">
            <div class="section-head">
                <h3 class="section-title">Có thể bạn quan tâm</h3>
            </div>
            <div class="section-detail">
                @if ($same_category_products != null)
                    <ul class="list-item">
                        @foreach ($same_category_products as $same_category_product)
                            <li>
                                <a href="{{ route('product.detail', $same_category_product->slug) }}" title=""
                                    class="thumb">
                                    <img src="{{ url($same_category_product->thumbnail) }}">
                                </a>
                                <a href="{{ route('product.detail', $same_category_product->slug) }}" title=""
                                    class="product-name">{{ $same_category_product->name }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($same_category_product->price) }}đ</span>
                                    <span class="old">{{ number_format($same_category_product->old_price) }}đ</span>
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
                @else
                    <p>Không có sản phẩm nào thuộc cùng danh mục {{ $product->category->name }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('home/js/jquery.exzoom.js') }}"></script>
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
        $("#exzoom").exzoom({

            // thumbnail nav options
            "navWidth": 60,
            "navHeight": 60,
            "navItemNum": 5,
            "navItemMargin": 7,
            "navBorder": 1,

            // autoplay
            "autoPlay": false,

            // autoplay interval in milliseconds
            "autoPlayTimeout": 2000

        });
    </script>
@endsection
