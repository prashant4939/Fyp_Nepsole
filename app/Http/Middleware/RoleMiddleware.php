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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            // Redirect vendors to vendor login, others to customer login
            if (in_array('vendor', $roles)) {
                return redirect()->route('vendor.login')
                    ->withErrors(['email' => 'Please login to access the vendor dashboard.']);
            }
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
