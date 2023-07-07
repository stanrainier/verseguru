<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('/auth/login');
});

Route::middleware(['verified'])->group(function () {
    Route::get('/home', function () {
        return view('/modules/homepage');
    });

    // Add your other routes that should be accessible only to verified users
    Route::get('/aboutus', [App\Http\Controllers\HomeController::class, 'aboutus'])
        ->name('aboutus');

    Route::get('/bible', [App\Http\Controllers\HomeController::class, 'bible'])
        ->name('bible');
});

Route::get('/createaccount', function () {
    return view('/modules/registration');
});

Route::get('/aboutusTest', function () {
    return view('/modules/aboutus');
});

Route::get('/logout', function () {
    return route('logout');
});

Route::get('/bibleTest', function () {
    return route('/modules/bible');
});

Auth::routes(['verify' => true]);

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

