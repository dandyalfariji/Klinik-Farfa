<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek Role
        $userRole = Auth::user()->role; 
        // Logic: Jika role user ada di dalam daftar roles yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 3. Jika gagal
        abort(403, 'Akses Ditolak: Anda tidak memiliki izin ke halaman ini.');
    }
}