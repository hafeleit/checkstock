<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // ป้องกัน Clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // ป้องกัน MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ป้องกัน XSS (เบราว์เซอร์เก่าๆ)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // กำหนด Referrer Policy
        $response->headers->set('Referrer-Policy', 'no-referrer');

        // Content Security Policy (CSP) - ปรับตามระบบจริง
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval';  style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self' data:"
        );

        // บังคับใช้ HTTPS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        return $response;
    }
}
