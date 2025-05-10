<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        // If the request expects JSON (like Postman/API), return a JSON response
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Welcome to your dashboard',
                'user' => auth()->user()
            ]);
        }

        // Otherwise return the traditional web view
        return view('home');
    }
}
