<?php

namespace App\Http\Controllers;

use App\Models\JadwalPetugas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalPetugasController extends Controller
{
    // GET semua jadwal
    public function tampilkanSemua(Request $request)
    {
        $jadwal = JadwalPetugas::with('petugas')->get();

        if ($request->wantsJson()) {
            return response()->json($jadwal);
        }

        return view('jadwal.index', compact('jadwal'));
    }

    // GET detail jadwal by ID
    public function tampilkanDetail(Request $request, $id)
    {
        $jadwal = JadwalPetugas::with('petugas')->find($id);

        if (!$jadwal) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
            }
            return redirect()->route('jadwal.index')->with('error', 'Jadwal tidak ditemukan');
        }

        if ($request->wantsJson()) {
            return response()->json($jadwal);
        }

        return view('jadwal.show', compact('jadwal'));
    }

    // POST tambah jadwal petugas
    public function tambahJadwal(Request $request)
    {
        $request->validate([
            'petugas_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'petugas')
            ],
            'tanggal' => 'required|date',
            'shift' => 'required|in:Shift 1 (07.00 - 15.00),Shift 2 (15.00 - 23.00)',
        ]);

        $jadwal = JadwalPetugas::create($request->only(['petugas_id', 'tanggal', 'shift']));

        if ($request->wantsJson()) {
            return response()->json($jadwal, 201);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // PUT update jadwal
    public function ubahJadwal(Request $request, $id)
    {
        $jadwal = JadwalPetugas::find($id);

        if (!$jadwal) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
            }
            return redirect()->route('jadwal.index')->with('error', 'Jadwal tidak ditemukan');
        }

        $request->validate([
            'petugas_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'petugas')
            ],
            'tanggal' => 'required|date',
            'shift' => 'required|in:Shift 1 (07.00 - 15.00),Shift 2 (15.00 - 23.00)',
        ]);

        $jadwal->update($request->only(['petugas_id', 'tanggal', 'shift']));

        if ($request->wantsJson()) {
            return response()->json($jadwal);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    // DELETE hapus jadwal
    public function hapusJadwal(Request $request, $id)
    {
        $jadwal = JadwalPetugas::find($id);

        if (!$jadwal) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
            }
            return redirect()->route('jadwal.index')->with('error', 'Jadwal tidak ditemukan');
        }

        $jadwal->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Jadwal berhasil dihapus']);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
