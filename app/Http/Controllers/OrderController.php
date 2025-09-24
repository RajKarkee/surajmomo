<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // Handle AJAX POST from orderConfirm page
    public function store(Request $request)
    {
        $order = $request->json()->all();

        // Calculate total from cart items
        $total = 0;
        if (isset($order['cart']) && is_array($order['cart'])) {
            foreach ($order['cart'] as $item) {
                $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                $price = isset($item['price']) ? (float) $item['price'] : 0;
                $total += $qty * $price;
            }
        }

        // Store in DB
        $orderModel = Order::create([
            'order_code'      => $order['id'],
            'customer_name'   => $order['details']['customerName'] ?? '',
            'customer_email'  => $order['details']['customerEmail'] ?? $order['details']['email'] ?? null,
            'order_type'      => $order['details']['orderType'] ?? 'personal',
            'business_name'   => $order['details']['businessName'] ?? null,
            'address'         => $order['details']['address'] ?? '',
            'phone'           => $order['details']['phone'] ?? '',
            'map_coordinates' => $order['details']['mapCoordinates'] ?? null,
            'cart'            => $order['cart'],
            'total'           => $total,
            'ordered_at'      => now(),
        ]);

        // Send notification email (to admin, and also to customer if email provided)
        try {
            $adminEmail = config('mail.from.address');

            // if ($orderModel->customer_email) {
            //     // Send to customer and BCC admin
            //     Mail::to($orderModel->customer_email)->bcc($adminEmail)->send(new OrderPlaced($orderModel));
            // } else {
                // Send to admin only
                Mail::to($adminEmail)->send(new OrderPlaced($orderModel));
          
        } catch (\Exception $e) {
            Log::error('Order email failed for order_id='.$orderModel->id.': '.$e->getMessage());
            // don't interrupt the response — email failures should not block order saving
        }

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
