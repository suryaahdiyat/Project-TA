<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns|max:255',
            'password' => 'required|min:4'
        ]);
        // dd($request->all());

        // Ambil user berdasarkan email
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('LoginFail', 'Email tidak ditemukan.');
        }

        // Cek apakah user adalah admin atau penghulu dan aktif
        if (in_array($user->role, ['admin', 'penghulu']) && !$user->is_active) {
            return back()->with('LoginFail', 'Akun Anda sedang dinonaktifkan.');
        }

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('/dashboard');
        // } else {
        //     return back()->with('LoginFail', 'Gagal Login');
        // }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // Ambil user yang baru login

            // Arahkan berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended('/dashboard');
            } elseif ($user->role === 'penghulu') {
                return redirect()->intended('/penghulu-schedule');
            } else {
                return redirect()->intended('/'); // Default jika tidak dikenali
            }
        } else {
            return back()->with('LoginFail', 'Gagal Login');
        }
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
