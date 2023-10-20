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

    public function deleteSingle($id)
    {
        $searchHistory = SearchHistory::find($id);
        
        if (!$searchHistory) {
            return response()->json(['message' => 'Search history not found'], 404);
        }

        $searchHistory->delete();

        return response()->json(['message' => 'Search history deleted']);
    }

    public function deleteAll()
    {
        $userId = Auth::id();
        SearchHistory::where('user_id', $userId)->delete();

        return response()->json(['message' => 'All search history deleted']);
    }
}
