<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route::get('/admin', function () {
//     return redirect()->route('dashboard');
// });

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

// Users
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout');
    // Module Dashboard
    Route::get('/dashboard', 'AdminDashboardController@show')->name('dashboard');
    // Module Page
    Route::match(['POST', 'GET'], '/page/list', 'PageController@list')->name('admin.page.list');
    Route::get('/page/add', 'PageController@add')->name('admin.page.add');
    Route::get('/page/delete/{id}', 'PageController@delete')->name('admin.page.delete');
    Route::get('/page/update/{id}', 'PageController@update')->name('admin.page.update');
    Route::post('/page/store', 'PageController@store')->name('admin.page.store');
    Route::post('/page/action', 'PageController@action')->name('admin.page.action');
    Route::get('/page/restore/{id}', 'PageController@restore')->name('admin.page.restore');
    Route::get('/page/permantly_del/{id}', 'PageController@permantly_del')->name('admin.page.permantly_del');
    // Module Post
    Route::get('/post/category/list', 'PostController@listCat')->name('admin.post.category.list');
    Route::post('/post/category/add', 'PostController@addCat')->name('admin.post.category.add');
    Route::get('/post/category/update/{id}', 'PostController@updateCat')->name('admin.post.category.update');
    Route::post('/post/category/store', 'PostController@storeCat')->name('admin.post.category.store');
    Route::get('/post/category/delete/{id}', 'PostController@deleteCat')->name('admin.post.category.delete');
    Route::match(['POST', 'GET'], '/post/list', 'PostController@list')->name('admin.post.list');
    Route::get('/post/add', 'PostController@add')->name('admin.post.add');
    Route::get('/post/update/{id}', 'PostController@update')->name('admin.post.update');
    Route::post('/post/store', 'PostController@store')->name('admin.post.store');
    Route::get('/post/delete/{id}', 'PostController@delete')->name('admin.post.delete');
    Route::post('/post/action', 'PostController@action')->name('admin.post.action');
    Route::get('/post/restore/{id}', 'PostController@restore')->name('admin.post.restore');
    Route::get('/post/permantly_del/{id}', 'PostController@permantly_del')->name('admin.post.permantly_del');
    // Module Product
    Route::get('/product/category/list', 'ProductController@listCat')->name('admin.product.category.list');
    Route::post('/product/category/add', 'ProductController@addCat')->name('admin.product.category.add');
    Route::get('/product/category/update/{id}', 'ProductController@updateCat')->name('admin.product.category.update');
    Route::post('/product/category/store', 'ProductController@storeCat')->name('admin.product.category.store');
    Route::get('/product/category/delete/{id}', 'ProductController@deleteCat')->name('admin.product.category.delete');
    Route::match(['POST', 'GET'], '/product/list', 'ProductController@list')->name('admin.product.list');
    Route::get('/product/add', 'ProductController@add')->name('admin.product.add');
    Route::get('/product/update/{id}', 'ProductController@update')->name('admin.product.update');
    Route::post('/product/store', 'ProductController@store')->name('admin.product.store');
    Route::get('/product/delete/{id}', 'ProductController@delete')->name('admin.product.delete');
    Route::get('/product/restore/{id}', 'ProductController@restore')->name('admin.product.restore');
    Route::get('/product/permantly_del/{id}', 'ProductController@permantly_del')->name('admin.product.permantly_del');
    Route::post('/product/action', 'ProductController@action')->name('admin.product.action');
    // Module Order
    Route::match(['POST', 'GET'], '/order', 'OrderController@show')->name('admin.order.show');
    Route::get('/order/detail/{order_id}', 'OrderController@detail')->name('admin.order.detail');
    Route::get('/order/show', function () {
        return redirect()->route('admin.order.show');
    });
    Route::post('/order/changeStatus', 'OrderController@changeStatus')->name('admin.order.changeStatus');
    Route::post('/order/action', 'OrderController@action')->name('admin.order.action');
    // Module User
    Route::match(['POST', 'GET'], '/user/list', 'AdminUserController@list')->name('admin.user.list');
    Route::get('/user/add', 'AdminUserController@add')->name('admin.user.add');
    Route::get('/user/delete/{id}', 'AdminUserController@delete')->name('admin.user.delete');
    Route::get('/user/update/{id}', 'AdminUserController@update')->name('admin.user.update');
    Route::post('/user/store', 'AdminUserController@store')->name('admin.user.store');
    Route::get('/user/restore/{id}', 'AdminUserController@restore')->name('admin.user.restore');
    Route::get('/user/permantly_del/{id}', 'AdminUserController@permantly_del')->name('admin.user.permantly_del');
    Route::match(['POST', 'GET'], '/user/action', 'AdminUserController@action')->name('admin.user.action');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
