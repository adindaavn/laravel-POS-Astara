<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            $admin = [
                '/home',
                '/logout',
                '/kategori',
                '/pemasok',
                '/buku',
                '/member',
                '/voucher'
            ];
            $kasir = [
                '/home',
                '/logout',
                '/penjualan',
                '/member',
                '/voucher',
                '/buku',
            ];

            if ($role === 'owner') {
                return $next($request);
            }

            if ($role === 'admin' && in_array($request->path(), $admin)) {
                return $next($request);
            }

            if ($role === 'kasir' && in_array($request->path(), $kasir)) {
                return $next($request);
            }
        }

        return redirect()->route('home')->withErrors('You do not have permission to access this page.');
    }
}
