<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use App\Models\Contacts;
use App\Models\Settings;
use Http;
use Illuminate\Http\Request;
use Log;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Chats::with('contact')->get();
        return view('front-end.chats', compact('messages'));
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
         // Validate the request
         $request->validate([
             'message' => 'required|string',
             'contact_id' => 'required|integer',
         ]);
     
         $messageContent = $request->input('message');
         $contactId = $request->input('contact_id');
     
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
     
         // Send the message to the recipient using WhatsApp API
         try {
             $response = Http::withToken($accessToken)
                 ->post("https://graph.facebook.com/v20.0/{$fromPhoneNumberId}/messages", [
                     'messaging_product' => 'whatsapp',
                     'to' => $recipientPhoneNumber,
                     'type' => 'text',
                     'text' => [
                         'body' => $messageContent,
                     ],
                 ]);
     
             // Check if the message was sent successfully
             if ($response->successful()) {
                 // Structure the chat data to save into the database
                 $chatData = [
                     'contact_id' => $contact->id,
                     'message_id' => $response->json()['id'] ?? null, // Get the message ID from the response
                     'sender' => 'business',
                     'message' => $messageContent,
                     'type' => 'text', // Assuming the type is always text here, modify if necessary
                     'media_url' => null, // Set to null if there's no media
                     'media_type' => null, // Set to null if there's no media
                     'media_caption' => null, // Set to null if there's no media
                     'is_read' => true,
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
     
                 return response()->json(['success' => true, 'message' => 'Message sent successfully']);
             } else {
                 return response()->json(['success' => false, 'error' => 'Failed to send message']);
             }
         } catch (\Exception $e) {
             return response()->json(['success' => false, 'error' => $e->getMessage()]);
         }
     }

}
