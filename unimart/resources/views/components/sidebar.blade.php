<div class="sidebar fl-left">
    {{-- Danh mục sản phẩm --}}
    <div class="section" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục sản phẩm</h3>
        </div>
        <div class="secion-detail">
            <ul class="list-item">
                @foreach ($product_categories as $product_category)
                    @if ($product_category->parent_id == null)
                        <li>
                            <a href="{{ route('product.show_by_cat', [$product_category->id, $product_category->slug]) }}"
                                title="">{{ $product_category->name }}</a>
                            @if ($product_category->childCats->count() > 0)
                                <ul class="sub-menu">
                                    @foreach ($product_category->childCats as $productChildCat)
                                        <li>
                                            <a href="{{ route('product.show_by_cat', [$productChildCat->id, $productChildCat->slug]) }}"
                                                title="">{{ $productChildCat->name }}</a>
                                            @if ($productChildCat->childCats->count() > 0)
                                                <ul class="sub-menu">
                                                    @foreach ($productChildCat->childCats as $productChildChildCat)
                                                        <a href="{{ route('product.show_by_cat', [$productChildChildCat->id, $productChildChildCat->slug]) }}"
                                                            title="">{{ $productChildChildCat->name }}</a>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    {{-- Danh mục bài viết --}}
    <div class="section mt-25" id="category-product-wp">
        <div class="section-head">
            <h3 class="section-title">Danh mục bài viết</h3>
        </div>
        <div class="secion-detail">
            <ul class="list-item">
                @foreach ($post_categories as $post_category)
                    <li>
                        <a href="{{ route('post.show_by_cat', $post_category->slug) }}">{{ $post_category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    {{-- Sản phẩm xem nhiều --}}
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm xem nhiều</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                @foreach ($most_interested_products as $product)
                    <li class="clearfix">
                        <a href="{{ route('product.detail', $product->slug) }}" title="" class="thumb fl-left">
                            <img src="{{ url($product->thumbnail) }}" alt="">
                        </a>
                        <div class="info fl-right">
                            <a href="{{ route('product.detail', $product->slug) }}" title=""
                                class="product-name">{{ $product->name }}</a>
                            <div class="price">
                                <span class="new">{{ number_format($product->price) }}đ</span>
                                <span class="old">{{ number_format($product->old_price) }}đ</span>
                            </div>
                            <a href="{{ route('cart.buyNow', $product->id) }}" title="" class="buy-now">Mua
                                ngay</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="" title="" class="thumb">
                <img src="public/images/banner.png" alt="">
            </a>
        </div>
    </div>
</div>
