<?php

namespace App\Http\Controllers;

use App\Models\Broadcast_messages;
use App\Models\Broadcasts;
use App\Models\Chats;
use App\Models\Contacts;
use App\Models\Settings;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
{
    // Fetch all chat messages
    $messages = Chats::with('contact')->get();

    // Fetch broadcast_ids and template_ids from broadcast_message table
    $broadcastMessages = Broadcast_messages::select('broadcast_id', 'template_id', 'media', 'created_at')->get();

    // Fetch corresponding broadcasts from broadcast table based on broadcast_id
    $broadcastIds = $broadcastMessages->pluck('broadcast_id')->toArray();
    $broadcasts = Broadcasts::whereIn('id', $broadcastIds)->get(['id', 'contact_id']);

    // Get the access token from the settings table
    $settings = Settings::first();
    $accessToken = $settings->access_token;

    // Initialize an array to store template data
    $templateData = [];
    $broadcastMessageData = []; // New array to store broadcast messages data

    // Log the media from broadcast_message table
    foreach ($broadcastMessages as $broadcastMessage) {
        // Log::info('Media for Broadcast Message ID: ' . $broadcastMessage->broadcast_id . ', Media: ' . $broadcastMessage->media);

        $templateId = $broadcastMessage->template_id;
        $url = "https://graph.facebook.com/v20.0/{$templateId}";

        $response = Http::withToken($accessToken)->get($url);

        if ($response->successful()) {
            // Store the template data, keying it by both broadcast_id and template_id
            $templateData[$broadcastMessage->broadcast_id][$broadcastMessage->template_id] = $response->json();

            // Also store media and media_type for each broadcast_id and template_id
            $broadcastMessageData[$broadcastMessage->broadcast_id][$broadcastMessage->template_id] = [
                'media' => $broadcastMessage->media,
                'created_at' => $broadcastMessage->created_at,
            ];
        } else {
            // Handle the error, e.g., log it or notify the user
            \Log::error("Failed to fetch template for ID: {$templateId}");
        }
    }

    return view('front-end.chats', [
        'messages' => $messages,
        'broadcasts' => $broadcasts, 
        'templateData' => $templateData,
        'broadcastMessages' => $broadcastMessageData, 
    ]);
}


    // update read status for messages
    public function markAsRead($contactId)
    {
        // Update the unread messages for the given contact_id to 'read'
        Chats::where('contact_id', $contactId)
            ->where('is_read', false) // Only update unread messages
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }



     // Function to send WhatsApp message
