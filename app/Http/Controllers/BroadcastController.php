<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Broadcast_messages;
use App\Models\Broadcasts;
use App\Models\Contacts;
use App\Models\Settings;
use Http;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\DB;

class BroadcastController extends Controller
{
    public function index()
    {
        // Fetch contacts and broadcasts
        // Fetch the authenticated admin's app_id
    $authAdminAppId = Auth::user()->app_id;

    // Fetch contacts that match the authenticated admin's app_id
    $contacts = DB::table('contacts')
        ->where('app_id', $authAdminAppId)
        ->get();

        // Extract contact IDs
    $contactIds = $contacts->pluck('id')->toArray();

    // Fetch broadcasts where contact_id overlaps with the authenticated admin's contact IDs
    $broadcasts = Broadcasts::orderBy('created_at','desc')->get()->filter(function ($broadcast) use ($contactIds) {
        return !empty(array_intersect($broadcast->contact_id, $contactIds));
    });
    
        // Fetch templates using WhatsApp Cloud API
         

$settings = Settings::where('app_id', $authAdminAppId)->first();
        $accessToken = $settings->access_token;
        $accountID = $settings->account_id;
        $limit = 300;
        $url = "https://graph.facebook.com/v21.0/{$accountID}/message_templates?limit={$limit}";
    
        $allTemplates = [];
    
        do {
            // Make the GET request to the WhatsApp Cloud API
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}"
            ])->get($url);
    
            // Check if the request was successful
            if ($response->successful()) {
                $responseData = $response->json();
                $templates = $responseData['data'];
    
                // Add templates to the collection
                $allTemplates = array_merge($allTemplates, $templates);
    
                // Check if there's a 'next' link in the pagination
                $url = $responseData['paging']['next'] ?? null;
            } else {
                $url = null; // Exit loop if request failed
                Log::error('Failed to fetch templates from WhatsApp Cloud API.', [
                    'error' => $response->json()
                ]);
            }
        } while ($url);
    
        // Filter templates to only include those with status 'APPROVED'
        $approvedTemplates = array_filter($allTemplates, function ($template) {
            return isset($template['status']) && $template['status'] === 'APPROVED';
        });
    
        // Return view with contacts, broadcasts, and approved templates
        return view('front-end.broadcast', compact('contacts', 'broadcasts', 'approvedTemplates'));
    }


    


   public function store(Request $request){
      // validate date
      $validateData = $request->validate([
         'contact_id' => 'required|array',
         'broadcast_name' => 'required|string',
      ]);


      try{
        // create new instance for broadcast
         $broadcast = new Broadcasts();
         $broadcast->contact_id = $validateData['contact_id'];
         $broadcast->broadcast_name = $validateData['broadcast_name'];

         $broadcast -> save();

         return redirect()->back()->with('success', 'Broadcast created successfully!');

      } catch(\Exception $e){
         Log::error('An error occured while creating broadcast', ["error message:" => $e ->getMessage(), ]);

         return redirect()->back()->with('error', 'An error occured while creating broadcast. Contact support.');
      }
   }

    public function updateBroadcastGroup(Request $request, $id){
        // validate date
        $validateData = $request->validate([
        'contact_id' => 'required|array',
        'broadcast_name' => 'required|string',
        ]);


        try{
        // create new instance for broadcast
        $broadcast = Broadcasts::find($id);
        $broadcast->contact_id = $validateData['contact_id'];
        $broadcast->broadcast_name = $validateData['broadcast_name'];

        $broadcast -> save();

        return redirect()->back()->with('success', 'Broadcast updated successfully!');

        } catch(\Exception $e){
        Log::error('An error occured while creating broadcast', ["error message:" => $e ->getMessage(), ]);

        return redirect()->back()->with('error', 'An error occured while updating broadcast. Contact support.');
        }
    }


   public function broadcastMessage(Request $request)
{
    // Validate data
    $validateData = $request->validate([
        'broadcast_group' => 'required|integer',
        'message_template' => 'required|integer',
        'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,wmv,mkv,pdf',
        'coupon_code' => 'nullable|string',
        'variables' => 'nullable|array', // Expecting 'variables' to be an array
        'variables.*' => 'nullable|string', // Each variable must be a string
    ]);

    // Debugging: log validated data
    Log::info('Validated data:', $validateData);

    $variables = $validateData['variables'] ?? [];

    // Check if media is uploaded
    $mediaPath = $request->hasFile('media') ? $request->file('media')->store('template_media', 'public') : null;

    try {
        // Store the broadcast message
        $broadcastMessage = new Broadcast_messages();
        $broadcastMessage->broadcast_id = $validateData['broadcast_group'];
        $broadcastMessage->template_id = $validateData['message_template'];
        $broadcastMessage->media = $mediaPath;

        // Store variables in the body content
        $broadcastMessage->body_content = json_encode($variables);

        // Safely handle the coupon code
        $couponCode = $validateData['coupon_code'] ?? null;
        $broadcastMessage->button_content = $couponCode ? json_encode([$couponCode]) : json_encode([]);

        $broadcastMessage->save();

        // Fetch the broadcast group details
        $broadcast = Broadcasts::find($validateData['broadcast_group']);

        // Fetch the contacts in the broadcast group
        $contacts = Contacts::whereIn('id', $broadcast->contact_id)->get();

        // Fetch WhatsApp API settings
        $settings = Settings::where('app_id', auth()->user()->app_id)->first(); // Select settings for the authenticated user's app_id
        if (!$settings) {
            Log::error('Settings not found for the authenticated user.');
            return redirect()->back()->with('error', 'Settings not found. Contact support.');
        }

        $whatsappApiToken = $settings->access_token;
        $whatsappPhoneNumberId = $settings->phone_number_id;

        // Fetch the template details using the WhatsApp Cloud API
        $templateResponse = Http::withToken($whatsappApiToken)
            ->get("https://graph.facebook.com/v21.0/{$validateData['message_template']}");

        if ($templateResponse->failed()) {
            Log::error('Failed to fetch template details. Response: ' . $templateResponse->body());
            return redirect()->back()->with('error', 'Failed to fetch template details. Please check the template ID.');
        }

        $templateDetails = $templateResponse->json();

        // Iterate through contacts and send messages
        foreach ($contacts as $contact) {
            $this->sendWhatsAppMessage($whatsappApiToken, $whatsappPhoneNumberId, $contact->mobile, $templateDetails, $mediaPath ? asset("storage/{$mediaPath}") : null, $couponCode, $variables);
        }

        return redirect()->back()->with('success', 'Broadcast message sent successfully.');
    } catch (\Exception $e) {
        Log::error('Error in broadcasting message: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error in broadcasting message. Contact support!');
    }
}

