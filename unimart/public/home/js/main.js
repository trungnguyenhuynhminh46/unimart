$(document).ready(function () {
//  SLIDER
    var slider = $('#slider-wp .section-detail');
    slider.owlCarousel({
        autoPlay: 4500,
        navigation: false,
        navigationText: false,
        paginationNumbers: false,
        pagination: true,
        items: 1, //10 items above 1000px browser width
        itemsDesktop: [1000, 1], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 1], // betweem 900px and 601px
        itemsTablet: [600, 1], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });

//  ZOOM PRODUCT DETAIL
    $("#zoom").elevateZoom({gallery: 'list-thumb', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'});

//  LIST THUMB
    var list_thumb = $('#list-thumb');
    list_thumb.owlCarousel({
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 5, //10 items above 1000px browser width
        itemsDesktop: [1000, 5], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 5], // betweem 900px and 601px
        itemsTablet: [768, 5], //2 items between 600 and 0
        itemsMobile: true // itemsMobile disabled - inherit from itemsTablet option
    });

//  FEATURE PRODUCT
    var feature_product = $('#feature-product-wp .list-item');
    feature_product.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [420, 1] // itemsMobile disabled - inherit from itemsTablet option
    });
//  SAME CATEGORY
    var same_category = $('#same-category-wp .list-item');
    same_category.owlCarousel({
        autoPlay: true,
        navigation: true,
        navigationText: false,
        paginationNumbers: false,
        pagination: false,
        stopOnHover: true,
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [800, 3], // betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0
        itemsMobile: [420, 1] // itemsMobile disabled - inherit from itemsTablet option
    });

//  SCROLL TOP
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#btn-top').stop().fadeIn(150);
        } else {
            $('#btn-top').stop().fadeOut(150);
        }
    });
    $('#btn-top').click(function () {
        $('body,html').stop().animate({scrollTop: 0}, 800);
    });
// CHOOSE NUMBER ORDER
    var value = parseInt($('#num-order').attr('value'));
    $('#plus').click(function () {
        value++;
        $('#num-order').attr('value', value);
        update_href(value);
    });
    $('#minus').click(function () {
        if (value > 1) {
            value--;
            $('#num-order').attr('value', value);
        }
        update_href(value);
    });

//  MAIN MENU
    $('#category-product-wp .list-item > li').find('.sub-menu').after('<i class="fa fa-angle-right arrow" aria-hidden="true"></i>');

//  TAB
    tab();
    //  EVEN MENU RESPON
    $('html').on('click', function (event) {
        var target = $(event.target);
        var site = $('#site');

        if (target.is('#btn-respon i')) {
            if (!site.hasClass('show-respon-menu')) {
                site.addClass('show-respon-menu');
            } else {
                site.removeClass('show-respon-menu');
            }
        } else {
            $('#container').click(function () {
                if (site.hasClass('show-respon-menu')) {
                    site.removeClass('show-respon-menu');
                    return false;
                }
            });
        }
    });

