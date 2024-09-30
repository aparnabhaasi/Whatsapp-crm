<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('front-end.profile');
    }

    public function view_privacy_policy(){
        return view('front-end.privacy-policy');
    }

}