protected function sendWhatsAppMessage($whatsappApiToken, $whatsappPhoneNumberId, $mobile, $templateDetails, $mediaUrl, $couponCode = null, $variables = null)
{
    try {
        // Log request data
        Log::info('Sending WhatsApp message:', [
            'mobile' => $mobile,
            'templateDetails' => $templateDetails,
            'mediaUrl' => $mediaUrl,
            'couponCode' => $couponCode,
            'variables' => $variables,
        ]);

        // Construct the message payload
        $components = [];

        foreach ($templateDetails['components'] as $component) {
            if ($component['type'] === 'BODY' && !empty($variables)) {
                $parameters = array_map(fn($variable) => ['type' => 'text', 'text' => $variable], $variables);
                $components[] = [
                    'type' => 'body',
                    'parameters' => $parameters,
                ];
            }

            if ($component['type'] === 'HEADER' && isset($component['format'])) {
                $headerType = strtolower($component['format']);
                if (in_array($headerType, ['image', 'video', 'document']) && $mediaUrl) {
                    $components[] = [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => $headerType,
                                $headerType => ['link' => $mediaUrl],
                            ],
                        ],
                    ];
                }
            }

            if ($component['type'] === 'BUTTONS') {
                foreach ($component['buttons'] as $index => $button) {
                    if ($button['type'] === 'COPY_CODE' && $couponCode) {
                        $components[] = [
                            'type' => 'button',
                            'sub_type' => 'copy_code',
                            'index' => $index,
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $couponCode,
                                ],
                            ],
                        ];
                    }
                }
            }
        }

        // Send the WhatsApp message
        $response = Http::withToken($whatsappApiToken)->post("https://graph.facebook.com/v21.0/{$whatsappPhoneNumberId}/messages", [
            'messaging_product' => 'whatsapp',
            'to' => $mobile,
            'type' => 'template',
            'template' => [
                'name' => $templateDetails['name'],
                'language' => [
                    'code' => $templateDetails['language'],
                ],
                'components' => $components,
            ],
            'status_callback' => 'https://ictglobaltech.org.in/whatsapp/callback',
        ]);

        Log::info('WhatsApp response:', ['response' => $response->json()]);

        if ($response->failed()) {
            Log::error('Failed to send WhatsApp message: ' . $response->body());
            return;
        }

        $responseData = $response->json();
        $broadcastId = $templateDetails['id'] ?? null;

        if (!$broadcastId) {
            Log::error('Broadcast ID is missing. Aborting.');
            return;
        }

        $acceptedCount = 0;
        $rejectedCount = 0;

        foreach ($responseData['messages'] as $message) {
            $status = $message['message_status'] ?? 'unknown';
            if ($status === 'accepted') $acceptedCount++;
            elseif ($status === 'rejected') $rejectedCount++;
            else Log::warning('Unexpected message status.', ['status' => $status]);
        }

        Log::info("Summary - Accepted: $acceptedCount, Rejected: $rejectedCount");

        $this->storeBroadcastHistory($broadcastId, $acceptedCount, $rejectedCount);

    } catch (\Exception $e) {
        Log::error('Error in sendWhatsAppMessage: ' . $e->getMessage());
    }
}


