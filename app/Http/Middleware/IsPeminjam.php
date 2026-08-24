<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPeminjam
{
    public function handle(Request $request, Closure $next)
{
    if (!Auth::check() || !Auth::user()->role) {
        abort(403, 'Akses khusus Peminjam.');
    }

    $role = strtolower(Auth::user()->role->nama_role);

    if ($role === 'peminjam') {
        return $next($request);
    }

    abort(403, 'Akses khusus Peminjam.');
}
}