public function sendMessage(Request $request)
{
    // Log the entire request for debugging purposes
    Log::info('Full request data', ['request' => $request->all(), 'files' => $request->file()]);
    
    // Validate the request
    try {
        $request->validate([
            'message' => 'nullable|string',
            'contact_id' => 'required|integer',
            'media' => 'nullable|file', // Validate media if uploaded
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error', ['errors' => $e->errors()]);
        return response()->json(['success' => false, 'error' => 'Validation failed', 'details' => $e->errors()], 422);
    }

    $messageContent = $request->input('message');
    $contactId = $request->input('contact_id');

    // Log incoming data
    Log::info('Incoming request data', [
        'message' => $messageContent,
        'contact_id' => $contactId,
        'media' => $request->hasFile('media') ? $request->file('media')->getClientOriginalName() : 'No media'
    ]);

    // Fetch the recipient's phone number from the contact's details
    $contact = Contacts::find($contactId);

    if (!$contact) {
        return response()->json(['success' => false, 'error' => 'Contact not found'], 404);
    }

    $recipientPhoneNumber = $contact->mobile;

    // Fetch WhatsApp API settings from the settings table
    $settings = Settings::first();
    $accessToken = $settings->access_token;
    $fromPhoneNumberId = $settings->phone_number_id;

    // Check if media is present
    $mediaId = null;
    $mediaType = null;
    $mediaCaption = null;

    if ($request->hasFile('media')) {
        $file = $request->file('media');
        $fileType = $file->getMimeType();

        // Log media file details
        Log::info('Media file details', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $fileType,
            'size' => $file->getSize()
        ]);

        // Determine the media type (image, video, document)
        if (strpos($fileType, 'image') !== false) {
            $mediaType = 'image';
        } elseif (strpos($fileType, 'video') !== false) {
            $mediaType = 'video';
        } elseif (strpos($fileType, 'application/pdf') !== false || strpos($fileType, 'application/') !== false) {
            $mediaType = 'document';
        }

        // Upload media to WhatsApp Cloud API
        try {
            $mediaResponse = Http::withToken($accessToken)
                ->attach('file', fopen($file->getPathname(), 'r'), $file->getClientOriginalName())
                ->post("https://graph.facebook.com/v20.0/{$fromPhoneNumberId}/media", [
                    'messaging_product' => 'whatsapp',  // Use form-data
                    'type' => $mediaType,  // Correct media type
                ]);

            if ($mediaResponse->successful()) {
                $mediaId = $mediaResponse->json()['id'];
                $mediaCaption = $request->input('message'); // Set caption as message content if provided

                // Log the media ID
                Log::info('Media uploaded successfully', [
                    'media_id' => $mediaId,
                    'response' => $mediaResponse->json(),
                ]);
            } else {
                Log::error('Media upload failed', [
                    'response' => $mediaResponse->json(),
                    'status_code' => $mediaResponse->status(),
                ]);
                return response()->json(['success' => false, 'error' => 'Failed to upload media', 'response' => $mediaResponse->json()]);
            }
        } catch (\Exception $e) {
            Log::error('Media upload error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => 'Media upload error: ' . $e->getMessage()]);
        }
    }

    // Prepare data for sending WhatsApp message
    $messageData = [
        'messaging_product' => 'whatsapp',
        'to' => $recipientPhoneNumber,
        'recipient_type' => 'individual',
    ];

    if ($mediaId) {
        // If media is present, prepare the media message
        $messageData['type'] = $mediaType;
        $messageData[$mediaType] = [
            'id' => $mediaId,
            'caption' => $mediaCaption, // Optional caption for media
        ];
    } else {
        // If no media, send a text message
        if (!empty($messageContent)) {
            $messageData['type'] = 'text';
            $messageData['text'] = [
                'body' => $messageContent,
            ];
        } else {
            return response()->json(['success' => false, 'error' => 'Message content is required when no media is provided']);
        }
    }

    // Send the message to the recipient using WhatsApp API
    try {
        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v20.0/{$fromPhoneNumberId}/messages", $messageData);

        // Check if the message was sent successfully
        if ($response->successful()) {
            // Structure the chat data to save into the database
            $chatData = [
                'contact_id' => $contact->id,
                'message_id' => $response->json()['messages'][0]['id'] ?? null, // Get the message ID from the response
                'sender' => 'business',
                'message' => $messageContent,
                'type' => $mediaType ?? 'text', // Use media type if media is present
                'media_url' => $mediaId ? "https://graph.facebook.com/v20.0/{$mediaId}" : null,
                'media_type' => $mediaType,
                'media_caption' => $mediaCaption,
                'is_read' => true,
            ];

            // Save message details into the chats table
            try {
                $chat = new Chats();
                $chat->fill($chatData);
                $chat->save();

                return response()->json(['success' => true, 'message' => 'Message sent and stored successfully', 'chat' => $chatData]);
            } catch (\Exception $e) {
                Log::error('Error storing message', ['error' => $e->getMessage()]);
                return response()->json(['success' => false, 'error' => 'Error storing message: ' . $e->getMessage()]);
            }
        } else {
            Log::error('Message sending failed', [
                'response' => $response->json(),
                'status_code' => $response->status(),
            ]);
            return response()->json(['success' => false, 'error' => 'Failed to send message', 'response' => $response->json()]);
        }
    } catch (\Exception $e) {
        Log::error('Message sending error', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'error' => 'Message sending error: ' . $e->getMessage()]);
    }
}


}
