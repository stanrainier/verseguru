<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/modules/homepage');
    }
    public function aboutus()
    {
        return view('/modules/aboutus');
    }
    public function bible()
    {
        return view('/modules/bible');
    }
    public function searchHistory()
    {
        return view('/modules/searchHistory');
    }
    public function bookmarks()
    {
        return view('/modules/bookmarks');
    }

}
