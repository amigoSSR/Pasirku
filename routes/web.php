<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuUtamaController;
use App\Http\Controllers\MarketPlaceController;
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

use App\Http\Controllers\MessageController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/MenuUtama', [MenuUtamaController::class, 'index'])->name('MenuUtama');
    Route::get('/keranjang', fn() => view('keranjang'))->name('keranjang');
    Route::get('/Pesan', fn() => view('Pesan'))->name('Pesan');
    Route::get('/ordertracking', fn() => view('ordertracking'))->name('ordertracking');
    Route::get('/Profil', fn() => view('profil'))->name('Profil');

    // Chat API Routes
    Route::get('/chat/contacts', [MessageController::class, 'getContacts'])->name('chat.contacts');
    Route::get('/chat/messages/{user}', [MessageController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [MessageController::class, 'sendMessage'])->name('chat.send');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profil/logout', [ProfileController::class, 'logout'])->name('profil.logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/MarketPlace/{id}', [MarketPlaceController::class, 'show'])->name('MarketPlace');
});


require __DIR__.'/auth.php';
