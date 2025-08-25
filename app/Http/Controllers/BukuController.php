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
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // validasi upload gambar
        ]);

        $data = $request->all();

        // Kalau ada upload gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buku', 'public'); // simpan ke storage/app/public/buku
            $data['image'] = $path;
        }

        $buku = Buku::create($data);

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
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('buku', 'public');
            $data['image'] = $path;
        }

        $buku->update($data);

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
