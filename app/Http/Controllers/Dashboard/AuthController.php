<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard.home');
        }
        return view('dashboard.auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
        ];

        // Check if admin exists with this phone and is active
        $admin = Admin::where('phone', $request->phone)
            ->active()
            ->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'phone' => __('The provided credentials do not match our records.'),
            ]);
        }

        // Log the admin in
        Auth::guard('admin')->login($admin, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.home'));
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login');
    }
}
