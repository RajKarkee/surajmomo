<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendOrderPushNotification;
use App\Models\DeviceToken;

class OrderPushTest extends TestCase
{
    use RefreshDatabase;

    public function test_device_token_registration_and_order_dispatches_push()
    {
        // register a device token
        $resp = $this->postJson('/device-token', ['token' => 'unit-test-token', 'platform' => 'android']);
        $resp->assertStatus(200)->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('device_tokens', ['token' => 'unit-test-token']);

        // fake the bus and dispatch an order via controller
        Bus::fake();

        $payload = [
            'id' => 'ORD-TEST-1',
            'details' => [
                'customerName' => 'Unit Tester',
                'customerEmail' => 'tester@example.com',
                'orderType' => 'personal',
                'address' => '123 Test Lane',
                'phone' => '1234567890'
            ],
            'cart' => [
                ['name' => 'Item A', 'price' => 100, 'quantity' => 2]
            ]
        ];

        $orderResp = $this->postJson('/orderConfirm', $payload);
        $orderResp->assertStatus(200)->assertJson(['status' => 'success']);

        // job should have been dispatched
        Bus::assertDispatched(SendOrderPushNotification::class);
    }
}
