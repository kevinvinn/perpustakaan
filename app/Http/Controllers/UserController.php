<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET semua user
    public function tampilkanSemua(Request $request)
    {
        $users = User::all();

        if ($request->wantsJson()) {
            return response()->json($users);
        }

        return view('users.index', compact('users'));
    }

    // GET detail user by ID
    public function tampilkanDetail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($user);
        }

        return view('users.show', compact('user'));
    }

    // POST tambah user
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
            'password' => $request->password, 
            'role' => $request->role,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'pesan' => 'User berhasil ditambahkan',
                'data' => $user
            ], 201);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    // PUT update user
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
            'password' => $request->password ? $request->password : $user->password,
            'role' => $request->role ?? $user->role,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'pesan' => 'User berhasil diperbarui',
                'data' => $user
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    // DELETE hapus user
    public function hapusUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'pesan' => 'User berhasil dihapus'
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
