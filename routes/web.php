<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuUtamaController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShoopeRegistryController;
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
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/menuutama', [AdminController::class, 'index'])->name('MenuUtamaAdmin');
    Route::get('/admin/shop-registration', [AdminController::class, 'shopeRegistry'])->name('ShopeRegistry');
    Route::get('/admin/user-registry', [ShoopeRegistryController::class, 'index'])->name('ShoopeRegistry');
    Route::get('/admin/profil', [AdminController::class, 'profile'])->name('ProfilAdmin');
    Route::put('/admin/shope-registry/{id}/toggle-status', [AdminController::class, 'toggleStatus'])
        ->name('admin.shope.toggleStatus');
    Route::get('/keranjang', fn() => view('keranjang'))->name('keranjang');
    Route::get('/Pesan', fn() => view('Pesan'))->name('Pesan');
    Route::get('/ordertracking', fn() => view('ordertracking'))->name('ordertracking');
    Route::get('/Profil', fn() => view('profil'))->name('Profil');
    Route::get('/daftarPenjual', fn() => view('daftarPenjual'))->name('daftarPenjual');
    Route::post('/daftarPenjual', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'Nama_Toko' => 'required',
            'Username' => 'required',
            'Lokasi_Toko' => 'required',
            'Email_Toko' => 'required',
            'Nomer_Telepon_Toko' => 'required',
            'Pendapatan_Toko' => 'required|numeric',
            'Total_Pembelian' => 'required|numeric',
            'Komisi_Admin' => 'required|numeric',
        ]);

        \Illuminate\Support\Facades\DB::table('informasi_toko')->insert([
            'ID_Akun' => \Illuminate\Support\Facades\Auth::id(),
            'Nama_Toko' => $request->Nama_Toko,
            'Username' => $request->Username,
            'Lokasi_Toko' => $request->Lokasi_Toko,
            'Email_Toko' => $request->Email_Toko,
            'Nomer_Telepon_Toko' => $request->Nomer_Telepon_Toko,
            'Pendapatan_Toko' => $request->Pendapatan_Toko,
            'Total_Pembelian' => $request->Total_Pembelian,
            'Komisi_Admin' => $request->Komisi_Admin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('Profil')->with('success', 'Berhasil mendaftar sebagai penjual!');
    })->name('daftarPenjual.store');

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
