<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Http;
use Illuminate\Http\Request;
use Log;

class TemplateController extends Controller
{
    public function index(){
        try {
            // Fetch the access token from the settings table
            $settings = Settings::first();
            $accessToken = $settings->access_token;

            // Fetch WhatsApp Business account ID
            $accountID = $settings->account_id;

            // Set the limit to a higher value, or handle pagination
            $limit = 300; 
            $url = "https://graph.facebook.com/v20.0/{$accountID}/message_templates?limit={$limit}";

            $allTemplates = [];

            do {
                // Make the GET request to the WhatsApp Cloud API
                $response = Http::withHeaders([ 'Authorization' => "Bearer {$accessToken}" ])->get($url);

                // Check if the request was successful
                if ($response->successful()) {
                    $responseData = $response->json();
                    $templates = $responseData['data'];

                    // Add templates to the collection
                    $allTemplates = array_merge($allTemplates, $templates);

                    // Check if there's a 'next' link in the pagination
                    $url = $responseData['paging']['next'] ?? null;
                } else {
                    return redirect()->back()->with('error', 'Failed to fetch templates. Contact support');
                }
            } while ($url); // Continue fetching if there are more pages

            // Return the view with all templates
            return view('front-end.template', ['templates' => $allTemplates]);

        } catch(\Exception $e) {
            Log::error('Error fetching WhatsApp template: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->back()->with('error', 'An error occurred while fetching the template. Contact support');
        }
    }


    public function destroy(Request $request, $id)
{
    try {
        // Fetch settings
        $settings = Settings::first();

        // Fetch the access token and account ID
        $accessToken = $settings->access_token;
        $accountID = $settings->account_id;

        // Retrieve the template name from the request
        $templateName = $request->input('template_name');

        // Construct the URL to delete the template (using hsm_id for illustration)
        $url = "https://graph.facebook.com/v20.0/{$accountID}/message_templates?hsm_id={$id}&name={$templateName}";

        // Make the DELETE request to the WhatsApp Cloud API
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}"
        ])->delete($url);

        // Log the response for debugging
        Log::info('Delete template response', [
            'url' => $url,
            'response_status' => $response->status(),
            'response_body' => $response->body(),
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Template deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete the template. Please contact support.');
        }
    } catch (\Exception $e) {
        Log::error('Error deleting WhatsApp template: ' . $e->getMessage(), [
            'exception' => $e,
        ]);

        return redirect()->back()->with('error', 'An error occurred while deleting the template. Please contact support.');
    }
}


    private function findTemplateById($id)
    {
        Log::info('Finding template by ID:', ['id' => $id]);
        // Fetch the templates again or store them in session/cache for reuse
        $settings = Settings::first();
        $accessToken = $settings->access_token;
        $accountID = $settings->account_id;

        $url = "https://graph.facebook.com/v20.0/{$accountID}/message_templates?hsm_id={$id}";
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}"
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData['data'][0] ?? null; 
        }

        return null;
    }



    public function add_template_view(){
        return view('front-end.template-add');
    }
}
