<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuUtamaController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShoopeRegistryController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QrisController;
use App\Http\Controllers\NotificationController;
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

    // Store & Admin Profile management
    Route::middleware(['role:store,admin'])->group(function () {
        Route::get('/ProfilStore', [\App\Http\Controllers\StoreProfileController::class, 'showProfile'])->name('ProfilStore');
        Route::post('/ProfilStore/info', [\App\Http\Controllers\StoreProfileController::class, 'updateGeneralInfo'])->name('ProfilStore.updateGeneralInfo');
        Route::post('/ProfilStore/alamat', [\App\Http\Controllers\StoreProfileController::class, 'updateAddress'])->name('ProfilStore.updateAddress');
        Route::post('/ProfilStore/foto', [\App\Http\Controllers\StoreProfileController::class, 'updatePhoto'])->name('ProfilStore.updatePhoto');
    });

    // Store Routes
    Route::middleware(['role:store'])->group(function () {
        Route::get('/MenuUtamaStore', [MenuUtamaController::class, 'storeIndex'])->name('MenuUtamaStore');
        Route::get('/store/dashboard/stats', [MenuUtamaController::class, 'statsApi'])->name('store.dashboard.stats');
        Route::get('/PesanStore', fn() => view('tampilanPenjualStore.PesanStore'))->name('PesanStore');
        Route::get('/ordertrackingStore', [OrderController::class, 'storeOrders'])->name('ordertrackingStore');
        Route::put('/ordertrackingStore/{id}/status', [OrderController::class, 'updateStatus'])->name('ordertrackingStore.updateStatus');
        Route::get('/ordertrackingStore/{id}/detail', [OrderController::class, 'storeOrderDetail'])->name('ordertrackingStore.detail');
        Route::get('/MonitoringPelangganStore', [MenuUtamaController::class, 'monitoringPelanggan'])->name('MonitoringPelangganStore');
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
        Route::post('/stokPasir/ongkir', [StokController::class, 'updateOngkir'])->name('stokPasir.updateOngkir');

        // Bayar Komisi
        Route::get('/bayarKomisi', [\App\Http\Controllers\KomisiController::class, 'index'])->name('bayarKomisi');
        Route::post('/bayarKomisi', [\App\Http\Controllers\KomisiController::class, 'store'])->name('bayarKomisi.store');

        // Store Settings
        Route::get('/store/settings', [\App\Http\Controllers\StoreProfileController::class, 'showSettings'])->name('store.settings');
    });
    // Admin Routes
    Route::middleware(['role:admin,cs'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/menuutama', [AdminController::class, 'index'])->name('MenuUtamaAdmin');
    Route::get('/admin/shop-registration', [AdminController::class, 'shopeRegistry'])->name('ShopeRegistry');
    Route::get('/admin/user-registry', [ShoopeRegistryController::class, 'index'])->name('UserRegistry');
    Route::put('/admin/user-registry/{id}/role', [ShoopeRegistryController::class, 'updateRole'])->name('admin.user.updateRole');
    Route::get('/admin/query-toko', [AdminController::class, 'queryToko'])->name('admin.queryToko');
    Route::get('/admin/profil', [AdminController::class, 'profile'])->name('ProfilAdmin');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/admin/pesan', fn() => view('tampilanUntukAdmin.PesanAdmin'))->name('PesanAdmin');
        Route::put('/admin/shope-registry/{id}/toggle-status', [AdminController::class, 'toggleStatus'])
            ->name('admin.shope.toggleStatus');
        Route::put('/admin/shope-registry/{id}/update-location', [AdminController::class, 'updateLocation'])
            ->name('admin.shope.updateLocation');
            
        // Komisi Management
        Route::post('/admin/upload-qris', [AdminController::class, 'uploadAdminQris'])->name('admin.uploadQris');
        Route::delete('/admin/delete-qris', [AdminController::class, 'deleteAdminQris'])->name('admin.deleteQris');
        Route::get('/admin/komisi', [AdminController::class, 'komisiPayments'])->name('admin.komisi');
        Route::put('/admin/komisi/{id}/confirm', [AdminController::class, 'confirmKomisi'])->name('admin.komisi.confirm');
        Route::put('/admin/komisi/{id}/reject', [AdminController::class, 'rejectKomisi'])->name('admin.komisi.reject');

    });

    // User Routes
    Route::middleware(['role:user'])->group(function () {
        Route::get('/MenuUtama', [MenuUtamaController::class, 'index'])->name('MenuUtama');
        Route::get('/nearby-stores', [MenuUtamaController::class, 'nearbyStores'])->name('nearby-stores');
        Route::get('/keranjang', fn() => view('tampilaUntukUser.keranjang'))->name('keranjang');
        Route::post('/keranjang/konfirmasi', [PesananController::class, 'store'])->name('pesanan.store');
        Route::get('/Pesan', fn() => view('tampilaUntukUser.Pesan'))->name('Pesan');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/ordertracking', [OrderController::class, 'userOrders'])->name('ordertracking');
        Route::put('/ordertracking/{id}/selesai', [OrderController::class, 'userCompleteOrder'])->name('ordertracking.selesai');
        Route::post('/ordertracking/{id}/report', [OrderController::class, 'reportOrder'])->name('ordertracking.report');
        Route::get('/riwayat', [OrderController::class, 'userHistory'])->name('riwayat');
        Route::get('/Profil', function () {
            $toko = \App\Models\Toko::where('ID_Akun', \Illuminate\Support\Facades\Auth::id())->latest('created_at')->first();
            return view('tampilaUntukUser.profil', compact('toko'));
        })->name('Profil');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('user.settings');
        Route::patch('/settings/location', [ProfileController::class, 'updateLocation'])->name('profile.update-location');
        Route::get('/daftarPenjual', [\App\Http\Controllers\StoreRegistrationController::class, 'showForm'])
            ->name('daftarPenjual')
            ->middleware('check.store.registration');
        Route::post('/daftarPenjual', [\App\Http\Controllers\StoreRegistrationController::class, 'store'])
            ->name('daftarPenjual.store')
            ->middleware('check.store.registration');

        // Shipping Rate Routes
        Route::get('/shipping-rates', [\App\Http\Controllers\ShippingRateController::class, 'index'])->name('shipping-rates.index');
        Route::post('/shipping-rates', [\App\Http\Controllers\ShippingRateController::class, 'store'])->name('shipping-rates.store');
        Route::put('/shipping-rates/{id}', [\App\Http\Controllers\ShippingRateController::class, 'update'])->name('shipping-rates.update');
        Route::patch('/shipping-rates/{id}/toggle', [\App\Http\Controllers\ShippingRateController::class, 'toggleStatus'])->name('shipping-rates.toggle');
        Route::delete('/shipping-rates/{id}', [\App\Http\Controllers\ShippingRateController::class, 'destroy'])->name('shipping-rates.destroy');

        // Review Routes
        Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{id}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    });

    // Store API Routes
    Route::get('/api/store/{id}/qris', [Toko::class, 'getQrisApi']); // Assuming this is defined somewhere or moved
    Route::get('/api/store/{id}/shipping-rates', function($id) {
        $toko = \App\Models\Toko::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $toko->shippingRates()->where('is_active', true)->get()
        ]);
    });
    Route::get('/chat/rooms', [ChatController::class, 'getRooms'])->name('chat.rooms');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/start/{id}', [ChatController::class, 'startChatWithToko'])->name('chat.start');
    Route::get('/chat/admin', [ChatController::class, 'startChatWithAdmin'])->name('chat.admin');

    // Notification API
    Route::get('/api/notifications/count', [NotificationController::class, 'unreadCount'])->name('api.notifications.count');
    Route::get('/api/riwayat/count', [NotificationController::class, 'riwayatCount'])->name('api.riwayat.count');

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
    Route::post('/api/products/check-stock', [MarketPlaceController::class, 'checkStock'])->name('api.products.checkStock');
    // Serve gambar bukti pembayaran dengan HTTP cache headers
    Route::get('/bukti-pembayaran/{filename}', [PesananController::class, 'serveImage'])
         ->name('bukti.image')
         ->where('filename', '.+\.(png|webp)');
});


require __DIR__.'/auth.php';
