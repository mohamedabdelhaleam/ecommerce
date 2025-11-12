<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }

    /**
     * Display the dashboard home page.
     */
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('dashboard.login');
        }
        return view('dashboard.pages.home.index');
    }
}
