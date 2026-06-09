{{--
  Shared Sidebar Component
  Digunakan di semua halaman utama agar posisi dan tampilan sidebar konsisten.
  Highlight menu otomatis berdasarkan route aktif.
--}}
<aside class="hidden md:flex flex-col h-full w-64 bg-surface-container-lowest border-r border-outline-variant/30 fixed left-0 top-[60px] bottom-0 z-40 py-6 shadow-sm">
  
  @php
    $isStore = \Illuminate\Support\Facades\Auth::check() && (\Illuminate\Support\Facades\Auth::user()->Role === 'store' || \Illuminate\Support\Facades\Auth::user()->Role === 'seller');
    
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
  @endphp

  <div class="px-6 mb-8">
    <h1 class="font-headline-md text-xl font-bold text-primary">Industrial Hub</h1>
    <p class="font-label-md text-xs font-semibold text-on-surface-variant tracking-wider uppercase mt-1">
      {{ $isStore ? 'Seller Portal' : 'Customer Portal' }}
    </p>
  </div>

  <nav class="flex-1 space-y-1">

    {{-- Menu Utama --}}
    <a href="{{ $menuUtamaRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isMenuUtama
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isMenuUtama) style="font-variation-settings: 'FILL' 1" @endif>dashboard</span>
      <span class="font-label-md text-sm">Dashboard</span>
    </a>

    {{-- Active Orders --}}
    <a href="{{ $orderRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isOrderTracking
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isOrderTracking) style="font-variation-settings: 'FILL' 1" @endif>local_shipping</span>
      <span class="font-label-md text-sm">Orders</span>
    </a>

    {{-- Riwayat (User Only) --}}
    @if(!$isStore)
    <a href="{{ route('riwayat') }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isRiwayat
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isRiwayat) style="font-variation-settings: 'FILL' 1" @endif>history</span>
      <span class="font-label-md text-sm flex-1">Riwayat</span>
      <span id="sidebar-riwayat-badge" class="hidden ml-auto bg-error text-on-error text-2xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0">0</span>
    </a>
    @endif

    {{-- Messages --}}
    <a href="{{ $pesanRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isPesan
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isPesan) style="font-variation-settings: 'FILL' 1" @endif>forum</span>
      <span class="font-label-md text-sm flex-1">Messages</span>
      <span id="sidebar-chat-badge" class="hidden ml-auto bg-error text-on-error text-2xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0">0</span>
    </a>

    {{-- Keranjang (User Only) --}}
    @if(!$isStore)
    @php $isKeranjang = request()->routeIs('keranjang'); @endphp
    <a href="{{ route('keranjang') }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isKeranjang
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isKeranjang) style="font-variation-settings: 'FILL' 1" @endif>shopping_cart</span>
      <span class="font-label-md text-sm">Keranjang</span>
    </a>
    @endif

{{-- Monitoring Pelanggan --}}
    @if($isStore)
    <a href="{{ $monitoringPelangganRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isMonitoringPelanggan
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isMonitoringPelanggan) style="font-variation-settings: 'FILL' 1" @endif>group</span>
      <span class="font-label-md text-sm">Customers</span>
    </a>
    @endif

    {{-- Tambah Produk --}}
    @if($isStore)
    <a href="{{ $tambahProdukRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isTambahProduk
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isTambahProduk) style="font-variation-settings: 'FILL' 1" @endif>add_box</span>
      <span class="font-label-md text-sm">Tambah Produk</span>
    </a>
    @endif

    {{-- Stok Pasir --}}
    @if($isStore)
    <a href="{{ $stokPasirRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isStokPasir
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isStokPasir) style="font-variation-settings: 'FILL' 1" @endif>inventory_2</span>
      <span class="font-label-md text-sm">Stok Pasir</span>
    </a>
    @endif

    {{-- Pembayaran QRIS --}}
    @if($isStore)
    <a href="{{ $qrisRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isQris
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isQris) style="font-variation-settings: 'FILL' 1" @endif>qr_code_scanner</span>
      <span class="font-label-md text-sm">Pembayaran QRIS</span>
    </a>
    @endif

    {{-- Pengaturan Ongkir --}}
    @if($isStore)
    @php $isOngkir = request()->routeIs('shipping-rates.*'); @endphp
    <a href="{{ route('shipping-rates.index') }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isOngkir
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isOngkir) style="font-variation-settings: 'FILL' 1" @endif>local_shipping</span>
      <span class="font-label-md text-sm">Pengaturan Ongkir</span>
    </a>
    @endif

    {{-- Profile --}}
    <a href="{{ $profilRoute }}"
      class="flex items-center gap-4 px-6 py-3 transition-all duration-200 ease-in-out border-l-4
        {{ $isProfil
          ? 'border-primary bg-primary-fixed/20 text-primary font-bold'
          : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
      <span class="material-symbols-outlined text-[20px]" @if($isProfil) style="font-variation-settings: 'FILL' 1" @endif>person</span>
      <span class="font-label-md text-sm">Profile</span>
    </a>

  </nav>



  <footer class="border-t border-outline-variant/30 pt-4 space-y-1">
    <a href="#" class="text-on-surface-variant hover:text-primary hover:bg-surface-container-low px-6 py-3 flex items-center gap-4 transition-all duration-200 ease-in-out border-l-4 border-transparent">
      <span class="material-symbols-outlined text-[20px]" data-icon="settings">settings</span>
      <span class="font-label-md text-sm">Settings</span>
    </a>
    <a href="#" class="text-on-surface-variant hover:text-primary hover:bg-surface-container-low px-6 py-3 flex items-center gap-4 transition-all duration-200 ease-in-out border-l-4 border-transparent">
      <span class="material-symbols-outlined text-[20px]" data-icon="help">help</span>
      <span class="font-label-md text-sm">Support</span>
    </a>
  </footer>

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
