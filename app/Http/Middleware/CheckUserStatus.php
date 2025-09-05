<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (Auth::check() && $user->is_active == 1) {
            return $next($request);
        }

        Auth::logout();

        if ($user->type === 'customer') {
            return redirect('/customer/login')->withErrors(['email' => 'Your account is not active. Please contact the administrator.'])->onlyInput('email');
        }

        return redirect('/login')->withErrors(['email' => 'Your account is not active. Please contact the administrator.'])->onlyInput('email');
    }
}
