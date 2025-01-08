<?php

namespace App\Http\Controllers;

use App\Models\Broadcast_messages;
use App\Models\BroadcastHistory;
use App\Models\Broadcasts;
use App\Models\Chats;
use App\Models\Contacts;
use App\Models\Settings;
use App\Models\User;
use Auth;
use DB;
use GrahamCampbell\ResultType\Success;
use GuzzleHttp\Client;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Log;

class AdminController extends Controller
{

    public function viewDashboard()
{
   // Get the authenticated user's app_id
$userAppId = Auth::user()->app_id; // Ensure this is defined before usage

// Count chats
$countChats = Chats::where('is_read', false)
    ->distinct('contact_id')
    ->count('contact_id');

// Count contacts where app_id matches the authenticated user's app_id
$contctCount = Contacts::where('app_id', $userAppId)->count();

 // Retrieve the contact_ids for the authenticated user (app_id)
    $userContacts = Contacts::where('app_id', $userAppId)->pluck('id'); // Fetch all contact_ids for the user

    // Count broadcasts where the contact_id array contains the user's contacts
    $broadcastCount = Broadcasts::where(function ($query) use ($userContacts) {
        foreach ($userContacts as $contactId) {
            $query->orWhereJsonContains('contact_id', (string)$contactId); // Check if any contact_id in the broadcast contains the user contact_id
        }
    })->count(); // Count broadcasts where at least one contact_id matches



// Retrieve the settings where app_id matches the authenticated user's app_id
$settings = Settings::where('app_id', $userAppId)->first(); // Use first() to get a single record

if (!$settings) {
        return redirect()->route('settings.index')->with('error', 'Please configure your settings to access the dashboard.');
    }
    

$accessToken = $settings->access_token;
$accountID = $settings->account_id;

// Query to get the last broadcast history where contact_id in the Broadcast table contains the user's app_id
// Fetch the last broadcast history corresponding to the user's app_id
    // Fetch the last broadcast history
$lastBroadcast = BroadcastHistory::latest()->first();

Log::info('Last Broadcast Query:', ['lastBroadcast' => $lastBroadcast]);


// Set default values if there is no broadcast history
$totalContacts = $lastBroadcast ? $lastBroadcast->total_contacts : 0;
$acceptedCount = $lastBroadcast ? $lastBroadcast->accepted : 0;
$rejectedCount = $lastBroadcast ? $lastBroadcast->rejected : 0;
$sentDate = $lastBroadcast ? \Carbon\Carbon::parse($lastBroadcast->created_at)->format('d-m-Y, h:i A') : 'N/A';

$url = "https://graph.facebook.com/v20.0/{$accountID}/message_templates";

$allTemplates = [];
$templateCount = 0; // Initialize template count
$isTemplateCountFetched = true; // Flag for successful fetch

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

        // Update the template count
        $templateCount += count($templates);

        // Check if there's a 'next' link in the pagination
        $url = $responseData['paging']['next'] ?? null;
    } else {
        Log::error('Failed to fetch templates from WhatsApp Cloud API.');
        $isTemplateCountFetched = false; // Mark as not fetched
        break; // Exit loop if request failed
    }
} while ($url);



    // Return view with counts and fetch status
    return view('front-end.index', compact('contctCount', 'countChats', 'broadcastCount', 'templateCount', 'isTemplateCountFetched', 'totalContacts', 'acceptedCount', 'rejectedCount', 'sentDate'));
}

