<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrossReferenceController extends Controller
{
// Add this function in your controller or helper file to read the JSON file and return the data as an array
    function getCrossReferenceData()
    {
        $filePath = resource_path('datasets/crossReferenceDataSet.json');
        
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            return json_decode($jsonContent, true);
        }
        
        return []; // Return an empty array if the file doesn't exist or cannot be read
    }

}
