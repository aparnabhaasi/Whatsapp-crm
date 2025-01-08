<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\TemplateLanguage;
use Http;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function index()
{
    try {
        // Get the authenticated user's app_id
        $authUserAppId = auth()->user()->app_id;

        // Fetch the settings from the database where the app_id matches the authenticated user's app_id
        $settings = Settings::where('app_id', $authUserAppId)->first();

        // If no matching settings are found, return an error
        if (!$settings) {
            return redirect()->back()->with('error', 'No settings found for your app_id. Contact support.');
        }

        $accessToken = $settings->access_token;
        $accountID = $settings->account_id;
        $phoneID = $settings->phone_id; // Assuming `phone_id` exists in the `settings` table

        // Set the limit for API results
        $limit = 300;
        $url = "https://graph.facebook.com/v21.0/{$accountID}/message_templates?limit={$limit}";

        $allTemplates = [];

        do {
            // Make the GET request to the WhatsApp Cloud API
            $response = Http::withHeaders(['Authorization' => "Bearer {$accessToken}"])->get($url);

            // Check if the request was successful
            if ($response->successful()) {
                $responseData = $response->json();
                $templates = $responseData['data'];

                // Add templates to the collection
                $allTemplates = array_merge($allTemplates, $templates);

                // Check if there's a 'next' link in the pagination
                $url = $responseData['paging']['next'] ?? null;
            } else {
                // Handle API error
                return redirect()->back()->with('error', 'Failed to fetch templates. Contact support.');
            }
        } while ($url); // Continue fetching if there are more pages

        // Filter templates to only include those with status 'APPROVED'
        $approvedTemplates = array_filter($allTemplates, function ($template) {
            return isset($template['status']) && $template['status'] === 'APPROVED';
        });

        // Return the view with settings, phone ID, and approved templates
        return view('front-end.template', [
            'templates' => $approvedTemplates,
            'settings' => $settings,
            'phoneID' => $phoneID,
        ]);

    } catch (\Exception $e) {
        Log::error('Error fetching WhatsApp template: ' . $e->getMessage(), [
            'exception' => $e,
        ]);

        return redirect()->back()->with('error', 'An error occurred while fetching the template. Contact support.');
    }
}




    public function destroy(Request $request, $id)
{
    try {
        // Fetch the authenticated user's app_id
        $user = Auth::user();
        $userAppID = $user->app_id;

        // Fetch settings with the same app_id as the user
        $settings = Settings::where('app_id', $userAppID)->first();

        // Check if matching settings were found
        if (!$settings) {
            return redirect()->back()->with('error', 'Settings not found for your app ID.');
        }

        // Fetch the access token and account ID
        $accessToken = $settings->access_token;
        $accountID = $settings->account_id;

        // Retrieve the template name from the request
        $templateName = $request->input('template_name');

        // Construct the URL to delete the template
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
        $metaAppId = $settings->meta_app_id;

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

        $languages = TemplateLanguage::all();

        return view('front-end.template-add', compact('languages'));
    }


    
    
    public function storeTemplate(Request $request) {
        Log::info('storeTemplate method called.');

        // Get the authenticated user's app_id
    $authUserAppId = auth()->user()->app_id;

    // Fetch the settings where app_id matches the authenticated user's app_id
    $settings = Settings::where('app_id', $authUserAppId)->first();
        $account_id = $settings->account_id;
        $meta_app_id = $settings->meta_app_id;

        // Collect form inputs
        $templateName = $request->input('template_name');
        $category = $request->input('category');
        $language = $request->input('language');
        $headerType = $request->input('header_type');
        $headerHandle = null; // Initialize header handle
        $bodyContent = $request->input('body');
        $footerContent = $request->input('footer') ?? '';
        $variables = $request->input('variables', []);
        $buttons = $request->input('buttons', []);

        // Log::info('Request input data:', $request->all());

        // Step 1: Handle the header content if it's an image, video, or document needing upload
        if ($request->hasFile('header_content')) {
            Log::info('Header content file detected.');

            // Retrieve the uploaded file
            $headerContent = $request->file('header_content');

            // Check if the file was uploaded and is valid
            if ($headerContent && $headerContent->isValid()) {
                Log::info('File is valid.', ['file' => $headerContent->getClientOriginalName()]);

                // Log media file details
                Log::info('Media file details:', [
                    'original_name' => $headerContent->getClientOriginalName(),
                    'size' => $headerContent->getSize(),
                    'mime_type' => $headerContent->getMimeType(),
                    'path' => $headerContent->getPathname() // Temporary path
                ]);

                // Store the file
                $mediaPath = $headerContent->store('new_template_media', 'public');
                $filePath = public_path('storage/' . $mediaPath);
                $fileName = basename($filePath);
                $fileSize = filesize($filePath);
                $fileType = mime_content_type($filePath);

                // Log file details before upload
                Log::info('Preparing to upload file.', [
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'file_type' => $fileType,
                ]);

                // Create an upload session to get the upload ID
                $uploadResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $settings->access_token
                ])->post("https://graph.facebook.com/v21.0/{$meta_app_id}/uploads", [
                    'file_name' => $fileName,
                    'file_length' => $fileSize,
                    'file_type' => $fileType
                ]);

                // Log the status code and the response body
                Log::info('Upload session response status.', [
                    'status_code' => $uploadResponse->status(),
                    'response' => $uploadResponse->json(),
                ]);

                // Check for successful upload session creation
                if ($uploadResponse->successful()) {
                    $uploadId = $uploadResponse->json('id');

                    // Create the upload URL
                    $uploadUrl = "https://graph.facebook.com/v20.0/{$uploadId}";
                    Log::info('Upload URL created.', ['upload_url' => $uploadUrl]);

                    // Step 2: Upload the file binary content
                    $fileContent = fopen($filePath, 'r');

                    // Log before file upload
                    Log::info('Uploading file content.', ['upload_url' => $uploadUrl]);

                    $fileUploadResponse = Http::withHeaders([
                        'Authorization' => 'OAuth ' . $settings->access_token,
                        'Content-Type' => $fileType
                    ])->withBody(stream_get_contents($fileContent), $fileType)->post($uploadUrl);

                    fclose($fileContent); // Close the file handle

                    // Log file upload status
                    if ($fileUploadResponse->successful()) {
                        $headerHandle = $fileUploadResponse->json('h');
                        Log::info('File uploaded successfully.', ['handle' => $headerHandle]);
                    } else {
                        Log::error('File upload failed', ['error' => $fileUploadResponse->json()]);
                        return redirect()->back()->with('error', 'Failed to upload header content.');
                    }
                } else {
                    Log::error('Upload session creation failed', ['error' => $uploadResponse->json()]);
                    return redirect()->back()->with('error', 'Failed to create upload session.');
                }
            } else {
                Log::error('Uploaded file is not valid.', [
                    'file' => $headerContent,
                    'has_file' => $request->hasFile('header_content'),
                    'error' => $headerContent ? $headerContent->getError() : 'No file uploaded.'
                ]);
                return redirect()->back()->with('error', 'Uploaded file is not valid.');
            }
        } else {
            Log::warning('No header content file uploaded.');
        }

        // Step 3: Filter and structure buttons
        $structuredButtons = array_map(function ($button) {
            $formattedButton = [
                'type' => $button['type'],
                'text' => $button['text'],
            ];
            if ($button['type'] === 'URL') {
                $formattedButton['url'] = $button['url'];
            } elseif ($button['type'] === 'PHONE_NUMBER') {
                $formattedButton['phone_number'] = $button['phone'];
            }
            return $formattedButton;
        }, array_filter($buttons, function($button) {
            return !empty($button['type']) && (isset($button['text']) || isset($button['url']) || isset($button['phone']));
        }));

        // Log the structured buttons
        Log::info('Structured buttons:', ['structuredButtons' => $structuredButtons]);


        // Prepare the template data
        $templateData = [
            'name' => $templateName,
            'language' => $language,
            'category' => $category,
            'components' => []
        ];

        // Step 1: Add header component if required
        if ($headerHandle) {
            $templateData['components'][] = [
                'type' => 'HEADER',
                'format' => $headerType,
                'example' => [
                    'header_handle' => [$headerHandle]
                ]
            ];
        }

        // Step 2: Add the body component with conditional variables
        $bodyComponent = [
            'type' => 'BODY',
            'text' => $bodyContent,
        ];

        if (!empty($variables)) {
            $bodyComponent['example'] = [
                'body_text' => $variables
            ];
        }
        
        $templateData['components'][] = $bodyComponent;

        // Step 3: Add the footer component if present
        if (!empty($footerContent)) {
            $templateData['components'][] = [
                'type' => 'FOOTER',
                'text' => $footerContent
            ];
        }

        // Step 4: Add the buttons if present
        if (!empty($structuredButtons)) {
            $templateData['components'][] = [
                'type' => 'BUTTONS',
                'buttons' => $structuredButtons
            ];
        }


        // Step 4: Send the template data to WhatsApp API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $settings->access_token
        ])->post("https://graph.facebook.com/v21.0/{$account_id}/message_templates", $templateData);

        
        // Step 5: Check for success or failure and log responses
        if ($response->successful()) {
            Log::info('Template submitted successfully.', ['response' => $response->json()]);
            return redirect()->back()->with('success', 'Template submitted successfully.');
        } else {
            Log::error('Failed to submit the template.', ['error' => $response->json()]);

            // Extract the full error response
            $errorResponse = $response->json();

            // Default error message
            $errorMessage = 'Failed to submit the template.';

            // Log the full error response to inspect the structure
            Log::debug('Error response structure:', ['errorResponse' => $errorResponse]);

            // Check if "error" is directly in the response, if not, check inside "errorResponse"
            if (isset($errorResponse['error'])) {
                $nestedError = $errorResponse['error'];

                if (isset($nestedError['message'])) {
                    $errorMessage = $nestedError['message'];
                    Log::info('Found "message" in error response.', ['message' => $errorMessage]);
                } else {
                    Log::warning('"message" not found in error response.');
                }

                if (isset($nestedError['error_user_title'])) {
                    $errorMessage .= ' - ' . $nestedError['error_user_title'];
                    Log::info('Found "error_user_title" in error response.', ['error_user_title' => $nestedError['error_user_title']]);
                } else {
                    Log::warning('"error_user_title" not found in error response.');
                }

                if (isset($nestedError['error_user_msg'])) {
                    $errorMessage .= ': ' . $nestedError['error_user_msg'];
                    Log::info('Found "error_user_msg" in error response.', ['error_user_msg' => $nestedError['error_user_msg']]);
                } else {
                    Log::warning('"error_user_msg" not found in error response.');
                }
            } elseif (isset($errorResponse['errorResponse']['error'])) {
                $nestedError = $errorResponse['errorResponse']['error'];

                if (isset($nestedError['message'])) {
                    $errorMessage = $nestedError['message'];
                    Log::info('Found "message" in error response.', ['message' => $errorMessage]);
                } else {
                    Log::warning('"message" not found in error response.');
                }

                if (isset($nestedError['error_user_title'])) {
                    $errorMessage .= ' - ' . $nestedError['error_user_title'];
                    Log::info('Found "error_user_title" in error response.', ['error_user_title' => $nestedError['error_user_title']]);
                } else {
                    Log::warning('"error_user_title" not found in error response.');
                }

                if (isset($nestedError['error_user_msg'])) {
                    $errorMessage .= ': ' . $nestedError['error_user_msg'];
                    Log::info('Found "error_user_msg" in error response.', ['error_user_msg' => $nestedError['error_user_msg']]);
                } else {
                    Log::warning('"error_user_msg" not found in error response.');
                }
            } else {
                Log::warning('"error" key not found in error response.');
            }

            return redirect()->back()->with('error', $errorMessage);
        }

    }


}
