<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    // GET semua denda
    public function tampilkanSemua(Request $request)
    {
        $denda = Denda::with('peminjaman')->get();

        if ($request->wantsJson()) {
            return response()->json($denda);
        }

        return view('denda.index', compact('denda'));
    }

    // GET detail denda by ID
    public function tampilkanDetail(Request $request, $id)
    {
        $denda = Denda::with('peminjaman')->find($id);

        if (!$denda) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Denda tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Denda tidak ditemukan');
        }

        if ($request->wantsJson()) {
            return response()->json($denda);
        }

        return view('denda.show', compact('denda'));
    }

    // POST tambah denda
    public function tambahDenda(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|integer|min:0',
            'tanggal_denda' => 'required|date',
        ]);

        $peminjaman = Peminjaman::find($request->peminjaman_id);

        if ($request->tanggal_denda < $peminjaman->tgl_pinjam) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Tanggal denda tidak boleh lebih awal dari tanggal peminjaman'
                ], 422);
            }
            return redirect()->back()->with('error', 'Tanggal denda tidak boleh lebih awal dari tanggal peminjaman');
        }

        $denda = Denda::create($request->only(['peminjaman_id', 'jumlah_denda', 'tanggal_denda']));

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Denda berhasil ditambahkan',
                'data' => $denda
            ], 201);
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil ditambahkan');
    }

    // PUT update denda
    public function ubahDenda(Request $request, $id)
    {
        $denda = Denda::find($id);

        if (!$denda) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Denda tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Denda tidak ditemukan');
        }

        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah_denda' => 'required|integer|min:0',
            'tanggal_denda' => 'required|date',
        ]);

        $denda->update($request->only(['peminjaman_id', 'jumlah_denda', 'tanggal_denda']));

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Denda berhasil diperbarui',
                'data' => $denda
            ]);
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil diperbarui');
    }

    // DELETE hapus denda
    public function hapusDenda(Request $request, $id)
    {
        $denda = Denda::find($id);

        if (!$denda) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Denda tidak ditemukan'], 404);
            }
            return redirect()->back()->with('error', 'Denda tidak ditemukan');
        }

        $denda->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Denda berhasil dihapus']);
        }

        return redirect()->route('denda.index')->with('success', 'Denda berhasil dihapus');
    }
}
