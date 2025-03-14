<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($role == 'superadmin' && $user->is_super_admin) {
            return $next($request);
        }

        if ($role == 'management' && $user->is_management) {
            return $next($request);
        }

        if ($role == 'student' && $user->is_student) {
            return $next($request);
        }

        // If user doesn't have the required role, redirect to a specific page
        return redirect('home')->withErrors(['error' => 'You do not have access to this section']);
    }
}
