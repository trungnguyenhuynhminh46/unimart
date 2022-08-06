<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Làm việc với đối tượng Cart trong thư viện hardevine ShoppingCart
    function showCart()
    {
        return view('home.cart.index');
    }
    function buyNow(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);
        $qty = "1";
        $product_data = ['id' => $product->id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->price];
        Cart::add($product_data);
        if (Auth::check()) {
            Cart::store(Auth::user()->username);
        }
        return redirect()->route('order.checkOut');
    }
    function addCart(Request $request)
    {
        $input = $request->input();
        $product_id = $input['product_id'];
        $qty = $input['qty'];
        $product = Product::find($product_id);
        Cart::add(['id' => $product->id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->price]);
        if (Auth::check()) {
            Cart::store(Auth::user()->username);
        }

        $alert = "Thêm thành công {$product->name} vào giỏ hàng";
        return response()->json(['alert' => $alert]);
    }
    function updateCartItem(Request $request)
    {
        $input = $request->input();
        $rowId = $input['rowId'];
        $qty = $input['qty'];
        Cart::update($rowId, $qty);
        if (Auth::check()) {
            Cart::store(Auth::user()->username);
        }
        return response()->json(['alert' => "Cập nhật giỏ hàng thành công"]);
    }
    function deleteCartItem(Request $request)
    {
        $input = $request->input();
        Cart::remove($input['rowId']);
        if (Auth::check()) {
            Cart::store(Auth::user()->username);
        }
        return response()->json($input['rowId']);
    }
    function destroyCart(Request $request)
    {
        Cart::destroy();
        if (Auth::check()) {
            Cart::store(Auth::user()->username);
        }
        return response()->json(['alert' => 'Xóa toàn bộ giỏ hàng thành công']);
    }
}
