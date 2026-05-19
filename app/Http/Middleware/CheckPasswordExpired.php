<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isPasswordExpired()) {
            $allowedRoutes = ['change-password', 'change.perform', 'logout'];
             if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('change-password')->with('error', 'Your password has expired. Please change your password.');
            }
        }
        return $next($request);
    }
}
