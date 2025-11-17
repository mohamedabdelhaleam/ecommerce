<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        // You can add permission check here if needed: $this->middleware('permission:view users')->only(['index', 'show']);
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::withCount('orders');

        // Search by name, email, or phone
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // If AJAX request, return JSON with table HTML
        if ($request->ajax()) {
            return response()->json([
                'table' => view('dashboard.pages.users.partials.table', compact('users'))->render(),
                'pagination' => view('dashboard.pages.users.partials.pagination', compact('users'))->render(),
            ]);
        }

        return view('dashboard.pages.users.index', compact('users'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $user->load(['orders' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }, 'orders.items.product']);

        return view('dashboard.pages.users.show', compact('user'));
    }
}
