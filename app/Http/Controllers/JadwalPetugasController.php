<?php

namespace App\Http\Controllers;

use App\Models\JadwalPetugas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalPetugasController extends Controller
{
    // GET semua jadwal
    public function tampilkanSemua()
    {
        $jadwal = JadwalPetugas::with('petugas')->get();
        return response()->json($jadwal);
    }

    // GET detail jadwal by ID
    public function tampilkanDetail($id)
    {
        $jadwal = JadwalPetugas::with('petugas')->find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json($jadwal);
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

        return response()->json($jadwal, 201);
    }

    // PUT update jadwal
    public function ubahJadwal(Request $request, $id)
    {
        $jadwal = JadwalPetugas::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
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

        return response()->json($jadwal);
    }

    // DELETE hapus jadwal
    public function hapusJadwal($id)
    {
        $jadwal = JadwalPetugas::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }
}
