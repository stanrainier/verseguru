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
    

    public function index()
    {
        $userId = Auth::id();
        $searchHistory = SmartSearchHistory::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('modules.searchHistory', ['smartsearchHistory' => $searchHistory]);
    }

    public function deleteSingle($id)
    {
        $searchHistory = SmartSearchHistory::find($id);
        
        if (!$searchHistory) {
            return response()->json(['message' => 'Search history not found'], 404);
        }

        $searchHistory->delete();

        return response()->json(['message' => 'Search history deleted']);
    }

    public function deleteAll()
    {
        $userId = Auth::id();
        SmartSearchHistory::where('user_id', $userId)->delete();

        return response()->json(['message' => 'All search history deleted']);
    }
}
