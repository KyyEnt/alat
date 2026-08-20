<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPeminjam
{
    public function handle(Request $request, Closure $next)
    {
        $role = strtolower(auth()->user()->role->nama_role);
        if (Auth::check() && $role === 'peminjam') {
            return $next($request);
        }
        abort(403, 'Akses khusus Peminjam.');
    }
}
