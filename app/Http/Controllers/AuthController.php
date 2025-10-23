<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogActivity;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if user is active
            if (!$user->isAktif()) {
                Auth::logout();
                return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }

            // Log activity untuk siswa
            if ($user->isSiswa() && $user->siswa) {
                LogActivity::logLogin($user->siswa->id);
            }

            $request->session()->regenerate();
            
            return $this->redirectBasedOnRole();
        }

        return back()->with('error', 'Email atau password salah!');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log activity untuk siswa sebelum logout
        if ($user && $user->isSiswa() && $user->siswa) {
            LogActivity::logLogout($user->siswa->id);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }

    /**
     * Redirect based on user role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOrangTua()) {
            return redirect()->route('orangtua.dashboard');
        } elseif ($user->isSiswa()) {
            return redirect()->route('siswa.dashboard');
        }

        return redirect()->route('home');
    }
}