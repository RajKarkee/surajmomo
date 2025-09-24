<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class OrderController extends Controller
{
    // Handle AJAX POST from orderConfirm page
    public function store(Request $request)
    {
        $order = $request->json()->all();

        // Store in DB
        $orderModel = Order::create([
            'order_code'      => $order['id'],
            'customer_name'   => $order['details']['customerName'] ?? '',
            'order_type'      => $order['details']['orderType'] ?? 'personal',
            'business_name'   => $order['details']['businessName'] ?? null,
            'address'         => $order['details']['address'] ?? '',
            'phone'           => $order['details']['phone'] ?? '',
            'map_coordinates' => $order['details']['mapCoordinates'] ?? null,
            'cart'            => $order['cart'],
            'ordered_at'      => now(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Order saved', 'order_id' => $orderModel->id]);
    }

    public function index()
    {
        $orders = \App\Models\Order::orderByDesc('ordered_at')->get();
        return view('admin.orders', compact('orders'));
    }
    public function orderDestroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'Order deleted successfully');
    }
}
