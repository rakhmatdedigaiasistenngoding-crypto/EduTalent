<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // [STEP-38C] Menambahkan Security Headers
        
        // Mencegah aplikasi dimuat di dalam iFrame (Mencegah Clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');
        
        // Mencegah browser menebak tipe file (Mencegah MIME-sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Filter XSS dasar untuk browser lama
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Kebijakan Referrer untuk menjaga privasi URL asal
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Content Security Policy (Dasar - bisa dikustomisasi lebih lanjut)
        // Mengizinkan skrip hanya dari domain sendiri dan Google Fonts
        // CSP: Ditambahkan https://unpkg.com untuk Alpine.js CDN dan https://ui-avatars.com untuk avatar
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: https: blob:; connect-src 'self';");

        return $response;
    }
}
