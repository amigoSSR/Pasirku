<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuUtamaController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShoopeRegistryController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QrisController;
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

use App\Http\Controllers\ChatController;

Route::middleware(['auth', 'verified'])->group(function () {

    // Store Routes
    Route::middleware(['role:store'])->group(function () {
        Route::get('/MenuUtamaStore', [MenuUtamaController::class, 'storeIndex'])->name('MenuUtamaStore');
        Route::get('/ProfilStore', fn() => view('tampilanPenjualStore.profilStore'))->name('ProfilStore');
        Route::get('/PesanStore', fn() => view('tampilanPenjualStore.PesanStore'))->name('PesanStore');
        Route::get('/ordertrackingStore', [OrderController::class, 'storeOrders'])->name('ordertrackingStore');
        Route::put('/ordertrackingStore/{id}/status', [OrderController::class, 'updateStatus'])->name('ordertrackingStore.updateStatus');
        Route::get('/MonitoringPelangganStore', fn() => view('tampilanPenjualStore.MonitoringPelanggan'))->name('MonitoringPelangganStore');
        Route::get('/tambahProduk', [ProdukController::class, 'create'])->name('tambahProduk');
        Route::post('/tambahProduk', [ProdukController::class, 'store'])->name('tambahProduk.store');
        
        // QRIS routes
        Route::get('/qrisStore', [QrisController::class, 'index'])->name('qrisStore');
        Route::put('/qrisStore', [QrisController::class, 'update'])->name('qrisStore.update');
        Route::delete('/qrisStore', [QrisController::class, 'destroy'])->name('qrisStore.destroy');

        // Stok Pasir
        Route::get('/stokPasir', [StokController::class, 'index'])->name('stokPasir');
        Route::get('/stokPasir/data', [StokController::class, 'data'])->name('stokPasir.data');
        Route::post('/stokPasir/tambah', [StokController::class, 'tambahStok'])->name('stokPasir.tambah');
        Route::post('/stokPasir/kurangi', [StokController::class, 'kurangiStok'])->name('stokPasir.kurangi');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/menuutama', [AdminController::class, 'index'])->name('MenuUtamaAdmin');
        Route::get('/admin/shop-registration', [AdminController::class, 'shopeRegistry'])->name('ShopeRegistry');
        Route::get('/admin/user-registry', [ShoopeRegistryController::class, 'index'])->name('ShoopeRegistry');
        Route::get('/admin/profil', [AdminController::class, 'profile'])->name('ProfilAdmin');
        Route::get('/admin/pesan', fn() => view('tampilanUntukAdmin.PesanAdmin'))->name('PesanAdmin');
        Route::put('/admin/shope-registry/{id}/toggle-status', [AdminController::class, 'toggleStatus'])
            ->name('admin.shope.toggleStatus');
    });

    // User Routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/MenuUtama', [MenuUtamaController::class, 'index'])->name('MenuUtama');
        Route::get('/keranjang', fn() => view('tampilaUntukUser.keranjang'))->name('keranjang');
        Route::get('/Pesan', fn() => view('tampilaUntukUser.Pesan'))->name('Pesan');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/ordertracking', [OrderController::class, 'userOrders'])->name('ordertracking');
        Route::get('/Profil', function () {
            $toko = \App\Models\Toko::where('ID_Akun', \Illuminate\Support\Facades\Auth::id())->latest('created_at')->first();
            return view('tampilaUntukUser.profil', compact('toko'));
        })->name('Profil');
        Route::get('/daftarPenjual', [\App\Http\Controllers\StoreRegistrationController::class, 'showForm'])
            ->name('daftarPenjual')
            ->middleware('check.store.registration');
        Route::post('/daftarPenjual', [\App\Http\Controllers\StoreRegistrationController::class, 'store'])
            ->name('daftarPenjual.store')
            ->middleware('check.store.registration');
    });

    // Chat API Routes
    Route::get('/chat/rooms', [ChatController::class, 'getRooms'])->name('chat.rooms');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/start/{id}', [ChatController::class, 'startChatWithToko'])->name('chat.start');

    // Public API for Checkout (Requires Auth)
    Route::get('/api/store/{id}/qris', [QrisController::class, 'getQrisUrl'])->name('api.store.qris');
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
