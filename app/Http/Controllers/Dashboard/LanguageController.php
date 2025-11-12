<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch(Request $request, $locale)
    {
        // Validate locale
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        // Set locale in session
        Session::put('locale', $locale);

        // Ensure session is saved
        Session::save();

        // Set locale for current request
        App::setLocale($locale);

        // Get the previous URL
        $previousUrl = url()->previous();

        // If previous URL exists and is a dashboard route, redirect there
        if ($previousUrl && str_contains($previousUrl, '/dashboard')) {
            return redirect($previousUrl);
        }

        // Otherwise redirect to dashboard home (or login if not authenticated)
        try {
            return redirect()->route('dashboard.home');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.login');
        }
    }
}
