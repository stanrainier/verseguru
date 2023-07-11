<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user(); // Retrieve the authenticated user

        return view('modules.profile', compact('user'));
    }
}
