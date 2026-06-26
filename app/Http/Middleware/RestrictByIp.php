<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictByIp
{
    /**
     * IP yang diizinkan untuk semua user
     */
    protected array $allowedIps = [
        '127.0.0.1',
        '103.109.188.226', // IP hotel
    ];

    /**
     * Role yang boleh akses dari IP manapun
     */
    protected array $bypassRoles = [
        'superuser',
        'admin',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $clientIp = $request->ip();

        // Kalau IP sudah di whitelist, langsung lolos
        if (in_array($clientIp, $this->allowedIps)) {
            return $next($request);
        }

        // Kalau user sudah login dan rolenya bypass, lolos
        if (auth()->check() && in_array(auth()->user()->role, $this->bypassRoles)) {
            return $next($request);
        }

        // Kalau belum login, cek apakah request ke halaman login
        // (biarkan halaman login tetap bisa diakses agar bisa login dulu)
        if ($request->routeIs('login') || $request->routeIs('logout')) {
            return $next($request);
        }

        abort(403, 'Akses tidak diizinkan dari jaringan ini.');
    }
}
