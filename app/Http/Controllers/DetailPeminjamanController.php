<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;

class DetailPeminjamanController extends Controller
{
    // GET semua detail peminjaman
    public function tampilkanSemua()
    {
        $detail = DetailPeminjaman::with(['peminjaman', 'buku'])->get();
        return response()->json($detail);
    }

    // GET detail by ID
    public function tampilkanDetail($id)
    {
        $detail = DetailPeminjaman::with(['peminjaman', 'buku'])->find($id);

        if (!$detail) {
            return response()->json(['message' => 'Detail peminjaman tidak ditemukan'], 404);
        }

        return response()->json($detail);
    }

    // POST tambah detail peminjaman
   // POST tambah detail peminjaman
    public function tambahDetail(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'buku_id' => 'required|exists:buku,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek stok buku
        $buku = \App\Models\Buku::find($request->buku_id);
        if ($request->jumlah > $buku->stok) {
            return response()->json([
                'message' => 'Jumlah buku yang dipinjam melebihi stok tersedia',
                'stok_tersedia' => $buku->stok
            ], 400);
        }

        $detail = DetailPeminjaman::create($request->only([
            'peminjaman_id',
            'buku_id',
            'jumlah',
        ]));

        // Kurangi stok buku setelah dipinjam
        $buku->stok -= $request->jumlah;
        $buku->save();

        return response()->json([
            'message' => 'Detail peminjaman berhasil ditambahkan',
            'data' => $detail
        ], 201);
    }

    // PUT update detail peminjaman
    public function ubahDetail(Request $request, $id)
    {
        $detail = DetailPeminjaman::find($id);

        if (!$detail) {
            return response()->json(['message' => 'Detail peminjaman tidak ditemukan'], 404);
        }

        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'buku_id' => 'required|exists:buku,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $detail->update($request->only([
            'peminjaman_id',
            'buku_id',
            'jumlah',
        ]));

        return response()->json([
            'message' => 'Detail peminjaman berhasil diperbarui',
            'data' => $detail
        ]);
    }

    // DELETE hapus detail peminjaman
    public function hapusDetail($id)
    {
        $detail = DetailPeminjaman::find($id);

        if (!$detail) {
            return response()->json(['message' => 'Detail peminjaman tidak ditemukan'], 404);
        }

        $detail->delete();

        return response()->json(['message' => 'Detail peminjaman berhasil dihapus']);
    }
}
