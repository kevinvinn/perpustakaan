<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // Menampilkan semua anggota
    public function tampilkanSemua(Request $request)
    {
        $anggota = Anggota::with('user')->get();

        if ($request->wantsJson()) {
            return response()->json($anggota, 200);
        }

        return view('anggota.index', compact('anggota'));
    }

    // Menampilkan detail anggota by ID
    public function tampilkanDetail(Request $request, $id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($anggota, 200);
        }

        return view('anggota.detail', compact('anggota'));
    }

    // Menambah anggota baru
    public function tambahAnggota(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'user_id' => 'required|exists:users,id' // harus ada di tabel users
        ]);

        $anggota = Anggota::create($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil ditambahkan',
                'data' => $anggota
            ], 201);
        }

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    // Mengubah data anggota
    public function ubahAnggota(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'jurusan' => 'sometimes|required|string|max:255',
            'no_hp' => 'sometimes|required|string|max:20',
            'user_id' => 'sometimes|required|exists:users,id'
        ]);

        $anggota->update($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil diperbarui',
                'data' => $anggota
            ], 200);
        }

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui');
    }

    // Menghapus anggota
    public function hapusAnggota(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Anggota berhasil dihapus'
            ], 200);
        }

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}
