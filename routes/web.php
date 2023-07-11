<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ResetPasswordController;


Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('/auth/login');
    });

    Route::get('/createaccount', function () {
        return view('/modules/registration');
    });
});

Route::middleware(['verified'])->group(function () {
    Route::get('/home', function () {
        return view('/modules/homepage');
    });

    //routes that are accessible only to verified users
    Route::get('/aboutus', [App\Http\Controllers\HomeController::class, 'aboutus'])
        ->name('aboutus');

    Route::get('/bible', [App\Http\Controllers\HomeController::class, 'bible'])
        ->name('bible');
        
});

// guest 


Route::get('/logout', function () {
    return route('logout');
});

Route::get('/bibleTest', function () {
    return route('/modules/bible');
});

Auth::routes(['verify' => true]);


// signed in
Route::middleware(['signed'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            $request->fulfill();
            $user->markEmailAsVerified();
            // You can add additional logic here, such as displaying a success message

            return redirect('/home'); // Redirect to the desired page after successful verification
        } else {
            // You can add additional logic here, such as displaying an error message
            return redirect('/'); // Redirect to a different page if verification fails
        }
    })->name('verification.verify');
});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['throttle:6,1'])->name('verification.send');


// Search history

Route::post('/search', [SearchHistoryController::class, 'search'])->name('search');

Route::get('/history', [SearchHistoryController::class, 'index'])
    ->name('search-history')
    ->middleware('auth');

// Route::get('/search-history', 'SearchHistoryController@index')->name('search-history')->middleware('auth');
// Route::post('/search', [SearchHistoryController::class, 'search'])->name('search');


// Reset password
Route::middleware(['auth'])->group(function () {
    Route::get('/resetpassword/{token}', function ($token) {
        return view('auth.passwords.reset', compact('token'));
    })->name('password.reset');
});


//profile

use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    // Routes for authenticated users
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    // Add more authenticated user routes as needed
});

// upload pfp

Route::post('/upload-profile-picture', [App\Http\Controllers\ProfileController::class, 'uploadProfilePicture'])->name('upload-profile-picture');

// edit information

// Route::match(['get', 'post', 'put'], '/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::match(['post', 'put'], '/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::middleware(['auth'])->group(function () {
    // Routes for authenticated users
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/authenticate', [ProfileController::class, 'authenticate'])->name('profile.authenticate');
    // Add more authenticated user routes as needed
});

Route::post('/profile/authenticate', [ProfileController::class, 'authenticate'])->name('profile.authenticate');


