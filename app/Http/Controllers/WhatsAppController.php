<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function handleCallback(Request $request)
{
    // Log the entire request for debugging
    Log::info('WhatsApp Callback Request', [
        'headers' => $request->headers->all(),
        'query' => $request->query(),
        'post' => $request->post(),
        'body' => $request->getContent()
    ]);

    // Check if the request is a verification request
    if ($request->has('hub_mode') && $request->hub_mode === 'subscribe') {
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN');

        if ($request->hub_verify_token === $verifyToken) {
            return response($request->hub_challenge);
        } else {
            return response('Invalid verify token', 403);
        }
    }

    // Handle POST requests for incoming events
    $messageData = $request->all(); // Capture all incoming request data
    Log::info('WhatsApp Callback Event', $messageData);

    // Return the test message data for debugging
    return response()->json([
        'status' => 'success',
        'message_data' => $messageData
    ]);
}

}
