<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\JadwalPetugasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DetailPeminjamanController;
use App\Http\Controllers\DendaController;

//Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


//Users
Route::get('/users', [UserController::class, 'tampilkanSemua']);    // GET semua user
Route::get('/users/{id}', [UserController::class, 'tampilkanDetail']); // GET user by ID
Route::post('/users', [UserController::class, 'tambahUser']);       // POST tambah user
Route::put('/users/{id}', [UserController::class, 'ubahUser']);     // PUT ubah user
Route::delete('/users/{id}', [UserController::class, 'hapusUser']); // DELETE hapus user

// Kategori
Route::get('/kategori', [KategoriController::class, 'tampilkanSemua']);    // GET semua kategori
Route::get('/kategori/{id}', [KategoriController::class, 'tampilkanDetail']); // GET kategori by ID
Route::post('/kategori', [KategoriController::class, 'tambahKategori']);       // POST tambah kategori
Route::put('/kategori/{id}', [KategoriController::class, 'ubahKategori']);     // PUT ubah kategori
Route::delete('/kategori/{id}', [KategoriController::class, 'hapusKategori']); // DELETE hapus kategori

//Buku
Route::get('/buku', [BukuController::class, 'tampilkanSemua']);
Route::get('/buku/{id}', [BukuController::class, 'tampilkanDetail']);
Route::post('/buku', [BukuController::class, 'tambahBuku']);
Route::put('/buku/{id}', [BukuController::class, 'ubahBuku']);
Route::delete('/buku/{id}', [BukuController::class, 'hapusBuku']);

//Anggota
Route::get('/anggota', [AnggotaController::class, 'tampilkanSemua']);
Route::get('/anggota/{id}', [AnggotaController::class, 'tampilkanDetail']);
Route::post('/anggota', [AnggotaController::class, 'tambahAnggota']);
Route::put('/anggota/{id}', [AnggotaController::class, 'ubahAnggota']);
Route::delete('/anggota/{id}', [AnggotaController::class, 'hapusAnggota']);

//JadwalPetugas
Route::get('/jadwal-petugas', [JadwalPetugasController::class, 'tampilkanSemua']);
Route::get('/jadwal-petugas/{id}', [JadwalPetugasController::class, 'tampilkanDetail']);
Route::post('/jadwal-petugas', [JadwalPetugasController::class, 'tambahJadwal']);
Route::put('/jadwal-petugas/{id}', [JadwalPetugasController::class, 'ubahJadwal']);
Route::delete('/jadwal-petugas/{id}', [JadwalPetugasController::class, 'hapusJadwal']);

//Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'tampilkanSemua']);     // GET semua peminjaman
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'tampilkanDetail']); // GET detail peminjaman
Route::post('/peminjaman', [PeminjamanController::class, 'tambahPeminjaman']);   // POST tambah peminjaman
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'ubahPeminjaman']); // PUT ubah peminjaman
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'hapusPeminjaman']); // DELETE hapus peminjaman

//Detail-Peminjaman
Route::get('/detail-peminjaman', [DetailPeminjamanController::class, 'tampilkanSemua']);
Route::get('/detail-peminjaman/{id}', [DetailPeminjamanController::class, 'tampilkanDetail']);
Route::post('/detail-peminjaman', [DetailPeminjamanController::class, 'tambahDetail']);
Route::put('/detail-peminjaman/{id}', [DetailPeminjamanController::class, 'ubahDetail']);
Route::delete('/detail-peminjaman/{id}', [DetailPeminjamanController::class, 'hapusDetail']);

// Denda
Route::get('/denda', [DendaController::class, 'tampilkanSemua']);
Route::get('/denda/{id}', [DendaController::class, 'tampilkanDetail']);
Route::post('/denda', [DendaController::class, 'tambahDenda']);
Route::put('/denda/{id}', [DendaController::class, 'ubahDenda']);
Route::delete('/denda/{id}', [DendaController::class, 'hapusDenda']);
