<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceToken;

class DeviceTokenController extends Controller
{
    // Register or update a device token
    public function register(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'platform' => 'nullable|string',
            'user_id' => 'nullable|integer',
        ]);

        DeviceToken::updateOrCreate(
            ['token' => $request->input('token')],
            ['platform' => $request->input('platform'), 'user_id' => $request->input('user_id')]
        );

        return response()->json(['status' => 'ok']);
    }
}
