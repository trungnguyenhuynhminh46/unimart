<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    function index()
    {
        $orders = Order::where('username', Auth::user()->username)->orderBy('created_at', 'DESC')->paginate(10);
        return view('home.order.index', compact('orders'));
    }
    function detail(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        return view('home.order.detail', compact('order'));
    }
    function checkOut()
    {
        return view('home.order.checkOut');
    }
    function placeOrder(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'phone_number' => 'required|numeric'
            ],
            [
                'required' => ':attribute không được để trống',
                'numeric' => ':attribute không đúng định dạng'
            ],
            [
                'name' => 'Họ và tên',
                'email' => 'Địa chỉ Email',
                'address' => 'Địa chỉ',
                'phone_number' => 'Số điện thoại'
            ]
        );
        $input = $request->input();
        if (Cart::count() > 0) {
            do {
                $id = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 10);
            } while (Order::where('id', $id)->get()->count() > 0);
            $order = new Order();
            $order->id = $id;
            if (isset($input['username'])) {
                $order->username = $input['username'];
            }
            $order->name = $input['name'];
            $order->email = $input['email'];
            $order->address = $input['address'];
            $order->phone_number = $input['phone_number'];
            $order->note = $input['note'];
            $order->payment = $input['payment'];
            $order->total = (int)str_replace(",", "", Cart::total());
            $order->save();
            foreach (Cart::content() as $row) {
                $product = Product::find($row->id);
                $qty = $row->qty;
                $orderItem = new OrderItem();
                $orderItem->product_id = $product->id;
                $orderItem->order_id = $order->id;
                $orderItem->qty = $qty;
                $orderItem->save();
            }
            Cart::destroy();
            if (Auth::check()) {
                Cart::store(Auth::user()->username);
            }
            $order_id = $order->id;
            return view('home.order.success', compact('order_id'));
        } else {
            return redirect()->route('home');
        }
    }

    function deleteOrder(Request $request)
    {
        $order_id = $request->order_id;
        if (Auth::check()) {
            $order = Order::find($order_id);
            OrderItem::where('order_id', '=', $order_id)->delete();
            $order->delete();
        }
    }

    function cancelOrder(Request $request)
    {
        $input = $request->input();
        $order_id = $input['order_id'];
        $order = Order::find($order_id);
        $order->status = "canceled";
        $order->save();
        return response()->json(["alert" => "Hủy đơn hàng {$order_id} thành công!"]);
    }
}
