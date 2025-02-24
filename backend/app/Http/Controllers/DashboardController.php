<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        // Check the user's role and redirect accordingly
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
            return redirect()->route('dashboard.administration');
        } else {
            return redirect()->route('dashboard.questions');
        }
    }
}
