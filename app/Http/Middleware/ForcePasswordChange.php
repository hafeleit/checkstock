<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Hash::check(env('DEFAULT_PASSWORD', ''), Auth::user()->password) && Carbon::now()->diffInDays(Auth::user()->created_at) > 7) {
            $allowedRoutes = ['change-password', 'change.perform', 'logout'];

            if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('change-password')->with('warning', 'กรุณาเปลี่ยนรหัสผ่านก่อนใช้งานระบบ');
            }
        }

        return $next($request);
    }
}
