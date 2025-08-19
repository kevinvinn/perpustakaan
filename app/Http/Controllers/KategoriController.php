<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // GET semua kategori
    public function tampilkanSemua()
    {
        return response()->json(Kategori::all());
    }

    // GET detail kategori berdasarkan ID
    public function tampilkanDetail($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['pesan' => 'Kategori tidak ditemukan'], 404);
        }
        return response()->json($kategori);
    }

    // POST tambah kategori baru
    public function tambahKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create([
            'nama' => $request->nama,
        ]);

        return response()->json([
            'pesan' => 'Kategori berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    // PUT ubah kategori
    public function ubahKategori(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['pesan' => 'Kategori tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
        ]);

        $kategori->update($request->all());

        return response()->json([
            'pesan' => 'Kategori berhasil diubah',
            'data' => $kategori
        ]);
    }

    // DELETE hapus kategori
    public function hapusKategori($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['pesan' => 'Kategori tidak ditemukan'], 404);
        }

        $kategori->delete();

        return response()->json(['pesan' => 'Kategori berhasil dihapus']);
    }
}
