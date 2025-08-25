<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // hanya huruf & spasi
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,anggota',
        ], [
            'nama.regex' => 'Nama hanya boleh berisi huruf.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => $request->role,
        ]);

        // Kalau request API (Postman)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'data' => $user
            ], 201);
        }

        // Kalau request dari form Blade
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Jika request API (Postman)
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data'    => $user
                ], 200);
            }

            // Jika request dari Blade (pakai session)
            $request->session()->regenerate();
            // Arahkan sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.home');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('admin.home');
            } else {
                return redirect()->route('anggota.home');
            }
        }

        // Kalau gagal
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }


    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->forget('user'); // hapus user di session

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ], 200);
        }

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }

}
