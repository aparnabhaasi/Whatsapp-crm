<?php

namespace App\Http\Controllers;

use App\Models\Broadcast_messages;
use App\Models\Broadcasts;
use App\Models\Chats;
use App\Models\Contacts;
use App\Models\Settings;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ChatController extends Controller
{
     
    public function index()
{
    $authAppId = auth()->user()->app_id;
    $authUserId = auth()->user()->id;
    
    // Step 1: Fetch messages and contacts
    $messages = Chats::with('contact')->get();
    $allContacts = Contacts::where('app_id', $authAppId)
        ->orderBy('name', 'asc')
        ->get();

    // Step 2: Fetch broadcast messages and extract IDs
    $broadcastMessages = Broadcast_messages::select('broadcast_id', 'template_id', 'media', 'created_at')
        ->get();

    $broadcastIds = $broadcastMessages->pluck('broadcast_id')->filter()->toArray();

    // Step 3: Fetch broadcasts with valid IDs or include those with null contact_id
    $broadcasts = Broadcasts::whereIn('id', $broadcastIds)
        ->orWhereNull('contact_id') // Include broadcasts with null contact_id
        ->get(['id', 'contact_id']);

    // Step 4: Fetch settings for WhatsApp API
    $settings = Settings::first();
    if (!$settings) {
        Log::error('Settings not found.');
        return back()->withErrors('Failed to retrieve settings.');
    }
    $accessToken = $settings->access_token;
    $accountID = $settings->account_id;
    $limit = 300;

    // Step 5: Fetch all templates from WhatsApp Cloud API
    $allTemplates = [];
    $url = "https://graph.facebook.com/v20.0/{$accountID}/message_templates?limit={$limit}";
    do {
        $response = Http::withToken($accessToken)->get($url);
        if ($response->successful()) {
            $responseData = $response->json();
            $allTemplates = array_merge($allTemplates, $responseData['data'] ?? []);
            $url = $responseData['paging']['next'] ?? null;
        } else {
            Log::error('Failed to fetch templates from WhatsApp Cloud API.');
            $url = null; // Exit loop
        }
    } while ($url);

    // Step 6: Map template and broadcast message data
    $templateData = [];
    $broadcastMessageData = [];
    foreach ($broadcastMessages as $broadcastMessage) {
        $broadcastId = $broadcastMessage->broadcast_id;
        $templateId = $broadcastMessage->template_id;

        if (!$broadcastId || !$templateId) {
            Log::warning("Invalid broadcast or template ID: {$broadcastId}, {$templateId}");
            continue;
        }

        $url = "https://graph.facebook.com/v20.0/{$templateId}";
        $response = Http::withToken($accessToken)->get($url);

        if ($response->successful()) {
            $templateDetails = $response->json();
            $templateData[$broadcastId][$templateId] = $templateDetails;
            $broadcastMessageData[$broadcastId][$templateId] = [
                'media' => $broadcastMessage->media ?? '',
                'created_at' => $broadcastMessage->created_at ?? now(),
            ];
        } else {
            Log::error("Failed to fetch template for ID: {$templateId}");
        }
    }

    // Step 7: Return the view with all processed data
    return view('front-end.chats', [
        'messages' => $messages,
        'allContacts' => $allContacts,
        'broadcasts' => $broadcasts,
        'templateData' => $templateData,
        'broadcastMessages' => $broadcastMessageData,
        'allTemplates' => $allTemplates,
        'authAppId' => $authAppId,
        'authUserId' => $authUserId, // Pass both variables
    ]);
}



    public function fetchMessages($contactId)
    {
        $messages = Chats::where('contact_id', $contactId)->with('contact')->get();
    
        return response()->json([
            'messages' => $messages
        ]);
    }
    public function loadMessages(Request $request)
    {
        // Get the last message ID sent by the client
        $lastMessageId = $request->query('last_message_id', 0);

        // Fetch messages newer than the last message ID
        $newMessages = Chats::where('id', '>', $lastMessageId)->orderBy('id', 'asc')->get();

        // Return the messages as a JSON response
        return response()->json([
            'messages' => $newMessages,
        ]);
    }
    

public function forwardMessage(Request $request)
{
    $request->validate([
        'message_id' => 'required|exists:chats,id',
        'contact_id' => 'required|exists:contacts,id',
    ]);

    try {
        DB::beginTransaction();

        // Get the original message
        $originalMessage = Chats::findOrFail($request->message_id);
        Log::info('Original message details:', $originalMessage->toArray());

        // Mark the original message as read (if not already read)
        if (!$originalMessage->is_read) {
            $originalMessage->is_read = true;
            $originalMessage->save();
            Log::info('Original message marked as read', ['message_id' => $originalMessage->id]);
        }

        // Forwarding logic
        $contact = Contacts::findOrFail($request->contact_id);
        $recipientPhoneNumber = $contact->mobile;

        $settings = Settings::first();
        $accessToken = $settings->access_token;
        $fromPhoneNumberId = $settings->phone_number_id;

        // Prepare message data for WhatsApp API
        $messageData = [
            'messaging_product' => 'whatsapp',
            'to' => $recipientPhoneNumber,
            'recipient_type' => 'individual',
        ];

        if ($originalMessage->media_url) {
            $messageData['type'] = $originalMessage->media_type;
            $messageData[$originalMessage->media_type] = [
                'link' => $originalMessage->media_url,
            ];
            if (in_array($originalMessage->media_type, ['image', 'video']) && $originalMessage->media_caption) {
                $messageData[$originalMessage->media_type]['caption'] = $originalMessage->media_caption;
            }
        } else {
            $messageData['type'] = 'text';
            $messageData['text'] = [
                'body' => $originalMessage->message,
            ];
        }

        // Send the message using WhatsApp API
        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v20.0/{$fromPhoneNumberId}/messages", $messageData);

        if ($response->successful()) {
            // Save the forwarded message
            $forwardedMessage = Chats::create([
                'contact_id' => $request->contact_id,
                'sender' => 'forwarded',
                'message' => $originalMessage->message,
                'type' => $originalMessage->media_type ?? 'text',
                'media_url' => $originalMessage->media_url,
                'media_type' => $originalMessage->media_type,
                'media_caption' => $originalMessage->media_caption,
                'is_read' => false,
                'message_id' => $response->json()['messages'][0]['id'] ?? null,
            ]);

            Log::info('Message forwarded successfully', ['forwarded_message' => $forwardedMessage]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Message forwarded successfully!',
            ]);
        } else {
            Log::error('WhatsApp API error', ['response' => $response->json()]);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Failed to send forwarded message.',
            ]);
        }
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error while forwarding message', ['exception' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'error' => 'An error occurred while forwarding the message.',
        ]);
    }
}




    // update read status for messages
    public function markAsRead($contactId)
{
    try {
        // Log the contact ID
        Log::info("Received contactId: {$contactId}");

        // Validate contact ID
        if (!$contactId) {
            Log::error("Invalid contactId received.");
            return response()->json(['success' => false, 'message' => 'Invalid contactId received']);
        }

        // Fetch and log unread messages
        $messages = Chats::where('contact_id', $contactId)
            ->where('is_read', false)
            ->get();

        Log::info("Unread messages to mark as read: ", $messages->toArray());

        // Update messages as read
        $updatedRows = Chats::where('contact_id', $contactId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        Log::info("Number of messages updated: {$updatedRows}");

        return response()->json(['success' => $updatedRows > 0, 'updatedRows' => $updatedRows]);
    } catch (\Exception $e) {
        Log::error("Error in markAsRead: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'An error occurred while marking messages as read']);
    }
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
            'authAppId' => 'required|string', // Validate authAppId
            'authUserId' => 'required|integer', // Validate authUserId
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error', ['errors' => $e->errors()]);
        return response()->json(['success' => false, 'error' => 'Validation failed', 'details' => $e->errors()], 422);
    }
// Get the app_id and user_id from the request
    $authAppId = $request->input('authAppId');
    $authUserId = $request->input('authUserId');

    // Now you can use $authAppId and $authUserId for any logic you need
    Log::info('Authenticated user', ['authAppId' => $authAppId, 'authUserId' => $authUserId]);

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

    // Fetch WhatsApp API settings based on the provided authAppId
$settings = Settings::where('app_id', $authAppId)->first();
    $accessToken = $settings->access_token;
    $fromPhoneNumberId = $settings->phone_number_id;

    // Initialize variables
    $mediaUrl = null;
    $mediaType = null;
    $mediaCaption = null;

    // Handle media file upload if present
    if ($request->hasFile('media')) {
        $file = $request->file('media');
        $fileType = $file->getMimeType();

        // Log media file details
        Log::info('Media file details', [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $fileType,
            'size' => $file->getSize()
        ]);

        // Determine the media type (image, video, audio, document)
        if (strpos($fileType, 'image') !== false) {
            $mediaType = 'image';
        } elseif (strpos($fileType, 'video') !== false) {
            $mediaType = 'video';
        } elseif (strpos($fileType, 'audio/') === 0) {
            $mediaType = 'audio';
        } elseif (strpos($fileType, 'application/pdf') !== false || strpos($fileType, 'application/') !== false) {
            $mediaType = 'document';
        }

        // Store the file in the 'uploads/chat_media' folder
        $filePath = $file->storeAs('uploads/chat_media', $file->getClientOriginalName(), 'public');
        $mediaUrl = asset('storage/' . $filePath); // Store the file path to be saved in the database

        $mediaCaption = $messageContent; // Set caption as message content if provided
    }

    // Prepare data for sending WhatsApp message
    $messageData = [
        'messaging_product' => 'whatsapp',
        'to' => $recipientPhoneNumber,
        'recipient_type' => 'individual',
    ];

    if ($mediaUrl) {
        // Prepare the media message
        $messageData['type'] = $mediaType;
        $messageData[$mediaType] = [
            'link' => $mediaUrl, // Use the local file URL
        ];
        
        // Add caption only if the media type supports it
        if (in_array($mediaType, ['image', 'video'])) {
            $messageData[$mediaType]['caption'] = $mediaCaption;
        }
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
                'media_url' => $mediaUrl, // Store the local file path
                'media_type' => $mediaType,
                'media_caption' => $mediaCaption,
                'user_id' => $authUserId,
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