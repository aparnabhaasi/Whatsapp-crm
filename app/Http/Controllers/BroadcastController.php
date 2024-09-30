<?php

namespace App\Http\Controllers;

use App\Models\Broadcast_messages;
use App\Models\Broadcasts;
use App\Models\Contacts;
use App\Models\Settings;
use Http;
use Illuminate\Http\Request;
use Log;

class BroadcastController extends Controller
{
   public function index()
   {
       // Fetch contacts and broadcasts
       $contacts = Contacts::all();
       $broadcasts = Broadcasts::all();

       // Fetch templates using WhatsApp Cloud API
       $settings = Settings::first();
       $accessToken = $settings->access_token;
       $accountID = $settings->account_id;
       $limit = 300;
       $url = "https://graph.facebook.com/v20.0/{$accountID}/message_templates?limit={$limit}";

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
               Log::error('Failed to fetch templates from WhatsApp Cloud API.');
           }
       } while ($url);

       // Return view with contacts, broadcasts, and templates
       return view('front-end.broadcast', compact('contacts', 'broadcasts', 'allTemplates'));
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

    // Access the variables array
    $variables = $validateData['variables'] ?? [];

    // Check if media is uploaded
    if ($request->hasFile('media')) {
        $mediaPath = $request->file('media')->store('template_media', 'public');
    } else {
        $mediaPath = null; // Set to null if no media file is uploaded
    }

    try {
        // Store the broadcast message
        $broadcastMessage = new Broadcast_messages();
        $broadcastMessage->broadcast_id = $validateData['broadcast_group'];
        $broadcastMessage->template_id = $validateData['message_template'];
        $broadcastMessage->media = $mediaPath;

        // Store variables in the body content
        $broadcastMessage->body_content = json_encode($variables); 

        // Set the coupon code, safely handling its absence
        $couponCode = $validateData['coupon_code'] ?? null;
        $broadcastMessage->button_content = $couponCode ? json_encode([$couponCode]) : json_encode([]);

        $broadcastMessage->save();

        // Fetch the broadcast group details
        $broadcast = Broadcasts::find($validateData['broadcast_group']);

        // Fetch the contacts in the broadcast group
        $contacts = Contacts::whereIn('id', $broadcast->contact_id)->get();

        // Fetch WhatsApp API settings
        $settings = Settings::first();
        $whatsappApiToken = $settings->access_token;
        $whatsappPhoneNumberId = $settings->phone_number_id;

        // Fetch the template details using the WhatsApp Cloud API
        $templateResponse = Http::withToken($whatsappApiToken)
            ->get("https://graph.facebook.com/v13.0/{$validateData['message_template']}");

        if ($templateResponse->failed()) {
            return redirect()->back()->with('error', 'Failed to fetch template details. Please check the template ID.');
        }

        $templateDetails = $templateResponse->json();

        // Iterate through contacts and send messages
        foreach ($contacts as $contact) {
            $this->sendWhatsAppMessage($whatsappApiToken, $whatsappPhoneNumberId, $contact->mobile, $templateDetails, asset("storage/{$mediaPath}"), $couponCode, $variables);
        }

        return redirect()->back()->with('success', 'Broadcast message sent successfully.');

    } catch (\Exception $e) {
        Log::error('Error storing broadcast message: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error in storing broadcast. Contact support!');
    }
}



protected function sendWhatsAppMessage($whatsappApiToken, $whatsappPhoneNumberId, $mobile, $templateDetails, $mediaUrl, $couponCode = null, $variables = null)
{
    try {
        // Log full request details
        Log::info('Request data: ', [
            'whatsappApiToken' => $whatsappApiToken,
            'whatsappPhoneNumberId' => $whatsappPhoneNumberId,
            'mobile' => $mobile,
            'templateDetails' => $templateDetails,
            'mediaUrl' => $mediaUrl,
            'couponCode' => $couponCode,
            'variables' => $variables,
        ]);

        // Construct the message payload
        $components = [];


        // Iterate through components to construct message components based on type
        foreach ($templateDetails['components'] as $component) {
            if ($component['type'] === 'BODY' && !empty($variables)) {
                // Check expected number of parameters from the template
                $expectedParamsCount = substr_count($component['text'], '{{'); // Count placeholders in the template text
                $actualParamsCount = count($variables);

                // Log for debugging purposes
                Log::info('Expected params count: ' . $expectedParamsCount . ', Actual params count: ' . $actualParamsCount);

                if ($actualParamsCount !== $expectedParamsCount) {
                    Log::error("Mismatch in parameters: expected {$expectedParamsCount}, got {$actualParamsCount}");
                    return; // Stop execution if parameter counts do not match
                }

                // Map each variable to the correct format
                $parameters = array_map(function ($variable) {
                    return [
                        'type' => 'text',
                        'text' => $variable,
                    ];
                }, $variables);

                // Add the body component with the mapped parameters
                $components[] = [
                    'type' => 'body',
                    'parameters' => $parameters,
                ];
            }

            // Handle HEADER type components
            if ($component['type'] === 'HEADER' && isset($component['format'])) {
                $headerType = strtolower($component['format']);
                Log::info('Header Type: ' . $headerType);

                if (in_array($headerType, ['image', 'video', 'document'])) {
                    $components[] = [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => $headerType,
                                $headerType => [
                                    'link' => $mediaUrl,
                                ],
                            ],
                        ],
                    ];
                } else {
                    Log::error("Unexpected header type: {$component['format']}");
                }
            }

            // Handle BUTTON type and COPY_CODE specifically
            if ($component['type'] === 'BUTTONS') {
                Log::info('Buttons component found');
                foreach ($component['buttons'] as $index => $button) {
                    Log::info("Button type: {$button['type']}, index: {$index}");
                    if ($button['type'] === 'COPY_CODE') {
                        if (!empty($couponCode)) {
                            $components[] = [
                                'type' => 'button',
                                'sub_type' => 'copy_code',
                                'index' => $index,
                                'parameters' => [
                                    [
                                        'type' => 'coupon_code',
                                        'coupon_code' => $couponCode, // Set the coupon code
                                    ],
                                ],
                            ];
                        } else {
                            Log::error("Coupon code is empty for COPY_CODE button.");
                        }
                    }
                }
            }

            
        }

        // Send the message
        $response = Http::withToken($whatsappApiToken)
            ->post("https://graph.facebook.com/v13.0/{$whatsappPhoneNumberId}/messages", [
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
            ]);

        // Log the response if needed
        Log::info('WhatsApp message response: ', ['response' => $response->json()]);

        if ($response->failed()) {
            Log::error("Failed to send message to {$mobile}: " . $response->body());
        }

    } catch (\Exception $e) {
        Log::error('Error sending WhatsApp message: ' . $e->getMessage());
    }
}


}