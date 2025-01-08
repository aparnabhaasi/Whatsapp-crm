<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Log;

class SuperadminController extends Controller
{
    public function viewAdminLogin(){
        return view('super-admin.login');
    }

    public function viewDashboard(){

        $users = User::where('role', 'admin')->get();

        $ticketCount = Ticket::where('status', 'true')->count();

        // Get all users (admin and non-admin) and group them by app_id
        $userGroups = User::groupBy('app_id')->select('app_id', DB::raw('count(*) as total'))->get();

        return view('super-admin.index', compact('users', 'userGroups', 'ticketCount'));
    }
public function userRequests(){

        $users = User::where('role', '!=', 'admin')->get();
        $ticketCount = Ticket::where('status', 'true')->count();

        // Get all users (admin and non-admin) and group them by app_id
        $userGroups = User::groupBy('app_id')->select('app_id', DB::raw('count(*) as total'))->get();
        return view('super-admin.users', compact('users', 'userGroups', 'ticketCount'));
    }
    
    public function superAdminLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('superadmin')->attempt($credentials)) {
        return redirect()->intended('superadmin/dashboard');
    }

    // Log the error for debugging
    Log::error('Super admin login failed', [
        'email' => $request->email,
        'reason' => 'Invalid credentials or user is not a super admin',
    ]);

    return redirect()->route('superadmin.login')->withErrors([
        'email' => 'Invalid credentials or you are not a super admin.',
    ]);
}

    
    public function logout(){
        Auth::guard('superadmin')->logout();
        return redirect()->route('superadmin.login');
    }


    public function updatePaymentStatus($id, Request $request){
        // find the user by id
        $user = User::find($id);

        if($user){

            if($user->payment_date == 'pending') {
                
                $user->payment_date = Carbon::now();
            
            } else {

                $user->payment_date = 'pending';
            }

            $user->save();
            Log::info('User payment date updated', ['user_id' => $user->id, 'payment_date' => $user->payment_date]);
            return response()->json(['status' => 'success', 'payment_date' => $user->payment_date ]);

        }

        Log::error('User not found', ['user_id' => $id]);

        return response()->json(['status' => 'error', 'message' => 'User not found', 404]);
    }

    public function updateStatus(Request $request)
    {
        try {
            // Find the user by user_id
            $user = User::find($request->user_id);
    
            if ($user) {
                // Get the app_id of the user
                $app_id = $user->app_id;
    
                // Update the status for all users with the same app_id
                User::where('app_id', $app_id)->update(['status' => $request->status]);
    
                return response()->json(['message' => 'Status updated for all users with app_id ' . $app_id], 200);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Exception $e) {
            // Log the error with the exception message
            Log::error('Error updating status: ' . $e->getMessage(), [
                'user_id' => $request->user_id,
                'status' => $request->status,
            ]);
    
            // Return an error response
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }


    public function deleteUser($id){

        $user = User::find($id);

        if($user){

            $app_id = $user->app_id;

            User::where('app_id', $app_id)->delete();

            return redirect()->route('superadmin.dashboard')->with('success', 'User deleted successfully');
        }

        return redirect()->back()->with('error', 'User not found');
    }

}
