<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        $userRole = $user->Role;

        // Treat seller as store role just in case
        if ($userRole === 'seller') {
            $userRole = 'store';
        }

        if (!in_array($userRole, $roles)) {
            // Redirect based on the actual role of the user
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($userRole === 'store') {
                return redirect()->route('MenuUtamaStore');
            } else {
                return redirect()->route('MenuUtama');
            }
        }

        return $next($request);
    }
}
