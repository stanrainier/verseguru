<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SearchHistoryController extends Controller
{
    public function search(Request $request)
    {
        // Perform the search
    
        // Store search history
        if (Auth::check()) {
            $searchQuery = $request->input('query');
            $userId = Auth::id();
    
            SearchHistory::create([
                'user_id' => $userId,
                'search_query' => $searchQuery,
            ]);
        }
    
        // Return search results or redirect
        return response()->json(['message' => 'Search results']); // Replace this with your desired response
    }
    
    public function index()
    {
        $userId = Auth::id();
        $searchHistory = SearchHistory::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('modules.searchHistory', ['searchHistory' => $searchHistory]);
    }
    
}