<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ สร้าง nonce ก่อน render view
        $scriptNonce = base64_encode(random_bytes(16));
        $styleNonce  = base64_encode(random_bytes(16));

        // ส่งค่า nonce ไปใน request attributes
        $request->attributes->set('csp_script_nonce', $scriptNonce);
        $request->attributes->set('csp_style_nonce', $styleNonce);

        // ส่งค่า nonce ไปที่ Blade โดยตรง
        View::share('csp_script_nonce', $scriptNonce);
        View::share('csp_style_nonce', $styleNonce);

        // สร้าง response
        $response = $next($request);

        // Headers พื้นฐาน
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'no-referrer');

        // Content Security Policy (CSP)
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "script-src 'self' 'nonce-{$scriptNonce}'; " .
            "style-src 'self' 'nonce-{$styleNonce}'; " .
            "img-src 'self' data:; " .
            "font-src 'self' data:"
        );

        // HTTPS
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        
        // Permissions-Policy
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), fullscreen=(self)');

        return $response;
    }
}
