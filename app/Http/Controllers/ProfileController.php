<?php

namespace App\Http\Controllers;

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
    
            // // Delete the existing profile picture if it exists
            // if ($user->profile_picture) {
            //     Storage::disk('public')->delete($user->profile_picture);
            // }
    
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
    
}
