<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/MenuUtama', fn() => view('MenuUtama'))->name('MenuUtama');
    Route::get('/keranjang', fn() => view('keranjang'))->name('keranjang');
    Route::get('/Pesan', fn() => view('Pesan'))->name('Pesan');
    Route::get('/ordertracking', fn() => view('ordertracking'))->name('ordertracking');
    Route::get('/Profil', fn() => view('profil'))->name('Profil');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
