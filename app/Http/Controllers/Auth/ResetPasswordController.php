<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Log;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for resetting the password.
     *
     * @param  string $token
     * @return \Illuminate\View\View
     */
    public function showResetForm($token)
    {
        return view('auth.passwords.reset')->with(['token' => $token]);
    }

    /**
     * Reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $response === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($response))
                    : back()->withErrors(['email' => __($response)]);
    }

    
    public function resetPassword(Request $request)
{
    Log::info('Password reset request received.');

    // Validate form input
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string',
    ]);

    // Get the currently logged-in user
    $user = Auth::user();

    Log::info('User found:', ['user_id' => $user->id]);

    // Check if the current password matches
    if (!Hash::check($request->current_password, $user->password)) {
        Log::error('Password reset attempt failed: Incorrect current password.', [
            'user_id' => $user->id,
            'email' => $user->email,
            'time' => now(),
        ]);

        return back()->with('error', 'Your current password is incorrect.');
    }

    // Update user's password
    $user->password = Hash::make($request->new_password);
    $user->save();

    Log::info('Password updated successfully for user.', [
        'user_id' => $user->id,
        'email' => $user->email,
        'time' => now(),
    ]);

    return back()->with('success', 'Your password has been updated successfully.');
}

}
