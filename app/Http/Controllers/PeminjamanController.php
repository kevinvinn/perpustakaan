<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // GET semua peminjaman
    public function tampilkanSemua()
    {
        $peminjaman = Peminjaman::with(['anggota', 'petugas'])->get();
        return response()->json($peminjaman);
    }

    // GET detail peminjaman by ID
    public function tampilkanDetail($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'petugas'])->find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        return response()->json($peminjaman);
    }

    // POST tambah peminjaman
    public function tambahPeminjaman(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'petugas_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'petugas')
            ],
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
        ]);

        $peminjaman = Peminjaman::create($request->only([
            'anggota_id',
            'petugas_id',
            'tgl_pinjam',
            'tgl_kembali',
            'status',
        ]));

        return response()->json([
            'message' => 'Peminjaman berhasil ditambahkan',
            'data' => $peminjaman
        ], 201);
    }

    // PUT update peminjaman
    public function ubahPeminjaman(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'petugas_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'petugas')
            ],
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tgl_pinjam',
        ]);

        $peminjaman->update($request->only([
            'anggota_id',
            'petugas_id',
            'tgl_pinjam',
            'tgl_kembali',
            'status',
            'tanggal_pengembalian'
        ]));

        // 🚨 Cek keterlambatan → buat denda otomatis
        if ($request->filled('tanggal_pengembalian')) {
            $tglKembali = Carbon::parse($peminjaman->tgl_kembali);
            $tglPengembalian = Carbon::parse($request->tanggal_pengembalian);

            if ($tglPengembalian->greaterThan($tglKembali)) {
                $hariTerlambat = $tglKembali->diffInDays($tglPengembalian);
                $tarifDendaPerHari = 2000; // contoh: 2000 rupiah per hari
                $jumlahDenda = $hariTerlambat * $tarifDendaPerHari;

                Denda::create([
                    'peminjaman_id' => $peminjaman->id,
                    'jumlah_denda' => $jumlahDenda,
                    'tanggal_denda' => now(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Peminjaman berhasil diperbarui',
            'data' => $peminjaman
        ]);
    }

    // DELETE hapus peminjaman
    public function hapusPeminjaman($id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman berhasil dihapus']);
    }
}
