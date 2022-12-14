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
                $message = "Chuy???n tr???ng th??i c???a c??c h??a ????n th??nh 'ch??? x??c nh???n' th??nh c??ng!";
            } elseif ($opt == 'confirmed') {
                $message = "Chuy???n tr???ng th??i c???a c??c h??a ????n th??nh '???? x??c nh???n' th??nh c??ng!";
            } elseif ($opt == 'canceled') {
                $message = "Chuy???n tr???ng th??i c???a c??c h??a ????n th??nh '???? h???y' th??nh c??ng!";
            } elseif ($opt == 'success') {
                $message = "Chuy???n tr???ng th??i c???a c??c h??a ????n 'giao h??ng th??nh c??ng' th??nh c??ng!";
            }
        } else {
            $status_name = "error";
            $message = "B???n ph???i ch???n ??t nh???t m???t b???n ghi";
        }
        return redirect(url()->previous())->with($status_name, $message);
    }
}
