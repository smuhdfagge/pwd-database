<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the public home page.
     */
    public function index()
    {
        return view('home');
    }
}