//  MENU RESPON
    $('#main-menu-respon li .sub-menu').after('<span class="fa fa-angle-right arrow"></span>');
    $('#main-menu-respon li .arrow').click(function () {
        if ($(this).parent('li').hasClass('open')) {
            $(this).parent('li').removeClass('open');
        } else {

//            $('.sub-menu').slideUp();
//            $('#main-menu-respon li').removeClass('open');
            $(this).parent('li').addClass('open');
//            $(this).parent('li').find('.sub-menu').slideDown();
        }
    });
    // Read more button
    height = $('#check-height').outerHeight();
    if(height>=1500){
        $('.section-detail .btn').css('display','block');
        $('#check-height').toggleClass('content');
    }
    $('.readmore').on('click', function(){
        $(this).parent().toggleClass('show-content');
        $(this).toggleClass('readmore-btn');
        $(this).toggleClass('readless-btn');
        var replace_text = $(this).parent().hasClass('show-content')?"Hiển thị bớt":"Xem thêm";
        $(this).text(replace_text);
    });
    // Click ảnh user
    $('#head-top #main-menu #user').on("click", function(){
        $(this).children('ul').toggleClass('d-block');
    });
    // ================CART======================
    $('.add-cart').on('click', addToCart);
    $('.btn-decrease').on('click', function(event) {
        event.preventDefault();
        let qty = parseInt($(this).parent('.input-group').find('.product-quantity').val(), 10);
        qty = isNaN(qty) ? 0 : qty;
        if (qty > 1) {
            qty--;
        }
        $(this).parent('.input-group').find('.product-quantity').val(qty);
    });
    $('.btn-increase').on('click', function(event) {
        event.preventDefault();
        let qty = parseInt($(this).parent('.input-group').find('.product-quantity').val(), 10);
        qty = isNaN(qty) ? 0 : qty;
        if (qty < 1000) {
            qty++;
        }
        $(this).parent('.input-group').find('.product-quantity').val(qty);
    });
    $('.change-quantity').on('click', function(event) {
        event.preventDefault();
        let qty = parseInt($(this).parent('.input-group').find('.product-quantity').val(), 10);
        qty = isNaN(qty) ? 0 : qty;
        let rowId = $(this).closest('tr').find('.rowId').val();
        let urlUpdateCart = $(this).closest('tr').find('.updateCart').data('url')
        let data = {
            'rowId': rowId,
            'qty': qty
        };
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: urlUpdateCart,
            dataType: "json",
            data: data,
            success: function(data) {
                window.location.reload();
            },
            error: function(data) {
                alert('error');
            }
        });
    });
    $('.delete-cart-item').on('click', function(event){
        event.preventDefault();
        let rowId = $(this).closest('tr').find('.rowId').val();
        let urlDeleteCartItem = $(this).data('url');
        let data = {'rowId':rowId};
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method: "POST",
            url: urlDeleteCartItem,
            dataType: "json",
            data: data,
            success: function(data){
                window.location.reload();
            },
            error: function(data){

            }
        })
    });
    $('#delete-cart').on('click', function(event){
        event.preventDefault();
        if(confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')==true){
            let urlDestroyCart = $(this).data('url');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "GET",
                url: urlDestroyCart,
                dataType: "json",
                success: function(data){
                    window.location.reload();
                    alert(data['alert']);
                },
                error: function(data){

                }
            });
        }
    });
    $('.detail-add-cart').on('click', function(event){
        event.preventDefault();
        let product_id = $(this).closest('.form-add-cart').find('.product-id').val();
        let qty = $(this).closest('.form-add-cart').find('#num-order-wp').find('.qty').val();
        let urlAddCart = $(this).data('url');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: urlAddCart,
            dataType: 'json',
            data: {
                'product_id':product_id,
                'qty':qty
            },
            success: function(data){
                alert(data['alert']);
                window.location.reload();
            },
            error: function(data){
    
            }
        });
    })
    // ================ORDER======================
    $('.cancel-order').on('click', function(event){
        event.preventDefault();
        let order_id = $(this).closest('tr').find('.order_id').val();
        let url_cancel_order = $(this).data('url');
        if(confirm('Bạn có chắc muốn hủy đơn hàng '+order_id+' không')==true){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url: url_cancel_order,
                data: {"order_id":order_id},
                dataType: "json",
                success: function(data){
                    alert(data['alert']);
                    window.location.reload();
                },
                error: function(){
    
                }
            });
        }
    })
    // ================SEARCH-AJAX======================
    $('.search-box').on('keyup',function(event){
        let product_detail_url = $(this).data('product');
        let base_url = $(this).data('base');
        let url = $(this).data('url');
        let keyword = $(this).closest('#search-wp').find('#s').val();
        url = url + '/' +keyword;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data){
                console.log(data);
                var _html = "";
                for(var product of data){
                    _html+= '<div class="media p-2">';
                    _html+= ' <a href="'+product_detail_url+'/'+product.slug+'" class="d-clock thumbnail">';
                    _html+= '        <img class="mr-4"';
                    _html+= '             src="'+product.thumbnail+'"';
                    _html+= '            alt="Generic placeholder image">';
                    _html+= '    </a>';
                    _html+= '    <div class="media-body">';
                    _html+= '        <a href="'+product_detail_url+'/'+product.slug+'" class="product-name mt-0">'+product.name+'</a>';
                    _html+= '        <div class="price">';
                    _html+= '            <span class="new-price">'+product.price+'đ</span>';
                    _html+= '            <del class="old-price">'+product.old_price+'đ</del>';
                    _html+= '        </div>';
                    _html+= '    </div>';
                    _html+= '</div>';
                }
                $('.search-result').html(_html);
            }
        })
    })
    $('.search-box').on('focusout',function(event){
        if (!$('.search-result').is(':hover')) {
            $('.search-result').html('');
        }
    })
});

function tab() {
    var tab_menu = $('#tab-menu li');
    tab_menu.stop().click(function () {
        $('#tab-menu li').removeClass('show');
        $(this).addClass('show');
        var id = $(this).find('a').attr('href');
        $('.tabItem').hide();
        $(id).show();
        return false;
    });
    $('#tab-menu li:first-child').addClass('show');
    $('.tabItem:first-child').show();
}

function addToCart(event) {
    event.preventDefault();
    let urlAddCart = $(this).data('url');
    let product_id = $(this).parents('li').find('.product_id').val();
    let qty = $(this).parents('li').find('.qty').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: urlAddCart,
        dataType: 'json',
        data: {
            'product_id':product_id,
            'qty':qty
        },
        success: function(data){
            alert(data['alert']);
            window.location.reload();
        },
        error: function(data){

        }
    });
}