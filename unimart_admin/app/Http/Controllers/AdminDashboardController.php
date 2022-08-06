<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function convertCurrency($num)
    {
        // xx tỷ
        // xx triệu
        if ($num < 1000000000) {
            return number_format($num / 1000000) . " triệu";
        } else {
            return number_format($num / 1000000000) . " tỷ";
        }
    }

    function show()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(10);
        $num_success = Order::where('status', 'success')->count();
        $num_waiting = Order::where('status', 'waiting')->count();
        $num_canceled = Order::where('status', 'canceled')->count();
        $turnover = 0;
        $success_orders = Order::where('status', 'success')->get();
        foreach ($success_orders as $order) {
            $turnover += $order->total;
        }
        $turnover = $this->convertCurrency($turnover);
        return view('admin.dashboard.show', compact('orders', 'num_success', 'num_waiting', 'num_canceled', 'turnover'));
    }
}
