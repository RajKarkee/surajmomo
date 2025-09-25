<?php

namespace App\Jobs;

use App\Models\DeviceToken;
use App\Models\Order;
use App\Services\PushService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Order $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(PushService $pushService)
    {
        // Collect tokens (for now send to all tokens)
        $tokens = DeviceToken::pluck('token')->filter()->values()->all();
        if (empty($tokens)) {
            return;
        }

        $notification = [
            'title' => 'New Order: ' . ($this->order->order_code ?? '#'.$this->order->id),
            'body' => 'Order placed by ' . ($this->order->customer_name ?? 'Customer') . ' — Total: Rs. ' . number_format($this->order->total, 2),
            'click_action' => config('app.url') . '/admin/orders',
        ];

        $data = [
            'order_id' => $this->order->id,
            'order_code' => $this->order->order_code,
            'total' => $this->order->total,
            'customer_name' => $this->order->customer_name,
        ];

        $pushService->sendToTokens($tokens, ['notification' => $notification, 'data' => $data]);
    }
}
