<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class DetailPeminjamanController extends Controller
{
    // GET semua detail peminjaman
    public function tampilkanSemua(Request $request)
    {
        $detail = DetailPeminjaman::with(['peminjaman', 'buku'])->get();

        // Jika request ingin JSON (API)
        if ($request->wantsJson()) {
            return response()->json($detail);
        }

        // Jika request dari web
        return view('detailpeminjaman.index', compact('detail'));
    }

    // GET detail by ID
    public function tampilkanDetail(Request $request, $id)
    {
        $detail = DetailPeminjaman::with(['peminjaman', 'buku'])->find($id);

        if (!$detail) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Detail peminjaman tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Detail peminjaman tidak ditemukan');
        }

        if ($request->wantsJson()) {
            return response()->json($detail);
        }

        return view('detailpeminjaman.show', compact('detail'));
    }

    // POST tambah detail peminjaman
    public function tambahDetail(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'buku_id' => 'required|exists:buku,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $buku = Buku::find($request->buku_id);

        if ($request->jumlah > $buku->stok) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Jumlah buku melebihi stok tersedia',
                    'stok_tersedia' => $buku->stok
                ], 400);
            }
            return redirect()->back()->with('error', 'Jumlah buku melebihi stok tersedia. Stok: '.$buku->stok);
        }

        $detail = DetailPeminjaman::create($request->only([
            'peminjaman_id',
            'buku_id',
            'jumlah',
        ]));

        $buku->stok -= $request->jumlah;
        $buku->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Detail peminjaman berhasil ditambahkan',
                'data' => $detail
            ], 201);
        }

        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil ditambahkan');
    }

    // PUT update detail peminjaman
    public function ubahDetail(Request $request, $id)
    {
        $detail = DetailPeminjaman::find($id);

        if (!$detail) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Detail peminjaman tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Detail peminjaman tidak ditemukan');
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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Detail peminjaman berhasil diperbarui',
                'data' => $detail
            ]);
        }

        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil diperbarui');
    }

    // DELETE hapus detail peminjaman
    public function hapusDetail(Request $request, $id)
    {
        $detail = DetailPeminjaman::find($id);

        if (!$detail) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Detail peminjaman tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Detail peminjaman tidak ditemukan');
        }

        $detail->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Detail peminjaman berhasil dihapus']);
        }

        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil dihapus');
    }
}
