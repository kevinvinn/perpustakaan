<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan semua user
    public function tampilkanSemua()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Tampilkan user berdasarkan id
    public function tampilkanDetail($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Tambah user baru
    public function tambahUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,anggota',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json([
            'pesan' => 'User berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    // Ubah user
    public function ubahUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'string|max:255',
            'email' => 'string|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'in:admin,petugas,anggota',
        ]);

        $user->update([
            'nama' => $request->nama ?? $user->nama,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role ?? $user->role,
        ]);

        return response()->json([
            'pesan' => 'User berhasil diperbarui',
            'data' => $user
        ]);
    }

    // Hapus user
    public function hapusUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'pesan' => 'User berhasil dihapus'
        ]);
    }
}
