<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    // GET semua denda
    public function tampilkanSemua()
    {
        $denda = Denda::with('peminjaman')->get();
        return response()->json($denda);
    }

    // GET detail denda by ID
    public function tampilkanDetail($id)
    {
        $denda = Denda::with('peminjaman')->find($id);

        if (!$denda) {
            return response()->json(['message' => 'Denda tidak ditemukan'], 404);
        }

        return response()->json($denda);
    }

    // POST tambah denda
    public function tambahDenda(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|integer|min:0',
            'tanggal_denda' => 'required|date',
        ]);

        // Ambil data peminjaman
        $peminjaman = \App\Models\Peminjaman::find($request->peminjaman_id);

        // Validasi: tanggal denda tidak boleh sebelum tanggal pinjam
        if ($request->tanggal_denda < $peminjaman->tgl_pinjam) {
            return response()->json([
                'message' => 'Tanggal denda tidak boleh lebih awal dari tanggal peminjaman'
            ], 422);
        }

        $denda = Denda::create($request->only([
            'peminjaman_id',
            'jumlah_denda',
            'tanggal_denda',
        ]));

        return response()->json([
            'message' => 'Denda berhasil ditambahkan',
            'data' => $denda
        ], 201);
    }


    // PUT update denda
    public function ubahDenda(Request $request, $id)
    {
        $denda = Denda::find($id);

        if (!$denda) {
            return response()->json(['message' => 'Denda tidak ditemukan'], 404);
        }

        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|integer|min:0',
            'tanggal_denda' => 'required|date',
        ]);

        $denda->update($request->only([
            'peminjaman_id',
            'jumlah_denda',
            'tanggal_denda',
        ]));

        return response()->json([
            'message' => 'Denda berhasil diperbarui',
            'data' => $denda
        ]);
    }

    // DELETE hapus denda
    public function hapusDenda($id)
    {
        $denda = Denda::find($id);

        if (!$denda) {
            return response()->json(['message' => 'Denda tidak ditemukan'], 404);
        }

        $denda->delete();

        return response()->json(['message' => 'Denda berhasil dihapus']);
    }
}
