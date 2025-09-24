<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderPlacedMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_store_and_mail_sent()
    {
        Mail::fake();

        $payload = [
            'id' => 'ORD123',
            'details' => [
                'customerName' => 'Test Customer',
                'phone' => '1234567890',
                'address' => '123 Test St',
                'customerEmail' => 'customer@example.test',
                'mapCoordinates' => '27.700769,85.300140'
            ],
            'cart' => [
                [
                    'name' => 'Momo Classic',
                    'quantity' => 2,
                    'price' => 5.5
                ]
            ]
        ];

        $response = $this->postJson('/orderConfirm', $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);

        // assert order in database
        $this->assertDatabaseHas('orders', [
            'order_code' => 'ORD123',
            'customer_name' => 'Test Customer',
            'customer_email' => 'customer@example.test',
            'phone' => '1234567890',
            'total' => 11.00
        ]);

        $order = Order::where('order_code', 'ORD123')->first();
        $this->assertNotNull($order);

        // Assert mailable was sent to the customer
        Mail::assertSent(OrderPlaced::class, function ($mail) use ($order) {
            return $mail->hasTo('customer@example.test') && $mail->order->id === $order->id;
        });
    }
}
