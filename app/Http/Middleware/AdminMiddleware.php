<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah user adalah admin
        if (auth()->user()->jenis !== 'admin') {
            // Jika pengguna biasa, redirect ke home member dengan pesan
            if (auth()->user()->jenis === 'pengguna') {
                return redirect()->route('home_member')
                    ->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman admin.');
            }
        }

        return $next($request);
    }
}