private function storeBroadcastHistory($broadcastId, $acceptedCount, $rejectedCount)
{
    try {
        DB::beginTransaction();

        $broadcastMessage = DB::table('broadcast_messages')->where('template_id', $broadcastId)->first();
        if (!$broadcastMessage) {
            Log::error('No broadcast message found.', ['broadcast_id' => $broadcastId]);
            DB::rollBack();
            return;
        }

        $broadcast = DB::table('broadcast')->where('id', $broadcastMessage->broadcast_id)->first();
        if (!$broadcast || empty($broadcast->contact_id)) {
            Log::error('No broadcast entry found or contacts are missing.', ['broadcast_id' => $broadcastMessage->broadcast_id]);
            DB::rollBack();
            return;
        }

        $contacts = json_decode($broadcast->contact_id, true);
        $totalContacts = count($contacts);
        $timestamp = now()->format('Y-m-d H:i:s'); // Use full datetime format

        // Check for existing entry for the same date
        $existingEntry = DB::table('broadcast_history')
            ->where('broadcast_id', $broadcastMessage->broadcast_id)
            ->whereDate('created_at', now()->toDateString())
            ->first(); // Get the entry, not just check existence

        if ($existingEntry) {
            // Update existing broadcast history
            DB::table('broadcast_history')
                ->where('broadcast_id', $broadcastMessage->broadcast_id)
                ->whereDate('created_at', now()->toDateString())
                ->update([
                    'accepted' => $existingEntry->accepted + $acceptedCount, // Increment existing count
                    'rejected' => $existingEntry->rejected + $rejectedCount, // Increment existing count
                    'updated_at' => $timestamp,
                ]);

            Log::info('Broadcast history entry updated successfully.');
        } else {
            // Insert new broadcast history entry
            DB::table('broadcast_history')->insert([
                'broadcast_id' => $broadcastMessage->broadcast_id,
                'created_at' => $timestamp, // Use full datetime here
                'total_contacts' => $totalContacts,
                'accepted' => $acceptedCount, // Set initial count
                'rejected' => $rejectedCount, // Set initial count
                'is_read' => 0,
                'updated_at' => $timestamp,
            ]);

            Log::info('Broadcast history entry created successfully.');
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error in storing broadcast history: ' . $e->getMessage());
    }
}

public function destroy($broadcastId)
{
    DB::beginTransaction();

    try {
        // Retrieve the broadcast details to get the contact_id array
        $broadcast = DB::table('broadcast')->where('id', $broadcastId)->first();
        
        if (!$broadcast) {
            throw new \Exception('Broadcast not found.');
        }

        // Decode the contact_id array (assuming it's stored as a JSON array in the database)
        $contactIds = json_decode($broadcast->contact_id);

        // Delete related chats for the specific contacts
        DB::table('chats')
            ->whereIn('contact_id', $contactIds)
            ->delete();

        // Delete related broadcast messages
        DB::table('broadcast_messages')
            ->where('broadcast_id', $broadcastId)
            ->delete();

        // Finally, delete the broadcast itself
        DB::table('broadcast')->where('id', $broadcastId)->delete();

        DB::commit();

        session()->flash('success', 'Broadcast, related chats, and messages deleted successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error deleting broadcast:', ['error' => $e->getMessage()]);
        session()->flash('error', 'There was an error deleting the broadcast.');
    }

    return redirect()->route('broadcast.index');
}

}