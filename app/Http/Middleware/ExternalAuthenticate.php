<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class ExternalAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request, Closure $next, string $role): ?string
    {
        if (!$request->user() || $request->user()->type !== $role) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
