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
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with(['anggota', 'petugas'])->get();

        if ($request->wantsJson()) {
            return response()->json($peminjaman);
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    // GET detail peminjaman
    public function show(Request $request, $id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'petugas'])->find($id);

        if (!$peminjaman) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
            }
            return redirect()->route('peminjaman.index')->with('error', 'Data peminjaman tidak ditemukan');
        }

        if ($request->wantsJson()) {
            return response()->json($peminjaman);
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    // FORM create
    public function create()
    {
        return view('peminjaman.create');
    }

    // POST tambah peminjaman
    public function store(Request $request)
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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Peminjaman berhasil ditambahkan',
                'data' => $peminjaman
            ], 201);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
    }

    // FORM edit
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    // PUT update peminjaman
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
            }
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman tidak ditemukan');
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
                $tarifDendaPerHari = 2000; // contoh
                $jumlahDenda = $hariTerlambat * $tarifDendaPerHari;

                Denda::create([
                    'peminjaman_id' => $peminjaman->id,
                    'jumlah_denda' => $jumlahDenda,
                    'tanggal_denda' => now(),
                ]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Peminjaman berhasil diperbarui',
                'data' => $peminjaman
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui');
    }

    // DELETE hapus peminjaman
    public function destroy(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);

        if (!$peminjaman) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
            }
            return redirect()->route('peminjaman.index')->with('error', 'Peminjaman tidak ditemukan');
        }

        $peminjaman->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Peminjaman berhasil dihapus']);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}
