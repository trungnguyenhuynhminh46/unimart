<div id="menu-respon">
    <a href="?page=home" title="" class="logo">UNIMART</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
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
        </ul>
    </div>
</div>
