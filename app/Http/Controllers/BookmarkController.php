<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class BookmarkController extends Controller
{
    public function index()
    {
        // Retrieve all bookmarks for the current user from the database
        $user = auth()->user();
        $bookmarks = Bookmark::where('user_id', $user->id)->get();

        // Pass the bookmarks data to the 'bookmarks' view
        return view('/modules/bookmarks', compact('bookmarks'));
    }

    public function deleteSingle($id)
    {
        $searchHistory = Bookmark::findOrFail($id);
        
        $searchHistory->delete();
    
        return response()->json(['message' => 'Search history deleted']);
    }
    

    public function deleteAll()
    {
        $userId = Auth::id();
        Log::info('Delete All Bookmarks called by user ID: ' . $userId);
        Bookmark::where('user_id', $userId)->delete();

        return response()->json(['message' => 'All search history deleted']);
        }
    
    
    
    
    
    public function addBookmark(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'verse_text' => 'required|string',
            'book_id' => 'required|string',
            'chapter' => 'required|string',
            'verse' => 'required|string',
        ]);

        // Get the authenticated user ID
        $userId = Auth::id();

        // Extract verse details from the request
        $verseText = $request->input('verse_text');
        $bookId = $request->input('book_id');
        $chapter = $request->input('chapter');
        $verse = $request->input('verse');

        // Check if the bookmark already exists for the user and verse
        $bookmark = Bookmark::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->where('chapter', $chapter)
            ->where('verse', $verse)
            ->first();

        if ($bookmark) {
            // Bookmark already exists, so delete it
            $bookmark->delete();

            return response()->json([
                'status' => 'removed',
            ]);
        } else {
            // Bookmark doesn't exist, so create it
            Bookmark::create([
                'user_id' => $userId,
                'verse_text' => $verseText,
                'book_id' => $bookId,
                'chapter' => $chapter,
                'verse' => $verse,
            ]);

            return response()->json([
                'status' => 'added',
            ]);
        }
    }

        public function toggleBookmark(Request $request)
    {
        $user = Auth::user();
        $verseText = $request->input('verse_text');
        $bookId = $request->input('book_id');
        $chapter = $request->input('chapter');
        $verse = $request->input('verse');

        // Check if the bookmark already exists for the user and verse
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('verse_text', $verseText)
            ->where('book_id', $bookId)
            ->where('chapter', $chapter)
            ->where('verse', $verse)
            ->first();

        if ($bookmark) {
            // Bookmark already exists, so delete it
            $bookmark->delete();

            return response()->json([
                'status' => 'removed',
            ]);
        } else {
            // Bookmark doesn't exist, so create it
            Bookmark::create([
                'user_id' => $user->id,
                'verse_text' => $verseText,
                'book_id' => $bookId,
                'chapter' => $chapter,
                'verse' => $verse,
            ]);

            return response()->json([
                'status' => 'added',
            ]);
        }
    }

    

    

}