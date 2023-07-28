<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class smartSearch extends Controller
{
    public function index(Request $request)
    {
        // Get the user input (search query) from the request
        $userQuery = $request->input('query');

        // Execute the Python script and capture the output
        $pythonPath = "C:\\Users\\stanr\\AppData\\Local\\Programs\\Python\\Python310\\python.exe";
        $scriptPath = public_path("resources/scripts/bible_search.py");
        $command = "$pythonPath $scriptPath \"$userQuery\"";
        $output = shell_exec($command);
        // dd($output);
        // Pass the output to the Laravel view
        return view('/modules/homepage', ['output' => $output, 'userQuery' => $userQuery]);
    }
}