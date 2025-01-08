<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;
use Log;

class SettingsController extends Controller
{
    public function index()
{
    $authAppId = auth()->user()->app_id; // Get the authenticated user's app_id
    $settings = Settings::where('app_id', $authAppId)->first(); // Fetch the settings where app_id matches
    return view('front-end.settings', compact('settings'));
}



    public function update(Request $request, $id)
{
    // Validate data
    $validateData = $request->validate([
        'account_id' => 'string|required',
        'phone_number_id' => 'string|required',
        'phone_number' => 'string|required',
        'access_token' => 'string|required',
        'meta_app_id' => 'string|required'
    ]);

    try {
        // Get the authenticated user's app_id
        $authAppId = auth()->user()->app_id;

        // Find the setting where ID matches and app_id matches the auth user's app_id
        $settings = Settings::where('id', $id)
            ->where('app_id', $authAppId)
            ->first();

        if ($settings) {
            // Update existing record
            $settings->update($validateData);
            $message = 'Settings updated successfully!';
        } else {
            // Create a new record if no setting found
            Settings::create(array_merge($validateData, ['app_id' => $authAppId]));
            $message = 'Settings created successfully!';
        }

        return redirect()->route('settings.index')->with('success', $message);
    } catch (Exception $e) {
        Log::error('An error occurred while updating or creating settings', [
            "error_message" => $e->getMessage(),
        ]);

        return redirect()->back()->with('error', 'An error occurred while updating or creating the settings.');
    }
}
}
