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
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            $role = Auth::user()->role; // Ambil peran pengguna

            // Daftar halaman yang bisa diakses oleh role 'admin'
            $admin = [
                '/home',
                '/logout',
                '/kategori',
                '/pemasok',
                '/buku',
                '/member',
                '/voucher',
                '/pengajuan',
            ];

            // Daftar halaman yang bisa diakses oleh role 'kasir'
            $kasir = [
                '/home',
                '/logout',
                '/penjualan',
                '/member',
                '/voucher',
                '/buku',
                '/pengajuan',
            ];

            // Jika pengguna adalah 'owner', beri akses ke semua halaman
            if ($role === 'owner') {
                return $next($request);
            }

            // Jika pengguna adalah 'admin' dan halaman yang diakses ada dalam daftar $admin, izinkan akses
            if ($role === 'admin' && in_array($request->path(), $admin)) {
                return $next($request);
            }

            // Jika pengguna adalah 'kasir' dan halaman yang diakses ada dalam daftar $kasir, izinkan akses
            if ($role === 'kasir' && in_array($request->path(), $kasir)) {
                return $next($request);
            }
        }

        // Jika tidak memenuhi syarat, redirect ke home dengan pesan error
        return redirect()->route('home')->withErrors('You do not have permission to access this page.');
    }
}
