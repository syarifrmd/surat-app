<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            // Regenerasi session setelah login berhasil
            $request->session()->regenerate();

            $user = Auth::user();  // Ambil data pengguna yang login

            // Pengecekan role dan pengalihan halaman sesuai role
            if ($user->isKaryawan()) {
                return redirect()->intended('karyawan/dashboard'); // Dashboard karyawan
            }

            if ($user->isAdmin()) {
                return redirect()->intended('admin/dashboard'); // Dashboard admin
            }

            // Default redirect jika role tidak ditemukan
            return redirect('/');
        }

        // Jika login gagal
        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        // Logout pengguna
        Auth::logout();

        // Invalidate session dan regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return redirect('/');
    }
}