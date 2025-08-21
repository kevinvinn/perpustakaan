<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    Route::get('/', fn () => view('login'))->name('loginPage');
    Route::get('/login', fn() => view('login'))->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/home', fn() => view('home'))->name('home');
    Route::get('/register', fn() => view('register'))->name('registerPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
