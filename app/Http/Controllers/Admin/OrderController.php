<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $statuses = [
        '0' => 'Đơn hàng mới',
        '1' => 'Đang xử lý',
        '2' => 'Đang giao hàng',
        '3' => 'Đã giao hàng',
        '4' => 'Đã hủy',
    ];
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        $statuses = $this->statuses;
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show($id)
    {
        $order_details = OrderDetail::with(['product_variant', 'product_variant.product', 'product_variant.color', 'product_variant.size'])
            ->where('order_id', $id)
            ->get();

        $order = Order::with('user')->find($id);
        $statuses = $this->statuses;

        return view(
            'admin.orders.show',
            compact('order_details', 'order', 'statuses')
        );
    }
}