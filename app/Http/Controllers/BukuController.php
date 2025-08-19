<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Tampilkan semua buku
    public function tampilkanSemua()
    {
        $buku = Buku::with('kategori')->get(); // ikut ambil relasi kategori
        return response()->json($buku);
    }

    // Tampilkan detail buku berdasarkan id
    public function tampilkanDetail($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return response()->json($buku);
    }

    // Tambah buku baru
    public function tambahBuku(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'stok' => 'required|integer|min:0',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        $buku = Buku::create($request->all());

        return response()->json([
            'pesan' => 'Buku berhasil ditambahkan',
            'data' => $buku
        ], 201);
    }

    // Ubah buku
    public function ubahBuku(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'string|max:255',
            'kategori_id' => 'exists:kategori,id',
            'stok' => 'integer|min:0',
            'tahun_terbit' => 'digits:4|integer',
        ]);

        $buku->update($request->all());

        return response()->json([
            'pesan' => 'Buku berhasil diperbarui',
            'data' => $buku
        ]);
    }

    // Hapus buku
    public function hapusBuku($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return response()->json([
            'pesan' => 'Buku berhasil dihapus'
        ]);
    }
}
