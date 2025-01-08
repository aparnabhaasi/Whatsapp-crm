<?php

namespace App\Providers;

use App\Models\Settings;
use Auth;
use Illuminate\Support\ServiceProvider;
use View;
use Log;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
{
    // Apply this view composer to the 'layout.header' and other views
    View::composer(['layout.header', 'front-end.index', 'front-end.profile'], function ($view) {
        // Fetch the authenticated user
        $user = Auth::user();

        if (!$user) {
            Log::error('No authenticated user found.');
            return; // Exit if no user is authenticated
        }

        // Fetch the settings for the authenticated user's app_id
        $settings = Settings::where('app_id', $user->app_id)->first();

        if (!$settings) {
            Log::error("Settings not found for app_id: {$user->app_id}");
            return; // Exit if settings are not found
        }

        $accessToken = $settings->access_token;
        $phoneNumberID = $settings->phone_number_id; // Use the phone_number_id from settings

        // Fetch WhatsApp profile picture
        $profilePictureUrl = $this->getWhatsAppProfilePicture($accessToken, $phoneNumberID);

        // Fetch WhatsApp phone details
        $phoneDetails = $this->getWhatsAppPhoneDetails($accessToken, $phoneNumberID);

        // Ensure phone details are available
        $verifiedName = $phoneDetails['verified_name'] ?? 'N/A';
        $displayPhoneNumber = $phoneDetails['display_phone_number'] ?? 'N/A';
        $qualityRating = $phoneDetails['quality_rating'] ?? 'N/A';
        $codeVerificationStatus = $phoneDetails['code_verification_status'] ?? 'N/A';

        // Share the data with the views
        $view->with('profile_picture_url', $profilePictureUrl);
        Log::info('Profile Picture URL: ' . $profilePictureUrl);

        $view->with('verified_name', $verifiedName);
        $view->with('display_phone_number', $displayPhoneNumber);
        $view->with('quality_rating', $qualityRating);
        $view->with('code_verification_status', $codeVerificationStatus);
    });
}

/**
 * Fetch WhatsApp profile picture
 */
private function getWhatsAppProfilePicture($accessToken, $phoneNumberID)
{
    $url = "https://graph.facebook.com/v21.0/{$phoneNumberID}/whatsapp_business_profile?fields=profile_picture_url";
    $client = new \GuzzleHttp\Client();

    try {
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (!empty($data['data']) && is_array($data['data'])) {
            $whatsappProfile = $data['data'][0];
            return $whatsappProfile['profile_picture_url'] ?? "assets/img/profile.jpg";
        } else {
            return '';
        }
    } catch (\Exception $e) {
        return '';
    }
}

    /**
     * Fetch WhatsApp phone details
     */
    private function getWhatsAppPhoneDetails($accessToken)
{
    // Fetch the settings for the authenticated user's app_id
    $user = Auth::user();
    if (!$user) {
        Log::error('No authenticated user found.');
        return [
            'verified_name' => '',
            'display_phone_number' => '',
            'quality_rating' => 'UNKNOWN',
            'code_verification_status' => ''
        ];
    }

    $settings = Settings::where('app_id', $user->app_id)->first();
    if (!$settings) {
        Log::error("Settings not found for app_id: {$user->app_id}");
        return [
            'verified_name' => '',
            'display_phone_number' => '',
            'quality_rating' => 'UNKNOWN',
            'code_verification_status' => ''
        ];
    }

    // Fetch the phone_number_id from the settings
    $phoneNumberID = $settings->phone_number_id;
    if (!$phoneNumberID) {
        Log::error("Phone number ID not found for app_id: {$user->app_id}");
        return [
            'verified_name' => '',
            'display_phone_number' => '',
            'quality_rating' => 'UNKNOWN',
            'code_verification_status' => ''
        ];
    }

    Log::info('Using phone_number_id: ' . $phoneNumberID);

    // Simplified API call to fetch WhatsApp phone details directly
    $url = "https://graph.facebook.com/v21.0/{$phoneNumberID}?fields=verified_name,display_phone_number,quality_rating,code_verification_status";
    $client = new \GuzzleHttp\Client();

    try {
        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        // Log the API response for debugging
        Log::info('API Response for phone details: ' . json_encode($data));

        // Return the necessary details
        return [
            'verified_name' => $data['verified_name'] ?? 'N/A',
            'display_phone_number' => $data['display_phone_number'] ?? 'N/A',
            'quality_rating' => $data['quality_rating'] ?? 'Unknown',
            'code_verification_status' => $data['code_verification_status'] ?? 'N/A',
        ];

    } catch (\Exception $e) {
        Log::error('Error fetching phone details: ' . $e->getMessage());
        return [
            'verified_name' => '',
            'display_phone_number' => '',
            'quality_rating' => 'UNKNOWN',
            'code_verification_status' => ''
        ];
    }
}




}
