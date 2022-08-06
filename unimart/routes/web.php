<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::middleware(['myverified'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    //PAGE 
    Route::get('/page/terms', 'PageController@term')->name('page.term');
    Route::get('/page/{slug}', 'PageController@detail')->name('page.detail');
    // POST
    Route::get('/post/', 'PostController@index')->name('post.index');
    Route::get('/post/{slug}', 'PostController@detail')->name('post.detail');
    Route::get('/post/byCat/{slug}', 'PostController@show_by_cat')->name('post.show_by_cat');
    Route::get('/post/byTag/{slug}', 'PostController@show_by_tag')->name('post.show_by_tag');
    // PRODUCT
    Route::get('/product/', 'ProductController@index')->name('product.index');
    Route::get('/product/{slug}', 'ProductController@detail')->name('product.detail');
    Route::match(['get', 'post'], '/product/byCat/{cat_id}-{slug}', 'ProductController@show_by_cat')->name('product.show_by_cat');
    Route::match(['get', 'post'], '/product/byTag/{slug}', 'ProductController@show_by_tag')->name('product.show_by_tag');
    Route::post('/product/byKeyWord', 'ProductController@show_by_keyword')->name('product.show_by_keyword');
    // CART
    Route::get('/cart', 'CartController@showCart')->name('cart');
    Route::post('/cart/add/', 'CartController@addCart')->name('cart.add');
    Route::get('/cart/buyNow/{product_id}', 'CartController@buyNow')->name('cart.buyNow');
    Route::post('/cart/update', 'CartController@updateCartItem')->name('cart.updateCartItem');
    Route::post('/cart/delete', 'CartController@deleteCartItem')->name('cart.deleteCartItem');
    Route::get('/cart/destroy', 'CartController@destroyCart')->name('cart.destroyCart');
    // ORDER
    Route::get('/order/checkOut', 'OrderController@checkOut')->name('order.checkOut');
    Route::post('/order/placeOrder', 'OrderController@placeOrder')->name('order.placeOrder');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // User
    Route::get('/user/edit', 'UserController@edit')->name('user.edit');
    Route::post('/user/store', 'UserController@store')->name('user.store');
    // Order
    Route::get('/order', 'OrderController@index')->name('order');
    Route::get('/order/detail/{order_id}', 'OrderController@detail')->name('order.detail');
    Route::post('/order/cancel', 'OrderController@cancelOrder')->name('order.cancel');
});
