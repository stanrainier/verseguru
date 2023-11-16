<?php

namespace App\Http\Controllers;

use App\Models\SmartSearchHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SmartSearchHistoryController extends Controller
{
    public function smartsearch(Request $request)
    {
        // Perform the search

        // Store search history
        if (Auth::check()) {
            $searchQuery = $request->input('query');
            $userId = Auth::id();

            SmartSearchHistory::create([
                'user_id' => $userId,
                'search_query' => $searchQuery,
            ]);
        }

        // Return search results or redirect
        // return response()->json(['message' => 'Search results']); // Replace this with your desired response
        // return response()->json(['message' => 'Search results']); // Replace this with your desired response
        // return response()->json(['message' => 'Search results']); // Replace this with your desired response
        return redirect('/');
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
        SmartSearchHistory::whereIn('id', $selectedIds)->delete();
    
        return response()->json(['message' => 'Selected bookmarks have been deleted.']);
    }


    public function index()
    {
        $userId = Auth::id();
        $searchHistory = SmartSearchHistory::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.searchHistory', ['smartsearchHistory' => $searchHistory]);
    }

}
