<?php

namespace App\Http\Controllers;

use App\Models\AssignedContat;
use App\Models\Contacts;
use App\Models\User;
use Hash;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){

        $app_id = Auth::user()->app_id;

        $users = User::where('app_id', $app_id)->where(function (Builder $query){
                            $query->whereJsonLength('role','>',0);
                        })->get();

        $contacts = Contacts::all();

        return view('front-end.users', compact('users', 'contacts'));
    }


    public function storeUser(Request $request) {
        // Validate the data
        $validateData = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|email',
            'password' => 'string|required|confirmed', // Password confirmation validation
            'roles' => 'required|array', // Validate roles as an array
        ]);
    
        // Get the currently authenticated admin
        $admin = Auth::user();
    
        // Create a new instance of User
        $user = new User();
        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        $user->mobile = null;
        $user->password = Hash::make($validateData['password']);
        $user->app_id = $admin->app_id;
        $user->payment_date = null;
    
        $user->role = json_encode($validateData['roles']); 
    
        $user->status = $admin->status;
    
        $user->save();
    
        return redirect()->back()->with('success', 'User created successfully');
    }


    public function updateUser(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|email',
            'password' => 'string|nullable|confirmed', 
            'roles' => 'required|array',
        ]);

        $admin = Auth::user();
        $user = User::find($id);

        
        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        $user->mobile = null;
        $user->app_id = $admin->app_id;
        $user->payment_date = null;

        // Only update the password if it's provided
        if (!empty($validateData['password'])) {
            $user->password = Hash::make($validateData['password']);
        }

        $user->role = json_encode($validateData['roles']);
        $user->status = $admin->status;

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }

    // chat assign
    // public function assignChats(Request $request, $id){
    //     // validate
    //     $validateData = $request->validate([
    //         'contact_id' => 'required|array',
    //         'user_id' => 'required|string',
    //     ]);

    //     $contacts = new AssignedContat();

    // }

    
}
