<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            $profilePicture = $request->file('profile_picture');
            $path = $profilePicture->store('profile-pictures', 'public');

            // Save the file path to the authenticated user's profile_picture column
            $user->profile_picture = $path;
            $user->save();

            return redirect()->back()->with('success', 'Profile picture uploaded successfully.');
        } else {
            // Handle the case when no file is uploaded
            $defaultProfilePicture = 'profile-pictures/defaultPFP.png';
            $user->profile_picture = $defaultProfilePicture;
            $user->save();

            return redirect()->back()->with('success', 'Default profile picture set.');
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the password
        $request->validate([
            'password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Incorrect password. Profile information not updated.');
                    }
                },
            ],
        ]);

        // Check if the entered password matches the user's password
        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()->back()->with('error', 'Incorrect password. Profile information not updated.');
        }

        // Update the name and username fields if they are not empty
        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        if ($request->filled('username')) {
            $user->username = $request->input('username');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile information updated successfully.');
    }

    public function showProfile()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }
}
