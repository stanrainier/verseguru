<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class smartSearch extends Controller
{
    public function index(Request $request)
    {
        // Get the user input (search query) from the request
        $userQuery = $request->input('query');

        //where python
        $pythonPath = "/usr/local/bin/python3";
        $scriptPath = public_path("resources/scripts/smart_search.py");
        $command = "$pythonPath $scriptPath \"$userQuery\"";
        $output = shell_exec($command);
        return view('/modules/homepage', ['output' => $output, 'userQuery' => $userQuery]);
    }
    
}
