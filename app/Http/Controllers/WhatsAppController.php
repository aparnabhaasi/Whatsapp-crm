<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Contacts;
use App\Models\User;
use App\Models\Chats;
use Storage;

class WhatsAppController extends Controller
{
    public function handleCallback(Request $request)
    {

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
            'message_type' => $messageData['entry'][0]['changes'][0]['value']['messages'][0]['type'] ?? 'unknown',
            'message_text' => $messageData['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'] ?? null,
            'image' => $messageData['entry'][0]['changes'][0]['value']['messages'][0]['image'] ?? null,
            'image_caption' => $messageData['entry'][0]['changes'][0]['value']['messages'][0]['image']['caption'] ?? null
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
            }

            // Store the message in the `chats` table
            $this->storeMessage($messageData, $existingContact ?? $newContact);
        } else {
            // Log::warning('No contact data found in webhook payload');
            return response()->json(['error' => 'No contact data found'], 400);
        }


        // Return a response indicating success
        return response()->json(['status' => 'success', 'message_data' => $messageData]);
    }

public function storeMessage($messageData)
{
    $entries = $messageData['entry'] ?? [];

    Log::info('Raw message data received', ['message_data' => $messageData]);

    foreach ($entries as $entryIndex => $entry) {
        Log::info("Processing entry $entryIndex", ['entry' => $entry]);

        $changes = $entry['changes'] ?? [];

        foreach ($changes as $changeIndex => $change) {
            Log::info("Processing change $changeIndex in entry $entryIndex", ['change' => $change]);

            $messages = $change['value']['messages'] ?? [];
            $displayPhoneNumber = $change['value']['metadata']['display_phone_number'] ?? null;

            if (!$displayPhoneNumber) {
                Log::warning('Display phone number missing in metadata', ['change' => $change]);
                continue;
            }

            Log::info('Display phone number found', ['display_phone_number' => $displayPhoneNumber]);

            // Retrieve app_id using the display phone number from the users table
            $user = User::where('mobile', $displayPhoneNumber)->first();

            if (!$user) {
                Log::warning('User not found for display phone number', ['display_phone_number' => $displayPhoneNumber]);
                continue;
            }

            $appId = $user->app_id;

            Log::info('App ID found for user', ['app_id' => $appId]);

            foreach ($messages as $messageIndex => $message) {
                Log::info("Processing message $messageIndex in change $changeIndex of entry $entryIndex", ['message' => $message]);

                $mediaUrl = null;
                $localPath = null;
                $mediaType = $message['type'] ?? 'text';
                $senderNumber = $message['from'] ?? null;

                if (!$senderNumber) {
                    Log::warning('Sender number missing', ['message' => $message]);
                    continue;
                }

                Log::info('Sender number found', ['sender_number' => $senderNumber]);

                // Retrieve the contact using the sender number and app_id
                $contact = Contacts::where('mobile', $senderNumber)
                    ->where('app_id', $appId)
                    ->first();

                // If contact is not found, log the sender's number and save the message without contact_id
                if (!$contact) {
                    Log::info('Contact not found for sender number, storing message without contact ID', [
                        'sender_number' => $senderNumber,
                        'message' => $message['text']['body'] ?? null
                    ]);

                    // Save message without contact_id
                    $chatData = [
                        'contact_id' => null, // No contact ID
                        'message_id' => $message['id'] ?? null,
                        'sender' => 'customer',
                        'message' => $message['text']['body'] ?? null,
                        'type' => $mediaType,
                        'media_url' => $localPath ?? null,
                        'media_type' => $mediaType,
                        'media_caption' => $message[$mediaType]['caption'] ?? null,
                        'is_read' => false,
                    ];

                    try {
                        $chat = new Chats();
                        $chat->fill($chatData);
                        $chat->save();

                        Log::info('Message stored successfully without contact', ['chat_data' => $chatData]);
                    } catch (\Exception $e) {
                        Log::error('Error storing message without contact', ['exception' => $e->getMessage(), 'chat_data' => $chatData]);
                    }
                    continue;
                }

                Log::info('Contact found', ['contact' => $contact]);

                // Check if the message has a media type
                if (in_array($mediaType, ['image', 'video', 'document', 'audio']) && isset($message[$mediaType]['id'])) {
                    $mediaUrl = $this->getMediaUrl($message[$mediaType]['id']);
                    if ($mediaUrl) {
                        $localPath = $this->downloadAndStoreMedia($mediaUrl, $message[$mediaType]['mime_type']);
                    }
                }

                $chatData = [
                    'contact_id' => $contact->id,
                    'message_id' => $message['id'] ?? null,
                    'sender' => 'customer',
                    'message' => $message['text']['body'] ?? null,
                    'type' => $mediaType,
                    'media_url' => $localPath ?? null,
                    'media_type' => $mediaType,
                    'media_caption' => $message[$mediaType]['caption'] ?? null,
                    'is_read' => false,
                ];

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
}










// Method to get media URL from WhatsApp API
public function getMediaUrl($mediaId)
{
    $settings = Settings::first();
    $accessToken = $settings->access_token;

    $mediaUrl = null;

    try {
        // Make the request to the WhatsApp API
        $url = "https://graph.facebook.com/v21.0/{$mediaId}";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ]);

        // Decode the response to get the media URL
        $responseBody = json_decode($response->getBody(), true);
        if (isset($responseBody['url'])) {
            $mediaUrl = $responseBody['url'];
        }
    } catch (\Exception $e) {
        Log::error('Error fetching media URL', ['exception' => $e->getMessage()]);
    }

    return $mediaUrl;
}

public function downloadAndStoreMedia($mediaUrl, $mimeType)
{
    $settings = Settings::first();
    $accessToken = $settings->access_token;

    $client = new Client();
    $response = $client->get($mediaUrl, [
        'headers' => [
            'Authorization' => 'Bearer ' . $accessToken, 
        ],
        'stream' => true, // Stream the response
    ]);

    // Determine file extension from mime type
    $extension = $this->getExtensionFromMimeType($mimeType);

    // Create a unique filename
    $filename = uniqid() . '.' . $extension;
    $path = 'uploads/chat_media/' . $filename;

    // Store the file locally
    Storage::disk('public')->put($path, $response->getBody()->getContents());

    // Log the local file path of the stored media
    Log::info('Media downloaded and stored successfully', ['path' => $path]);

    return $path; // Return the local file path
}

// Helper method to determine file extension from mime type
public function getExtensionFromMimeType($mimeType)
{
    switch ($mimeType) {
        case 'image/jpeg':
            return 'jpg';
        case 'image/png':
            return 'png';
        case 'image/gif':
            return 'gif';
        case 'video/mp4':
            return 'mp4';
        case 'video/avi':
            return 'avi';
        case 'application/pdf':
            return 'pdf';
        case 'application/msword':
            return 'doc';
        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return 'docx';
        default:
            return 'bin'; // Default to a binary file if unknown
    }
}



}
