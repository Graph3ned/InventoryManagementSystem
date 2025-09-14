<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if ($role === 'admin') {
            if ($user->role !== 'admin') {
                abort(403, 'Access denied. Admin role required.');
            }
        } elseif ($role === 'staff') {
            if ($user->role !== 'staff') {
                abort(403, 'Access denied. Staff role required.');
            }
        }

        return $next($request);
    }
}
