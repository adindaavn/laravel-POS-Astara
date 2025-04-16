<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 *
 * Controller untuk menangani proses autentikasi pengguna (login dan logout).
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Melakukan autentikasi pengguna berdasarkan username dan password.
     *
     * @param Request $request Permintaan HTTP yang berisi data login.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth(Request $request)
    {
        // Validasi input pengguna
        $request->validate([
            'username' => 'required',
            'password' => 'required' 
        ]);

        // Mencari pengguna berdasarkan username
        $user = User::where('username', $request->username)->first();
        
        // Memeriksa password dan melakukan login
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            session(['user_id' => $user->id]);
            Log::createLog('user', 'login', $user);
            return redirect()->intended('home');
        } else {
            return back()->withErrors(['loginError' => 'Username atau password salah'])->withInput();
        }
    }

    /**
     * Melakukan logout pengguna dan menghapus sesi.
     *
     * @param Request $request Permintaan HTTP.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Log::createLog('user', 'logout', $request);
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect()->intended(route('login'));
    }
}
