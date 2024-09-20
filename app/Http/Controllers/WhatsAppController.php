<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Contacts;
use App\Models\Chats;

class WhatsAppController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Log headers and basic information for debugging
        Log::info('WhatsApp Callback Request', [
            'headers' => $request->headers->all(),
            'query' => $request->query(),
            'post' => $request->post()
        ]);

        // Handle verification requests
        if ($request->query('hub_mode') === 'subscribe') {
            $verifyToken = 'ICTwtspcrm890';
            if ($request->query('hub_verify_token') === $verifyToken) {
                return response($request->query('hub_challenge'), 200)->header('Content-Type', 'text/plain');
            } else {
                Log::warning('Invalid verify token', ['provided' => $request->query('hub_verify_token')]);
                return response('Invalid verify token', 403);
            }
        }

        // Handle POST requests for incoming events
        try {
            $messageData = json_decode($request->getContent(), true, 512);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Decode Error:', ['error' => json_last_error_msg()]);
                return response()->json(['error' => 'Invalid JSON format'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Exception while decoding JSON:', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Server error'], 500);
        }

        // Log relevant data only
        Log::info('WhatsApp Callback Event', [
            'metadata' => $messageData['entry'][0]['changes'][0]['value']['metadata'] ?? null,
            'message' => $messageData['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'] ?? null
        ]);

        // Extract contact information
        $contactData = $messageData['entry'][0]['changes'][0]['value']['contacts'][0] ?? null;
        if ($contactData) {
            $waId = $contactData['wa_id'];
            $name = $contactData['profile']['name'] ?? 'Unknown';

            // Check if the contact already exists
            $existingContact = Contacts::where('mobile', $waId)->first();

            if (!$existingContact) {
                // If contact does not exist, create a new one
                $newContact = new Contacts();
                $newContact->name = $name;
                $newContact->mobile = $waId;
                $newContact->email = null; // No email provided from webhook
                $newContact->tags = json_encode([]); // Default tags

                $newContact->save();

                Log::info('New contact created', ['contact_id' => $newContact->id]);
            } else {
                // Update the contact's name if it exists
                $existingContact->save();

                Log::info('Existing contact updated', ['contact_id' => $existingContact->id]);
            }

            // Store the message in the `chats` table
            $this->storeMessage($messageData, $existingContact ?? $newContact);
        } else {
            Log::warning('No contact data found in webhook payload');
            return response()->json(['error' => 'No contact data found'], 400);
        }

        // Handle image messages
        $messages = $messageData['entry'][0]['changes'][0]['value']['messages'] ?? [];
        foreach ($messages as $message) {
            if (isset($message['type']) && $message['type'] === 'image') {
                $imageUrl = $message['image']['url'] ?? null;
                if ($imageUrl) {
                    // Log or save the image URL
                    Log::info('Image received', ['image_url' => $imageUrl]);

                    // Example: Download the image (optional)
                    $imageContents = file_get_contents($imageUrl);
                    $imagePath = 'path/to/save/image.jpg'; // Adjust path as needed
                    file_put_contents($imagePath, $imageContents);
                } else {
                    Log::warning('No image URL found in the message');
                }
            }
        }

        // Return a response indicating success
        return response()->json(['status' => 'success', 'message_data' => $messageData]);
    }

    // Method to store the message in the chats table
    public function storeMessage($messageData, $contact)
    {
        $messages = $messageData['entry'][0]['changes'][0]['value']['messages'] ?? [];

        foreach ($messages as $message) {
            $chatData = [
                'contact_id' => $contact->id, // Use the contact ID from Contacts table
                'message_id' => $message['id'] ?? null,
                'sender' => 'customer',
                'message' => $message['text']['body'] ?? null,
                'type' => $message['type'] ?? 'text',
                'media_url' => $message['image']['url'] ?? null,
                'media_type' => $message['type'] ?? null,
                'media_caption' => $message['caption'] ?? null,
                'is_read' => false,
            ];

            // Save message details into the chats table
            try {
                $chat = new Chats();
                $chat->fill($chatData);
                $chat->save();

                Log::info('Message stored successfully', ['chat_data' => $chatData]);
            } catch (\Exception $e) {
                Log::error('Error storing message', ['exception' => $e->getMessage(), 'chat_data' => $chatData]);
            }
        }
    }
}
