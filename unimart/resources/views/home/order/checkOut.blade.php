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
                        <a href="#" title="" class="active">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form action="{{ route('order.placeOrder') }}" method="post">
        @csrf
        @if (Auth::check())
            <input type="hidden" name="username" value="{{ Auth::user()->username }}">
        @endif
        <div id="wrapper" class="wp-inner clearfix">
            @if (Cart::count() > 0)
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    @if (Auth::check())
                        @php
                            $user = Auth::user();
                        @endphp
                        <div class="section-detail">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="fullname">Họ tên</label>
                                    <input type="text" name="name" id="fullname" value="{{ $user->name }}"
                                        readonly>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" value="{{ $user->email }}"
                                        readonly>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="address">Địa chỉ</label>
                                    <input type="text" name="address" id="address" value="{{ $user->address }}">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" name="phone_number" id="phone"
                                        value="{{ $user->phone_number }}">
                                    @error('phone_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col">
                                    <label for="notes">Ghi chú</label>
                                    <textarea name="note"></textarea>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="section-detail">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="fullname">Họ tên</label>
                                    <input type="text" name="name" id="fullname">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="address">Địa chỉ</label>
                                    <input type="text" name="address" id="address">
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" name="phone_number" id="phone">
                                    @error('phone_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col">
                                    <label for="notes">Ghi chú</label>
                                    <textarea name="note"></textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="section" id="order-review-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin đơn hàng</h1>
                    </div>
                    <div class="section-detail">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $row)
                                    @php
                                        $product = App\Product::find($row->id);
                                    @endphp
                                    <tr class="cart-item">
                                        <td class="product-name">{{ $product->name }}<strong class="product-quantity">x
                                                {{ $row->qty }}</strong>
                                        </td>
                                        <td class="product-total">{{ number_format($product->price * $row->qty) }}đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td><strong class="total-price">{{ Cart::total() }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" id="payment-home" name="payment" value="cod" checked>
                                    <label for="payment-home">Thanh toán tại nhà</label>
                                </li>
                                <li>
                                    <input type="radio" id="direct-payment" name="payment" value="direct">
                                    <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                </li>
                            </ul>
                        </div>
                        <div class="place-order-wp clearfix">
                            <input type="submit" name="btn-submit" id="order-now" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            @else
                <div class="section" id="no-product" style="min-height: 300px;">Bạn chưa có sản phẩm nào trong giỏ hàng
                </div>
            @endif
        </div>
    </form>
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
