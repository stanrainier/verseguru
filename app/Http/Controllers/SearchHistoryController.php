<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use App\Models\SmartSearchHistory;
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
        $smartsearchHistory = SmartSearchHistory::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('modules.searchHistory', compact('searchHistory', 'smartsearchHistory'));
    }



    public function deleteSelectedHistory(Request $request)
    {
        $selectedIds = $request->input('ids');
    
        if (!is_array($selectedIds) || count($selectedIds) === 0) {
            return response()->json(['message' => 'No bookmarks selected.'], 400);
        }
    
        // Assuming that the 'ids' array contains bookmark IDs
        // You can add additional validation and security checks here
        
        // Delete the selected bookmarks
        searchHistory::whereIn('id', $selectedIds)->delete();
    
        return response()->json(['message' => 'Selected bookmarks have been deleted.']);
    }

}
