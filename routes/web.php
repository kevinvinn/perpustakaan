<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// halaman login register
//Login
Route::get('/login', function() {
    return view('auth.login'); // Blade login
})->name('login');

// REGISTER sesuai role
Route::get('/register/admin', function () {
    return view('auth.register', ['role' => 'admin']);
})->name('registerAdmin');

Route::get('/register/petugas', function () {
    return view('auth.register', ['role' => 'petugas']);
})->name('registerPetugas');

Route::get('/register/anggota', function () {
    return view('auth.register', ['role' => 'anggota']);
})->name('registerAnggota');

//Halaman Home sesuai Role
Route::get('/admin/home', function () {
    return view('admin.home');
})->name('admin.home')->middleware(['auth', 'role:admin,petugas']);

Route::get('/anggota/home', function () {
    return view('anggota.home');
})->name('anggota.home')->middleware(['auth', 'role:anggota']);



// Pemanggilan Controller Backend
Route::post('/login', [AuthController::class, 'login'])->name('loginProcess');
Route::post('/register', [AuthController::class, 'register'])->name('registerProcess');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
