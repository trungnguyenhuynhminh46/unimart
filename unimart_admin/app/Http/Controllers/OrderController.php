<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }

    function show(Request $request)
    {
        $input = $request->input();
        $keyword = '';
        if (!empty($input['keyword'])) {
            $keyword = $input['keyword'];
        }
        $status = 'all';
        if (!empty($request->input('status'))) {
            $status = $request->input('status');
        }
        // Count number
        $num_all = Order::count();
        $num_waiting = Order::where('status', "waiting")->count();
        $num_confirmed = Order::where('status', "confirmed")->count();
        $num_canceled = Order::where('status', "canceled")->count();
        $num_success = Order::where('status', "success")->count();
        // Search by keyword
        $orders = Order::where(function ($query) use ($keyword) {
            $query->where('username', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('phone_number', 'LIKE', "%{$keyword}%")
                ->orWhere('address', 'LIKE', "%{$keyword}%");
        })->orderBy('created_at', 'DESC');
        // Search by status
        if ($status == 'all') {
            $orders = $orders->paginate(10);
        } else {
            $orders = $orders->where('status', $status)->paginate(10);
        }
        return view('admin.order.show', compact('orders', 'num_all', 'num_waiting', 'num_confirmed', 'num_canceled', 'num_success'));
    }

    function detail(Request $request)
    {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        return view('admin.order.detail', compact('order'));
    }

    function changeStatus(Request $request)
    {
        $input = $request->input();
        $order_id = $input['order_id'];
        $status = $input['status'];
        $order = Order::find($order_id);
        $order->status = $status;
        $order->save();
        return response()->json($input);
    }

    function action(Request $request)
    {
        $status_name = "";
        $message = "";
        $input = $request->input();
        if (isset($input['order_ids'])) {
            $order_ids = $input['order_ids'];
            $opt = $input['opt'];
            Order::whereIn('id', $order_ids)->update(['status' => $opt]);
            $status_name = "success";
            if ($opt == 'waiting') {
                $message = "Chuyển trạng thái của các hóa đơn thành 'chờ xác nhận' thành công!";
            } elseif ($opt == 'confirmed') {
                $message = "Chuyển trạng thái của các hóa đơn thành 'đã xác nhận' thành công!";
            } elseif ($opt == 'canceled') {
                $message = "Chuyển trạng thái của các hóa đơn thành 'đã hủy' thành công!";
            } elseif ($opt == 'success') {
                $message = "Chuyển trạng thái của các hóa đơn 'giao hàng thành công' thành công!";
            }
        } else {
            $status_name = "error";
            $message = "Bạn phải chọn ít nhất một bản ghi";
        }
        return redirect(url()->previous())->with($status_name, $message);
    }
}
