<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleOrPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleOrPermission): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403, 'Unauthorized');
        }

        // Check if admin has the role or permission
        if (!$admin->hasRole($roleOrPermission) && !$admin->can($roleOrPermission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
