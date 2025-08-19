<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // Menampilkan semua anggota
    public function tampilkanSemua()
    {
        // tampilkan anggota beserta user terkait
        return Anggota::with('user')->get();
    }

    // Menampilkan detail anggota by ID
    public function tampilkanDetail($id)
    {
        return Anggota::with('user')->findOrFail($id);
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

        return response()->json($anggota, 201);
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

        return response()->json($anggota, 200);
    }

    // Menghapus anggota
    public function hapusAnggota($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return response()->json(['message' => 'Anggota berhasil dihapus']);
    }
}
