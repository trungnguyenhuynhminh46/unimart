<div id="header-wp">
    <div id="head-top" class="clearfix">
        <div class="wp-inner">
            <a href="{{ route('page.term') }}" title="" id="payment-link" class="fl-left">Điều khoản dịch vụ</a>
            <div id="main-menu-wp" class="fl-right">
                <ul id="main-menu" class="clearfix">
                    <li>
                        <a href="{{ route('home') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('product.index') }}" title="">Sản phẩm</a>
                    </li>
                    <li>
                        <a href="{{ route('post.index') }}" title="">Blog</a>
                    </li>
                    {{-- Tên các trang --}}
                    @foreach ($pages as $page)
                        <li>
                            <a href="{{ route('page.detail', $page->slug) }}">{{ $page->title }}</a>
                        </li>
                    @endforeach
                    @if (!Auth::check())
                        <li id='login'>
                            <a href="{{ route('login') }}" title="" id="login">Đăng nhập</a>
                        </li>
                        <li id='logout'>
                            <a href="{{ route('register') }}" title="" id="register">Đăng ký</a>
                        </li>
                    @else
                        <li id="user">
                            <a href="" onclick="return false;"> <img src="{{ asset('images/user.png') }}"
                                    alt=""></a>
                            <ul>
                                <li>
                                    <a href="{{ route('user.edit') }}">Cập nhật thông tin cá nhân</a>
                                </li>
                                <li>
                                    <a href="{{ route('order') }}">Quản lý hóa đơn</a>
                                </li>
                                <li>
                                    <a id="logout" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Đăng xuất
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div id="head-body" class="clearfix">
        <div class="wp-inner">
            <a href="{{ route('home') }}" title="" id="logo" class="fl-left"><img
                    src="{{ asset('images/logo.png') }}" /></a>
            <div id="search-wp" class="fl-left">
                <form method="POST" action="{{ route('product.show_by_keyword') }}">
                    @csrf
                    <input type="text" class="search-box" name="keyword" id="s"
                        placeholder="Nhập từ khóa tìm kiếm sản phẩm tại đây!"
                        data-url="{{ route('ajax-search-products', '') }}" data-base="{{ url('') }}"
                        data-product="{{ route('product.detail', '') }}">
                    <button type="submit" id="sm-s">Tìm kiếm</button>
                </form>
                <div class="search-result">
                </div>
            </div>
            <div id="action-wp" class="fl-right">
                <div id="advisory-wp" class="fl-left">
                    <span class="title">Tư vấn</span>
                    <span class="phone">0987.654.321</span>
                </div>
                {{-- Phẩn Responsive --}}
                <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                <a href="{{ route('cart') }}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span id="num">{{ Cart::count() }}</span>
                </a>
                {{-- End Phần responsive --}}
                <div id="cart-wp" class="fl-right">
                    <a href="{{ route('cart') }}" id="btn-cart">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span id="num">{{ Cart::count() }}</span>
                    </a>
                    <div id="dropdown">
                        @if (Cart::count() > 0)
                            <p class="desc">Có <span>{{ Cart::count() }} sản phẩm</span> trong giỏ hàng</p>
                        @else
                            <p class="desc">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                        @endif
                        <ul class="list-cart">
                            @foreach (Cart::content() as $row)
                                @php
                                    $product = App\Product::find($row->id);
                                @endphp
                                <li class="clearfix">
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="thumb fl-left">
                                        <img src="{{ url($product->thumbnail) }}" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="{{ route('product.detail', $product->slug) }}" title=""
                                            class="product-name">{{ $product->name }}</a>
                                        <p class="price">{{ number_format($product->price) }}đ</p>
                                        <p class="qty">Số lượng: <span>{{ $row->qty }}</span></p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="total-price clearfix">
                            <p class="title fl-left">Tổng:</p>
                            <p class="price fl-right">{{ Cart::total() }}đ</p>
                        </div>
                        <div class="action-cart clearfix">
                            <a href="{{ route('cart') }}" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                            <a href="{{ route('order.checkOut') }}" title="Thanh toán"
                                class="checkout fl-right">Thanh
                                toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
