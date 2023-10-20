<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();

        $token = Password::createToken($user);
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);

        return view('modules.profile', compact('user'));
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route('token');
        $email = $request->route('email');

        return view('auth.passwords.reset', compact('token', 'email'));
    }
}
