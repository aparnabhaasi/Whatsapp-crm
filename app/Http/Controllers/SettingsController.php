<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;
use Log;

class SettingsController extends Controller
{
    public function index(){
        $settings = Settings::first();
        return view('front-end.settings', compact('settings'));
    }


    public function update(Request $request, $id){

        // validate data
        $validateData = $request->validate([
            'account_id' => 'string|required',
            'phone_number_id' => 'string|required',
            'phone_number' => 'string|required',
            'access_token' => 'string|required',

        ]);

        try{

            $settings = Settings::findOrFail($id);

            $settings -> account_id = $validateData['account_id'];
            $settings -> phone_number_id = $validateData['phone_number_id'];
            $settings -> phone_number = $validateData['phone_number'];
            $settings -> access_token = $validateData['access_token'];

            $settings ->save();

            return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
        } catch(Exception $e){
            Log::error('An error occured while updating settings',[
                "error message:" => $e ->getMessage(),
            ]);

            return redirect()->back()->with('Error', 'An error occured while updating the settings');
        }
    }
}
