{{--
  Shared Sidebar Component
  Digunakan di semua halaman utama agar posisi dan tampilan sidebar konsisten.
  Highlight menu otomatis berdasarkan route aktif.
--}}
<aside class="hidden md:flex flex-col h-full transition-all duration-300 bg-surface-container-lowest dark:bg-zinc-900 border-r border-outline-variant/30 dark:border-zinc-800 fixed left-0 top-[60px] bottom-0 z-40 py-6 shadow-sm overflow-hidden"
  :class="sidebarMinimized ? 'w-20' : 'w-64'">
  
  @php
    $isStore = \Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->Role === 'store' || \Illuminate\Support\Facades\Auth::user()->Role === 'seller');
    
    // Ambil data toko jika login sebagai seller
    $storeName = 'Pasirku';
    if ($isStore) {
        $toko = \App\Models\Toko::where('ID_Akun', \Illuminate\Support\Facades\Auth::id())->first();
        if ($toko) {
            $storeName = $toko->Nama_Toko;
        }
    }

    $menuUtamaRoute = $isStore ? route('MenuUtamaStore') : route('MenuUtama');
    $pesanRoute = $isStore ? route('PesanStore') : route('Pesan');
    $profilRoute = $isStore ? route('ProfilStore') : route('Profil');
    $orderRoute = $isStore ? route('ordertrackingStore') : route('ordertracking');

    $isMenuUtama = request()->routeIs('MenuUtama') || request()->routeIs('MenuUtamaStore');
    $isOrderTracking = request()->routeIs('ordertracking') || request()->routeIs('ordertrackingStore');
    $isRiwayat = !$isStore && request()->routeIs('riwayat');
    $isPesan = request()->routeIs('Pesan') || request()->routeIs('PesanStore');
    $isProfil = request()->routeIs('Profil') || request()->routeIs('ProfilStore');
    
    $monitoringPelangganRoute = $isStore ? route('MonitoringPelangganStore') : '#';
    $isMonitoringPelanggan = request()->routeIs('MonitoringPelangganStore');

    $tambahProdukRoute = $isStore ? route('tambahProduk') : '#';
    $isTambahProduk = request()->routeIs('tambahProduk');

    $stokPasirRoute = $isStore ? route('stokPasir') : '#';
    $isStokPasir = request()->routeIs('stokPasir');

    $qrisRoute = $isStore ? route('qrisStore') : '#';
    $isQris = request()->routeIs('qrisStore');

    // Cek apakah toko sudah punya QRIS aktif
    $hasQris = false;
    $hasKomisiWarning = false;
    if ($isStore) {
        $tokoForQris = \App\Models\Toko::where('ID_Akun', \Illuminate\Support\Facades\Auth::id())->first();
        if ($tokoForQris) {
            $hasQris = !empty($tokoForQris->Gambar_QRIS);
            $hasKomisiWarning = $tokoForQris->Komisi_Admin > 0 || $tokoForQris->isExpired() || $tokoForQris->isExpiringSoon();
        }
    }

    $bayarKomisiRoute = $isStore ? route('bayarKomisi') : '#';
    $isBayarKomisi = request()->routeIs('bayarKomisi');

    // Settings Route based on role
    $settingsRoute = '#';
    if ($isStore) {
        $settingsRoute = route('store.settings');
    } elseif (\Illuminate\Support\Facades\Auth::user()->Role === 'admin') {
        $settingsRoute = route('admin.settings');
    } else {
        $settingsRoute = route('user.settings');
    }
  @endphp

  <div class="px-6 mb-6 transition-all duration-300 relative" :class="sidebarMinimized ? 'px-0 flex justify-center' : 'px-6'">
    {{-- Small Discrete Toggle Button (Only visible when expanded) --}}
    <button x-show="!sidebarMinimized" @click="sidebarMinimized = true"
      class="absolute -right-2 top-0 w-8 h-8 flex items-center justify-center rounded-lg bg-surface-container-highest dark:bg-zinc-800 text-on-surface-variant dark:text-zinc-400 hover:bg-primary hover:text-on-primary transition-all duration-300 shadow-sm z-50 border border-outline-variant/30 dark:border-zinc-700"
      title="Minimize Sidebar">
      <span class="material-symbols-outlined text-[18px]">chevron_left</span>
    </button>

    {{-- Expanded Header --}}
    <div x-show="!sidebarMinimized" class="whitespace-nowrap pr-6">
      <h1 class="font-headline-md text-xl font-bold text-primary dark:text-primary-fixed-dim truncate" title="{{ $storeName }}">{{ $storeName }}</h1>
    </div>

    {{-- Minimized Logo (Acts as Expand Trigger) --}}
    <button x-show="sidebarMinimized" x-cloak @click="sidebarMinimized = false"
      class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-sm hover:scale-105 active:scale-95 transition-all cursor-pointer group"
      title="{{ $storeName }}">
      <span class="material-symbols-outlined text-[22px] group-hover:rotate-12 transition-transform" style="font-variation-settings:'FILL' 1">factory</span>
    </button>
  </div>

  <nav class="flex-1 space-y-1 overflow-y-auto overflow-x-hidden pb-10">

    {{-- Menu Utama --}}
    <a href="{{ $menuUtamaRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isMenuUtama
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isMenuUtama) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Dashboard' : ''">dashboard</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Dashboard</span>
    </a>

    {{-- Active Orders --}}
    <a href="{{ $orderRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isOrderTracking
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isOrderTracking) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Orders' : ''">local_shipping</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Orders</span>
    </a>

    {{-- Riwayat (User Only) --}}
    @if(!$isStore)
    <a href="{{ route('riwayat') }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group relative
        {{ $isRiwayat
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isRiwayat) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Riwayat' : ''">history</span>
      <span class="font-label-md text-sm flex-1 whitespace-nowrap" x-show="!sidebarMinimized">Riwayat</span>
      <span id="sidebar-riwayat-badge" class="hidden bg-error text-on-error text-2xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 transition-all border border-surface dark:border-zinc-900"
        :class="sidebarMinimized ? 'absolute top-2 right-2 scale-75' : 'ml-auto'">0</span>
    </a>
    @endif

    {{-- Messages --}}
    <a href="{{ $pesanRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group relative
        {{ $isPesan
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isPesan) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Messages' : ''">forum</span>
      <span class="font-label-md text-sm flex-1 whitespace-nowrap" x-show="!sidebarMinimized">Messages</span>
      <span id="sidebar-chat-badge" class="hidden bg-error text-on-error text-2xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0 transition-all border border-surface dark:border-zinc-900"
        :class="sidebarMinimized ? 'absolute top-2 right-2 scale-75' : 'ml-auto'">0</span>
    </a>

    {{-- Keranjang (User Only) --}}
    @if(!$isStore)
    @php $isKeranjang = request()->routeIs('keranjang'); @endphp
    <a href="{{ route('keranjang') }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isKeranjang
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isKeranjang) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Keranjang' : ''">shopping_cart</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Keranjang</span>
    </a>
    @endif

{{-- Monitoring Pelanggan --}}
    @if($isStore)
    <a href="{{ $monitoringPelangganRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isMonitoringPelanggan
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isMonitoringPelanggan) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Customers' : ''">group</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Customers</span>
    </a>
    @endif

    {{-- Tambah Produk --}}
    @if($isStore)
    <a href="{{ $tambahProdukRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isTambahProduk
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isTambahProduk) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Tambah Produk' : ''">add_box</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Tambah Produk</span>
    </a>
    @endif

    {{-- Stok Pasir --}}
    @if($isStore)
    <a href="{{ $stokPasirRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isStokPasir
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isStokPasir) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Stok Pasir' : ''">inventory_2</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Stok Pasir</span>
    </a>
    @endif

    {{-- Pembayaran QRIS --}}
    @if($isStore)
    <a href="{{ $qrisRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group relative
        {{ $isQris
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isQris) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Pembayaran QRIS' : ''">qr_code_scanner</span>
      <span class="font-label-md text-sm flex-1 whitespace-nowrap" x-show="!sidebarMinimized">Pembayaran QRIS</span>
      @if(!$hasQris)
        <span class="bg-error text-on-error text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shrink-0 animate-pulse transition-all border border-surface dark:border-zinc-900"
          :class="sidebarMinimized ? 'absolute top-2 right-2 scale-75' : 'ml-auto'" title="QRIS belum diunggah">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1, 'wght' 700">priority_high</span>
        </span>
      @endif
    </a>

    {{-- Bayar Komisi --}}
    <a href="{{ $bayarKomisiRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group relative
        {{ $isBayarKomisi
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isBayarKomisi) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Bayar Komisi' : ''">payments</span>
      <span class="font-label-md text-sm flex-1 whitespace-nowrap" x-show="!sidebarMinimized">Bayar Komisi</span>
      @if($hasKomisiWarning)
        <span class="bg-error text-on-error text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shrink-0 animate-pulse transition-all border border-surface dark:border-zinc-900"
          :class="sidebarMinimized ? 'absolute top-2 right-2 scale-75' : 'ml-auto'" title="Ada tagihan atau masa aktif hampir habis">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1, 'wght' 700">priority_high</span>
        </span>
      @endif
    </a>
    @endif

    {{-- Pengaturan Ongkir --}}
    @if($isStore)
    @php $isOngkir = request()->routeIs('shipping-rates.*'); @endphp
    <a href="{{ route('shipping-rates.index') }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isOngkir
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isOngkir) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Pengaturan Ongkir' : ''">local_shipping</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Pengaturan Ongkir</span>
    </a>
    @endif

    {{-- Profile --}}
    <a href="{{ $profilRoute }}"
      class="flex items-center transition-all duration-200 ease-in-out border-l-4 group
        {{ $isProfil
          ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold'
          : 'border-transparent text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50' }}"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" @if($isProfil) style="font-variation-settings: 'FILL' 1" @endif :title="sidebarMinimized ? 'Profile' : ''">person</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Profile</span>
    </a>

  </nav>



  <footer class="border-t border-outline-variant/30 dark:border-zinc-800 pt-4 pb-6 space-y-1">
    @php
      $isSettingsActive = request()->routeIs('store.settings') || request()->routeIs('admin.settings') || request()->routeIs('user.settings');
    @endphp
    <a href="{{ $settingsRoute }}" class="text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50 transition-all duration-200 ease-in-out border-l-4 {{ $isSettingsActive ? 'border-primary bg-primary-fixed/20 dark:bg-primary/20 text-primary dark:text-primary-fixed font-bold' : 'border-transparent' }} flex items-center group"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" data-icon="settings" :title="sidebarMinimized ? 'Settings' : ''" @if($isSettingsActive) style="font-variation-settings: 'FILL' 1" @endif>settings</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Settings</span>
    </a>
    <a href="#" class="text-on-surface-variant dark:text-zinc-400 hover:text-primary hover:bg-surface-container-low dark:hover:bg-zinc-800/50 transition-all duration-200 ease-in-out border-l-4 border-transparent flex items-center group"
      :class="sidebarMinimized ? 'justify-center px-0 py-4' : 'gap-4 px-6 py-3'">
      <span class="material-symbols-outlined text-[20px] shrink-0" data-icon="help" :title="sidebarMinimized ? 'Support' : ''">help</span>
      <span class="font-label-md text-sm whitespace-nowrap" x-show="!sidebarMinimized">Support</span>
    </a>
  </footer>

  {{-- Global Chat Notification Polling --}}

  {{-- Global Chat Notification Polling --}}
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const sidebarBadge = document.getElementById('sidebar-chat-badge');
      const mobileBadge = document.getElementById('mobile-chat-badge');

      function checkUnreadMessages() {
          fetch('/api/notifications/count', {
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(response => {
              if (!response.ok) throw new Error('Not logged in or network error');
              return response.json();
          })
          .then(data => {
              const count = data.count || 0;
              if (count > 0) {
                  if (sidebarBadge) {
                      sidebarBadge.textContent = count;
                      sidebarBadge.classList.remove('hidden');
                  }
                  if (mobileBadge) {
                      mobileBadge.textContent = count;
                      mobileBadge.classList.remove('hidden');
                  }
              } else {
                  if (sidebarBadge) sidebarBadge.classList.add('hidden');
                  if (mobileBadge) mobileBadge.classList.add('hidden');
              }
          })
          .catch(err => {
              // Silently catch exceptions for guest users or offline status
          });
      }

      // Check on load
      checkUnreadMessages();

      // Poll every 30 seconds
      setInterval(checkUnreadMessages, 30000);

      // ── Riwayat Notification Badge ──
      const sidebarRiwayatBadge = document.getElementById('sidebar-riwayat-badge');
      const mobileRiwayatBadge = document.getElementById('mobile-riwayat-badge');

      function checkRiwayatCount() {
          fetch('/api/riwayat/count', {
              headers: { 'X-Requested-With': 'XMLHttpRequest' }
          })
          .then(response => {
              if (!response.ok) throw new Error('error');
              return response.json();
          })
          .then(data => {
              const count = data.count || 0;
              if (count > 0) {
                  if (sidebarRiwayatBadge) {
                      sidebarRiwayatBadge.textContent = count > 99 ? '99+' : count;
                      sidebarRiwayatBadge.classList.remove('hidden');
                  }
                  if (mobileRiwayatBadge) {
                      mobileRiwayatBadge.textContent = count > 99 ? '99+' : count;
                      mobileRiwayatBadge.classList.remove('hidden');
                  }
              } else {
                  if (sidebarRiwayatBadge) sidebarRiwayatBadge.classList.add('hidden');
                  if (mobileRiwayatBadge) mobileRiwayatBadge.classList.add('hidden');
              }
          })
          .catch(() => {});
      }

      checkRiwayatCount();
      setInterval(checkRiwayatCount, 30000);
  });
  </script>

</aside>
