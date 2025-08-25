<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // GET semua kategori
    public function tampilkanSemua(Request $request)
    {
        $kategori = Kategori::all();

        if ($request->expectsJson()) {
            return response()->json($kategori);
        }

        return view('kategori.index', compact('kategori'));
    }

    // GET detail kategori berdasarkan ID
    public function tampilkanDetail(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            if ($request->expectsJson()) {
                return response()->json(['pesan' => 'Kategori tidak ditemukan'], 404);
            }
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
        }

        if ($request->expectsJson()) {
            return response()->json($kategori);
        }

        return view('kategori.show', compact('kategori'));
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

        if ($request->expectsJson()) {
            return response()->json([
                'pesan' => 'Kategori berhasil ditambahkan',
                'data' => $kategori
            ], 201);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    // PUT ubah kategori
    public function ubahKategori(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            if ($request->expectsJson()) {
                return response()->json(['pesan' => 'Kategori tidak ditemukan'], 404);
            }
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
        ]);

        $kategori->update($request->only('nama'));

        if ($request->expectsJson()) {
            return response()->json([
                'pesan' => 'Kategori berhasil diubah',
                'data' => $kategori
            ]);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diubah');
    }

    // DELETE hapus kategori
    public function hapusKategori(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            if ($request->expectsJson()) {
                return response()->json(['pesan' => 'Kategori tidak ditemukan'], 404);
            }
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
        }

        $kategori->delete();

        if ($request->expectsJson()) {
            return response()->json(['pesan' => 'Kategori berhasil dihapus']);
        }

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
