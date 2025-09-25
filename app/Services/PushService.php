<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushService
{
    /**
     * Send a push notification via FCM (legacy HTTP v1 with server key).
     *
     * @param array $tokens
     * @param array $payload
     * @return array|null
     */
    public function sendToTokens(array $tokens, array $payload)
    {
        $serverKey = config('services.fcm.server_key');
        if (! $serverKey) {
            Log::warning('FCM server key not configured. Skipping push.');
            return null;
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $body = [
            'registration_ids' => $tokens,
            'priority' => 'high',
            'data' => $payload['data'] ?? [],
            'notification' => $payload['notification'] ?? [],
        ];

        try {
            $resp = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])->post($url, $body);

            if ($resp->failed()) {
                Log::error('FCM push failed: '.$resp->body());
            }

            return $resp->json();
        } catch (\Exception $e) {
            Log::error('FCM push exception: '.$e->getMessage());
            return null;
        }
    }
}
