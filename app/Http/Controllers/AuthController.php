<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            
            if ($role === 'pasien') return redirect()->route('pasien.dashboard');
            if ($role === 'dokter') return redirect()->route('dokter.periksa.index');
            if ($role === 'staff')  return redirect()->route('staff.dashboard');
            
            Auth::logout();
            return back()->withErrors(['email' => 'Role tidak valid.']);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan Form Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register (NIK, Alamat, dll)
    public function register(Request $request)
    {
        $request->validate([
            'nik'       => 'required|numeric|unique:users,nik',
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'no_hp'     => 'required|string',
            'alamat'    => 'required|string',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nik'       => $request->nik,
            'name'      => $request->name,
            'email'     => $request->email,
            'no_hp'     => $request->no_hp,
            'alamat'    => $request->alamat,
            'password'  => Hash::make($request->password),
            'role'      => 'pasien', // Default Pasien
        ]);

        // PERUBAHAN DI SINI:
        // Tidak ada Auth::login($user);
        // Langsung lempar ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun baru Anda.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}