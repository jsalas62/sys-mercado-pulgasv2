<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');
    }
    
    public function getDashboard()
    {
        return view('dashboard');
    }

    public function get404AdminNotFound()
    {
        return view('404');
    }
}
