<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function UserLoginStatus() {
    	$status = Auth::check();
    	$user   = Auth::user();

    	return response(['status' => $status, 'user' => $user]);
    }
}
