<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        return view('admin.dashboard');
    }
}
