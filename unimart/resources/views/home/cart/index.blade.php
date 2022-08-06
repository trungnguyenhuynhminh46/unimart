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
                        <a href="#" title="" class="active">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Tên sản phẩm</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td colspan="2">Thành tiền</td>
                            <td>Tác vụ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (Cart::count() > 0)
                            @foreach (Cart::content() as $row)
                                @php
                                    $product = App\Product::find($row->id);
                                @endphp
                                <tr>
                                    <input type="hidden" class="updateCart" data-url="{{ route('cart.updateCartItem') }}">
                                    <input type="hidden" class="rowId" value="{{ $row->rowId }}">
                                    <td>
                                        <a href="{{ route('product.detail', $product->slug) }}" title=""
                                            class="name-product rm-link-style">{{ $product->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('product.detail', $product->slug) }}" title=""
                                            class="thumb">
                                            <img src="{{ url($product->thumbnail) }}" alt="">
                                        </a>
                                    </td>
                                    <td>{{ number_format($product->price) }}đ</td>
                                    <td>
                                        <div class="input-group justify-content-center">
                                            <span
                                                class="input-group-text btn-decrease change-quantity disable-select">-</span>
                                            <input type="text" class="bg-white text-center product-quantity"
                                                value={{ $row->qty }}>
                                            <span
                                                class="input-group-text btn-increase change-quantity disable-select">+</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($product->price * $row->qty) }}đ</td>
                                    <td>
                                        <a href="" title="" class="del-product"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                    <td>
                                        <a href="#" data-url="{{ route('cart.deleteCartItem') }}"
                                            class="delete-cart-item rm-link-style text-danger"><i
                                                class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Bạn chưa có sản phẩm nào trong giỏ hàng</td>
                            </tr>
                        @endif

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá: <span>{{ Cart::subtotal() }}đ</span></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        <a href="#" data-url="{{ route('cart.destroyCart') }}" title=""
                                            id="delete-cart">Xóa giỏ
                                            hàng</a>
                                        <a href="{{ route('order.checkOut') }}" title="" id="checkout-cart">Tiến hành
                                            thanh toán</a>
                                    </div>
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
