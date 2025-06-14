<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Kebijakan CSP yang lebih permisif untuk Midtrans dan aset umum
        // Sesuaikan domain dengan yang Anda butuhkan (CDN, Font, dll.)
        $cspDirectives = [
          "default-src 'self'",
        // MODIFIKASI BARIS SCRIPT-SRC DI BAWAH INI:
        "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://app.sandbox.midtrans.com https://api.sandbox.midtrans.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com https://use.fontawesome.com",
        "style-src 'self' 'unsafe-inline' https://stackpath.bootstrapcdn.com https://fonts.googleapis.com https://use.fontawesome.com",
        "font-src 'self' https://fonts.gstatic.com https://use.fontawesome.com data:",
        "img-src 'self' data: https://*",
        "form-action 'self'",
        "frame-src 'self' https://app.sandbox.midtrans.com",
        "object-src 'none'",
        "connect-src 'self' https://app.sandbox.midtrans.com https://api.sandbox.midtrans.com",
        ];

        // Hapus header CSP yang mungkin sudah ada sebelumnya (jika ada paket lain yang mengaturnya)
       $response->headers->remove('Content-Security-Policy');
    $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        // Anda mungkin juga ingin menambahkan header lain yang direkomendasikan untuk keamanan
        // $response->headers->set('X-Content-Type-Options', 'nosniff');
        // $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        // $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
}