<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna sudah login dan memiliki role user
        if (Auth::check() && Auth::user()->isUser()) {
            return $next($request);
        }

        // Jika belum login, redirect ke halaman login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika sudah login tapi bukan user, redirect ke halaman home
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}