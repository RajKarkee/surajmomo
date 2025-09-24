<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail extends Command
{
    protected $signature = 'mail:order {orderId} {to?}';
    protected $description = 'Send OrderPlaced email for a given order id to the admin (for testing)';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        $to = $this->argument('to') ?? config('mail.from.address');

        $order = Order::find($orderId);
        if (! $order) {
            $this->error('Order not found: ' . $orderId);
            return 1;
        }

        try {
            Mail::to($to)->send(new OrderPlaced($order));
            $this->info('OrderPlaced email sent for order #' . $orderId . ' to ' . $to);
        } catch (\Exception $e) {
            $this->error('Failed to send order email: ' . $e->getMessage());
            logger()->error('Failed to send OrderPlaced email: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