public function privacy(){
        return view('front-end.privacy');
    }
    public function terms(){
        return view('front-end.terms');
    }

    public function getUnreadMessagesCount()
    {
        $unreadCount = DB::table('chats')
                        ->where('is_read', false)
                        ->distinct('contact_id')
                        ->count('contact_id');
                        
        return response()->json(['unreadCount' => $unreadCount]);
    }




    public function showProfile()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch settings where app_id matches the authenticated user's app_id
        $settings = Settings::where('app_id', $user->app_id)->first();

        // If no settings found, return an error
        if (!$settings) {
            return back()->withError('No settings found for your app_id.');
        }

        // Get the access token from the settings
        $accessToken = $settings->access_token;

        // Ensure phone_id exists in settings
        if (empty($settings->phone_number_id)) {
            return back()->withError('Phone ID not found in settings.');
        }

        // The URL to get the WhatsApp Business profile details
        $url = "https://graph.facebook.com/v21.0/{$settings->phone_number_id}/whatsapp_business_profile?fields=about,description,profile_picture_url,websites";



        // Create a new Guzzle client
        $client = new \GuzzleHttp\Client();

        try {
            // Make the request to the API
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ]);

            // Parse the response
            $data = json_decode($response->getBody(), true);

            // Check if 'data' array is present and has at least one element
            if (!empty($data['data']) && is_array($data['data'])) {
                // Access the first item in the 'data' array
                $whatsappProfile = $data['data'][0];

                // Log the response data for debugging
                Log::info('WhatsApp profile data fetched:', $whatsappProfile);

                // Share the profile picture URL globally to all views (including the layout)
                view()->share('profile_picture_url', $whatsappProfile['profile_picture_url'] ?? '');

                // Pass the data to the profile view along with the authenticated user
                return view('front-end.profile', [
                    'user' => $user,
                    'about' => $whatsappProfile['about'] ?? '',
                    'description' => $whatsappProfile['description'] ?? '',
                    'websites' => $whatsappProfile['websites'][0] ?? '', // If there's only one website
                    'profile_picture_url' => $whatsappProfile['profile_picture_url'] ?? ''
                ]);
            } else {
                return back()->withError('Failed to retrieve WhatsApp profile: No profile data found.');
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to retrieve WhatsApp profile: ' . $e->getMessage());

            return back()->withError('Failed to retrieve WhatsApp profile: ' . $e->getMessage());
        }
    }



