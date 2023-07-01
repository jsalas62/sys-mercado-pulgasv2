<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function getDashboard()
    {
        return view('admin.dashboard');
    }

    public function get404AdminNotFound()
    {
        return view('admin.404');
    }
}
