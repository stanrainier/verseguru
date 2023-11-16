<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchHistoryController;
use App\Http\Controllers\SmartSearchHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\smartSearch;


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

    Route::get('/bible', [App\Http\Controllers\HomeController::class, 'bible'])
        ->name('bible');
    
        Route::get('/aboutus', [App\Http\Controllers\HomeController::class, 'aboutus'])
        ->name('aboutus');
    
    
// reset password routes
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
        ->name('password.update');
    Route::get('/password/reset/{token}/{email?}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
        
});

// guest 


Route::middleware(['guest'])->get('/bookmarks', function () {
    return redirect()->route('login');
})->name('bookmarks');

Route::get('/logout', function () {
    return route('logout');
});

Route::get('/bookmarks', [App\Http\Controllers\HomeController::class, 'bookmarks'])
->name('bookmarks');

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
            return redirect('/home'); // Redirect to the desired page after successful verification
        } else {
            return redirect('/'); // Redirect to a different page if verification fails
        }
    })->name('verification.verify');
});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['throttle:6,1'])->name('verification.send');


// Search history Bible
Route::post('/search', [SearchHistoryController::class, 'search'])->name('search');
Route::delete('/search-history/delete/{id}', [SearchHistoryController::class, 'deleteSingle'])->name('search-history.delete');
Route::delete('/search-history/delete-all', [SearchHistoryController::class, 'deleteAll'])->name('search-history.delete-all');



// Smart Search History 

Route::post('/smartsearch', [SmartSearchHistoryController::class, 'smartsearch'])->name('smartsearch');
Route::delete('/smartsearch-history/delete/{id}', [SmartSearchHistoryController::class, 'deleteSingle'])->name('search-history.delete');
Route::delete('/smartsearch-history/delete-all', [SmartSearchHistoryController::class, 'deleteAll'])->name('search-history.delete-all');

// history interface 
Route::get('/history', [SearchHistoryController::class, 'index'])
    ->name('search-history')
    ->middleware('auth');

Route::get('/smart-history', [SmartSearchHistoryController::class, 'index'])
    ->name('smart-search-history')
    ->middleware('auth');





Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', function () {
        return view('/auth/passwords/email');
    })->name('change-password');
});

Route::get('/forgot-password', function () {
    return view('/auth/passwords/email');
});
//profile

Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/authenticate', [ProfileController::class, 'authenticate'])->name('profile.authenticate');
    // Add more authenticated user routes as needed
});

// upload pfp

Route::post('/upload-profile-picture', [App\Http\Controllers\ProfileController::class, 'uploadProfilePicture'])->name('upload-profile-picture');

// edit information

Route::match(['post', 'put'], '/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::middleware(['auth'])->group(function () {
    // Routes for authenticated users
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/authenticate', [ProfileController::class, 'authenticate'])->name('profile.authenticate');
    // Add more authenticated user routes as needed
});

Route::post('/profile/authenticate', [ProfileController::class, 'authenticate'])->name('profile.authenticate');


// BOOKMARK 
// Routes that do not require authentication
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::delete('/bookmarks/delete/{id}', [BookmarkController::class, 'deleteSingle']);
Route::delete('/bookmarks/delete-all', [BookmarkController::class, 'deleteAll'])->name('bookmarks.deleteAll');
Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggleBookmark'])->name('toggleBookmark');
Route::post('/addBookmark', [BookmarkController::class, 'addBookmark'])->name('addBookmark');


//NEW BOOKMARK AND HISTORY DELETE ROUTES
Route::post('/bookmarks/delete-selected', [BookmarkController::class, 'deleteSelectedBookmarks'])
    ->name('bookmarks.deleteSelected');

Route::post('/search-history/delete-selected', [SearchHistoryController::class, 'deleteSelectedHistory'])
    ->name('searchHistory.deleteSelected');
    
Route::post('/smartsearch-history/delete-selected', [SmartSearchHistoryController::class, 'deleteSelectedHistory'])
    ->name('smartsearchHistory.deleteSelected');




// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::post('/bookmarks/add', [BookmarkController::class, 'addBookmark']);
    Route::delete('/bookmarks/{id}/remove', [BookmarkController::class, 'removeBookmark']);
    
});



// Smart Search 

Route::post('/search-bible', [smartSearch::class, 'index'])->name('search.bible');



