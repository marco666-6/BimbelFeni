<?php
// sides\app\Http\Controllers\AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // // Log aktivitas login
            // activity()
            //     ->causedBy($user)
            //     ->log('User login: ' . $user->name);
            
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Redirect berdasarkan role
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
            case 'orang_tua':
                return redirect()->route('orangtua.dashboard')->with('success', 'Selamat datang!');
            case 'siswa':
                return redirect()->route('siswa.dashboard')->with('success', 'Selamat datang!');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Role tidak valid']);
        }
    }

    // Logout
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // // Log aktivitas logout
        // if ($user) {
        //     activity()
        //         ->causedBy($user)
        //         ->log('User logout: ' . $user->name);
        // }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Berhasil logout');
    }

    // Tampilkan halaman register (untuk orang tua)
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    // Proses registrasi orang tua
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_orang_tua' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'hubungan' => 'required|in:ayah,ibu,wali',
            'pekerjaan' => 'nullable|string|max:255',
        ], [
            'nama_orang_tua.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'telepon.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'hubungan.required' => 'Hubungan dengan siswa wajib dipilih',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Buat user
            $user = User::create([
                'name' => $request->nama_orang_tua,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'orang_tua',
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ]);

            // Buat data orang tua
            OrangTua::create([
                'user_id' => $user->id,
                'nama_orang_tua' => $request->nama_orang_tua,
                'hubungan' => $request->hubungan,
                'pekerjaan' => $request->pekerjaan,
            ]);

            // Auto login setelah registrasi
            Auth::login($user);

            return redirect()->route('orangtua.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang di Bimbel Oriana Enilin.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    // Update profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
            ];

            // Handle upload foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
                    unlink(public_path($user->foto_profil));
                }

                $file = $request->file('foto_profil');
                $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/profiles'), $filename);
                $data['foto_profil'] = 'storage/profiles/' . $filename;
            }

            $user->update($data);

            // Update nama di tabel terkait
            if ($user->isOrangTua() && $user->orangTua) {
                $user->orangTua->update(['nama_orang_tua' => $request->name]);
            } elseif ($user->isSiswa() && $user->siswa) {
                $user->siswa->update(['nama_siswa' => $request->name]);
            }

            return back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai']);
        }

        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}