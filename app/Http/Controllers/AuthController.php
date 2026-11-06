<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN MENGGUNAKAN NIK
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'nik' => 'NIK atau password yang Anda masukkan salah.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang di HRM Skill Matrix.');
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN REGISTRASI
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES REGISTRASI MENGGUNAKAN NIK
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:30', 'unique:users,nik'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        User::create([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login menggunakan NIK.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil keluar dari aplikasi.');
    }
}