// update profile picture
public function updateProfile(Request $request)
{
    // Step 1: Validate Data
    $validateData = $request->validate([
        'profile_picture' => 'nullable|mimes:jpg,jpeg,png|max:2048', // limit file size to 2MB
        'about' => 'nullable|string',
        'description' => 'nullable|string',
        'website' => 'nullable|string'
    ]);

    // Retrieve settings where app_id matches the authenticated user's app_id
$settings = \DB::table('settings')
    ->where('app_id', auth()->user()->app_id)  // Ensure app_id matches the authenticated user's app_id
    ->first();

    $app_id = $settings->meta_app_id;
    $access_token = $settings->access_token;
    $phone_number_id = $settings->phone_number_id;

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $file_name = $file->getClientOriginalName();
        $file_length = $file->getSize();
        $file_type = $file->getMimeType();

        try {
            // Step 2: Initiate file upload to get upload session ID
            $initResponse = Http::post("https://graph.facebook.com/v21.0/{$app_id}/uploads", [
                'file_name' => $file_name,
                'file_length' => $file_length,
                'file_type' => $file_type,
                'access_token' => $access_token
            ]);

            Log::info('File upload initiation response:', $initResponse->json());

            $uploadSessionId = $initResponse->json('id');
            if (!$uploadSessionId) {
                Log::error('Failed to initialize file upload: No upload session ID received');
                return redirect()->back()->with('error', 'Failed to initialize file upload');
            }

            // Step 3: Start uploading the file
            try {
                // Create the upload URL using the retrieved upload session ID
                $uploadUrl = "https://graph.facebook.com/v21.0/{$uploadSessionId}";
                Log::info('Upload URL created.', ['upload_url' => $uploadUrl]);

                // Open the file stream for binary data
                $fileContent = fopen($file->getPathname(), 'r');
                Log::info('Preparing to upload file content.');

                // Upload the file binary content
                $uploadResponse = Http::withHeaders([
                    'Authorization' => 'OAuth ' . $access_token,
                    'Content-Type' => $file_type,
                    'file_offset' => 0
                ])->withBody(stream_get_contents($fileContent), $file_type)
                ->post($uploadUrl);

                // Close the file handle after upload attempt
                fclose($fileContent);

                // Check if upload was successful and retrieve the file handle
                if ($uploadResponse->successful()) {
                    $fileHandle = $uploadResponse->json('h');
                    Log::info('File uploaded successfully.', ['handle' => $fileHandle]);

                    if (!$fileHandle) {
                        Log::error('Failed to retrieve file handle after successful upload.');
                        return redirect()->back()->with('error', 'File handle not received');
                    }
                } else {
                    // Log the full error message if upload fails
                    Log::error('File upload failed', ['response' => $uploadResponse->json()]);
                    return redirect()->back()->with('error', 'Failed to upload file');
                }

            } catch (\Exception $e) {
                Log::error('Exception occurred during file upload:', ['message' => $e->getMessage()]);
                return redirect()->back()->with('error', 'An error occurred during file upload');
            }


            // Step 4: Update WhatsApp Business profile with uploaded file handle and other details
            $profileUpdateResponse = Http::withHeaders([
                'Authorization' => "Bearer {$access_token}",
                'Content-Type' => 'application/json'
            ])->post("https://graph.facebook.com/v21.0/{$phone_number_id}/whatsapp_business_profile", [
                'messaging_product' => 'whatsapp',
                'about' => $validateData['about'] ?? '',
                'description' => $validateData['description'] ?? '',
                'websites' => [$validateData['website'] ?? ''],
                'profile_picture_handle' => $fileHandle
            ]);

            Log::info('Profile update response:', $profileUpdateResponse->json());

            if ($profileUpdateResponse->failed()) {
                Log::error('Failed to update WhatsApp profile:', $profileUpdateResponse->json());
                return redirect()->back()->with('error', 'Failed to update WhatsApp profile');
            }
            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            Log::error("Exception during profile update: {$e->getMessage()}");
            return redirect()->back()->with('error', 'An error occurred while updating the profile');
        }
    }

    // If no profile picture is provided, update only text details in WhatsApp profile
    try {
        $profileUpdateResponse = Http::withHeaders([
            'Authorization' => "Bearer {$access_token}",
            'Content-Type' => 'application/json'
        ])->post("https://graph.facebook.com/v21.0/{$phone_number_id}/whatsapp_business_profile", [
            'messaging_product' => 'whatsapp',
            'about' => $validateData['about'] ?? '',
            'description' => $validateData['description'] ?? '',
            'websites' => [$validateData['website'] ?? '']
        ]);

        Log::info('Profile update response (text only):', $profileUpdateResponse->json());

        if ($profileUpdateResponse->failed()) {
            Log::error('Failed to update WhatsApp profile:', $profileUpdateResponse->json());
            return redirect()->back()->with('error', 'Failed to update WhatsApp profile');
        }
        return redirect()->back()->with('success', 'Profile updated successfully');
    } catch (\Exception $e) {
        Log::error("Exception during text-only profile update: {$e->getMessage()}");
        return redirect()->back()->with('error', 'An error occurred while updating the profile');
    }
}









    public function view_privacy_policy(){
        return view('front-end.privacy-policy');
    }

    public function login(){
        return view('front-end.login');
    }

    public function viewRegister(){
        return view('front-end.register');
    }


    public function updateBasicDetails(Request $request){
        // validate date
        $validateData = $request->validate([
            'name' => 'string|nullable',
            'email' => 'email|nullable',
            'mobile' => 'string|nullable',
        ]);

        $user = Auth::user();

        $user-> name = $validateData['name'];
        $user-> mobile = $validateData['mobile'];
        $user-> email = $validateData['email'];

        $user->save();

        return redirect()->back()->with('success', 'Basic details updated successfully!');
    }


    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Check if the user exists and their status
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            if ($user->status === 'inactive') {
                Log::info('Login attempt failed: User account inactive for email: ' . $credentials['email']);
                return redirect()->back()->withErrors(['loginError' => 'Your application is not activated, contact support.'])->withInput($request->only('email'));
            }

            // Attempt to log the user in if the status is active
            if (Auth::attempt($credentials)) {
                Log::info("User logged in successfully: " . Auth::user()->email);
                return redirect()->route('/');
            } else {
                Log::info('Login attempt failed for user: ' . $credentials['email']);
                return redirect()->back()->withErrors(['loginError' => 'Incorrect email or password'])->withInput($request->only('email'));
            }
        } else {
            Log::info('Login attempt failed: User not found with email: ' . $credentials['email']);
            return redirect()->back()->withErrors(['loginError' => 'Incorrect email or password'])->withInput($request->only('email'));
        }
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }


    // Register
    public function register(Request $request){
        // validate data
        $validateData = $request->validate([
            'name' => 'string|required',
            'mobile' => 'string|required',
            'email' => 'string|required|email',
            'password' => 'string|required',
        ]);

        // last inserted app id
        $lastUser = User::orderBy('id', 'desc')->first();

        if($lastUser) {
            $lastAppId = $lastUser->app_id;

            $newAppIdNumber = (int)substr($lastAppId, -4) + 1;

            $newAppID = 'ICTWCRM' . str_pad($newAppIdNumber, 4, '0', STR_PAD_LEFT);
        } else {
            $newAppID = 'ICTWCRM1001';
        }


        // new instrance for user
        $user = new User();
        $user -> name = $validateData['name'];
        $user -> email = $validateData['email'];
        $user -> mobile = $validateData['mobile'];
        $user -> password = Hash::make($validateData['password']);
        $user -> app_id = $newAppID;
        $user -> payment_date = 'pending';
        $user -> role = 'admin';
        $user -> status = 'inactive';

        $user -> save();

        return redirect()->back()->with('success', 'Your details are under review. Our team will contact you soon!');
    }


}