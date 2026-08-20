<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = strtolower(auth()->user()->role->nama_role);
        if (Auth::check() && $role === 'admin') {
            return $next($request);
        }

        abort(403, 'Akses ditolak! Halaman ini hanya dapat diakses oleh Admin.');
    }
}