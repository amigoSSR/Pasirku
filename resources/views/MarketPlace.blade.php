<!doctype html>
<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>MarketPlace</title>
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Public+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet" />
  <!-- Material Symbols -->
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "surface-variant": "#d3e4fe",
            "on-surface": "#0b1c30",
            "on-secondary-fixed-variant": "#623f18",
            "primary-container": "#005fb8",
            "on-background": "#0b1c30",
            "on-tertiary-container": "#fcd1c4",
            surface: "#f8f9ff",
            "surface-dim": "#cbdbf5",
            secondary: "#7d562d",
            "surface-container-low": "#eff4ff",
            "on-primary-fixed": "#001b3d",
            "inverse-on-surface": "#eaf1ff",
            "surface-tint": "#005db5",
            "inverse-surface": "#213145",
            outline: "#727783",
            "on-primary-fixed-variant": "#00468b",
            "on-tertiary-fixed-variant": "#5d4037",
            "tertiary-container": "#78584e",
            background: "#f8f9ff",
            error: "#ba1a1a",
            "on-primary": "#ffffff",
            "surface-container-highest": "#d3e4fe",
            "on-secondary": "#ffffff",
            "primary-fixed": "#d6e3ff",
            "on-secondary-container": "#7a532a",
            "on-error-container": "#93000a",
            "surface-container-lowest": "#ffffff",
            "secondary-fixed-dim": "#f0bd8b",
            "tertiary-fixed-dim": "#e7bdb1",
            "on-primary-container": "#cadcff",
            "error-container": "#ffdad6",
            "on-secondary-fixed": "#2c1600",
            "primary-fixed-dim": "#a8c8ff",
            "surface-container": "#e5eeff",
            "on-surface-variant": "#424752",
            "secondary-container": "#ffca98",
            "surface-container-high": "#dce9ff",
            "on-tertiary-fixed": "#2c160e",
            primary: "#00488d",
            "outline-variant": "#c2c6d4",
            "surface-bright": "#f8f9ff",
            tertiary: "#5e4138",
            "inverse-primary": "#a8c8ff",
            "secondary-fixed": "#ffdcbd",
            "on-tertiary": "#ffffff",
            "tertiary-fixed": "#ffdbd0",
            "on-error": "#ffffff",
          },
          borderRadius: {
            DEFAULT: "0.125rem",
            lg: "0.25rem",
            xl: "0.5rem",
            full: "0.75rem",
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Public Sans"],
            label: ["Public Sans"],
          },
        },
      },
    };
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
    }
    body { font-family: "Public Sans", sans-serif; }
    h1, h2, h3, .headline { font-family: "Manrope", sans-serif; }
    .glass-nav { backdrop-filter: blur(20px); }

    /* Quantity button transition */
    .qty-control { transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1); }

    /* ===== Floating Cart FAB ===== */
    #cart-fab {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      z-index: 9999;
      /* Circle shape */
      width: 64px;
      height: 64px;
      border-radius: 50%;
      /* Color */
      background: #00488d;
      box-shadow: 0 6px 24px rgba(0,72,141,0.5);
      /* Center content */
      display: none;          /* hidden by default — shown via JS */
      align-items: center;
      justify-content: center;
      /* Interaction */
      cursor: pointer;
      user-select: none;
      transition: transform 0.18s cubic-bezier(0.34,1.56,0.64,1),
                  box-shadow 0.18s ease;
    }
    #cart-fab:hover  { transform: scale(1.12); box-shadow: 0 10px 32px rgba(0,72,141,0.65); }
    #cart-fab:active { transform: scale(0.92); }

    /* Pop-in animation when first shown */
    @keyframes fabPopIn {
      0%   { transform: scale(0.4); opacity: 0; }
      70%  { transform: scale(1.1); opacity: 1; }
      100% { transform: scale(1);   opacity: 1; }
    }
    #cart-fab.pop-in { animation: fabPopIn 0.35s cubic-bezier(0.34,1.56,0.64,1) both; }

    /* Badge bounce */
    @keyframes badgeBounce {
      0%, 100% { transform: scale(1); }
      40%       { transform: scale(1.5); }
      70%       { transform: scale(0.85); }
    }
    #cart-fab-badge.bounce { animation: badgeBounce 0.35s ease; }

    /* Ripple / ping ring around FAB */
    @keyframes fabPing {
      0%   { transform: scale(1);    opacity: 0.6; }
      100% { transform: scale(1.75); opacity: 0; }
    }
    #cart-fab-ring {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      z-index: 9998;               /* behind the FAB */
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: rgba(0, 72, 141, 0.35);
      display: none;               /* toggled with FAB */
      animation: fabPing 1.4s ease-out infinite;
      pointer-events: none;
    }
  </style>
</head>

<body class="bg-surface text-on-surface overflow-x-hidden">
  @include('topbar')
  <div class="flex h-screen pt-[60px]">
    <x-sidebar />
    <main class="flex-1 md:ml-64 flex flex-col p-4 md:p-8 overflow-y-auto bg-surface">

      <!-- ── Store Header ── -->
      <header class="mb-8 relative overflow-hidden bg-primary text-on-primary rounded-3xl p-8 shadow-lg">
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-primary-fixed/20 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-secondary-fixed/20 blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
          <div>
            <span class="text-sm font-bold text-primary-fixed uppercase tracking-widest mb-2 block flex items-center gap-2">
              <span class="material-symbols-outlined text-[16px]">storefront</span>
              Profil Toko
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-md">
              {{ $toko->Nama_Toko }}
            </h1>
            <div class="flex flex-wrap gap-3 text-sm text-on-primary">
              <div class="flex items-center gap-1.5 bg-on-primary/10 backdrop-blur-md py-1.5 px-4 rounded-full border border-on-primary/10">
                <span class="material-symbols-outlined text-[18px]">location_on</span>
                {{ $toko->Lokasi_Toko }}
              </div>
              <div class="flex items-center gap-1.5 bg-on-primary/10 backdrop-blur-md py-1.5 px-4 rounded-full border border-on-primary/10">
                <span class="material-symbols-outlined text-[18px]">call</span>
                {{ $toko->Nomer_Telepon_Toko }}
              </div>
            </div>
          </div>
          <div class="flex gap-3">
            <button class="bg-surface text-primary py-2 px-5 rounded-full font-bold hover:bg-surface-container-lowest transition-all hover:shadow-md hover:-translate-y-0.5 flex items-center gap-2">
              <span class="material-symbols-outlined text-[20px]">chat</span>
              Chat Toko
            </button>
          </div>
        </div>
      </header>

      <!-- ── Product Count ── -->
      <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-on-surface">Produk Tersedia</h2>
        <div class="text-sm text-on-surface-variant bg-surface-container py-1 px-4 rounded-full font-semibold">
          {{ $isiToko->count() }} Produk
        </div>
      </div>

      <!-- ── Product Grid ── -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
        @forelse($isiToko as $produk)
          <div class="group bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 hover:shadow-xl hover:border-primary/30 transition-all duration-300 flex flex-col overflow-hidden hover:-translate-y-1">

            <!-- Product Header -->
            <div class="bg-gradient-to-br from-surface-container to-surface-container-high flex items-center justify-center relative overflow-hidden h-40 group-hover:from-primary-container/30 group-hover:to-primary-container/10 transition-colors duration-300 p-4">
              <span class="material-symbols-outlined text-8xl text-primary/25 group-hover:text-primary/60 transition-all duration-300 group-hover:scale-110 transform">landscape</span>
              <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-on-surface/60 to-transparent p-4">
                <h3 class="font-extrabold text-xl text-white tracking-tight drop-shadow-md">{{ $produk->Nama_Pasir }}</h3>
              </div>
            </div>

            <!-- Pricing -->
            <div class="p-4 flex flex-col flex-1 gap-3">

              <!-- Pick Up -->
              <div class="bg-blue-50 border border-blue-100 rounded-2xl p-3 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-1">
                  <span class="material-symbols-outlined text-[18px] text-blue-600">directions_car</span>
                  <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Mobil Pick Up</span>
                </div>
                <div class="flex items-end justify-between">
                  <div>
                    <div class="text-[10px] text-blue-400 uppercase font-semibold">Harga</div>
                    <div class="text-xl font-extrabold text-blue-800 tracking-tight">
                      Rp {{ number_format($produk->Harga_PickUp, 0, ',', '.') }}
                    </div>
                  </div>
                  <div class="flex items-center gap-1.5 bg-white/80 py-1 px-2.5 rounded-full border border-blue-100">
                    <span class="w-2 h-2 rounded-full {{ $produk->Stock_PickUp > 0 ? 'bg-green-500 animate-pulse' : 'bg-red-400' }}"></span>
                    <span class="text-xs font-bold text-slate-600">Sisa {{ $produk->Stock_PickUp }}</span>
                  </div>
                </div>
                <div class="relative mt-1 min-h-[38px]">
                  @if($produk->Stock_PickUp > 0)
                  <button
                    id="btn-add-pickup-{{ $produk->ID_Isi_Toko }}"
                    onclick="addToCart('{{ $produk->ID_Isi_Toko }}', 'pickup', {{ $produk->Harga_PickUp }}, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}')"
                    class="qty-control w-full bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-1.5 active:scale-95 duration-200">
                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                    Pesan Pick Up
                  </button>
                  <div id="qty-pickup-{{ $produk->ID_Isi_Toko }}"
                       class="qty-control hidden w-full flex items-center justify-between bg-blue-600 text-white rounded-xl overflow-hidden">
                    <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'pickup', -1, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_PickUp }})"
                            class="px-4 py-2 text-lg font-black hover:bg-blue-700 transition-colors active:bg-blue-800 select-none">−</button>
                    <span id="qty-num-pickup-{{ $produk->ID_Isi_Toko }}" class="font-bold text-base">1</span>
                    <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'pickup', +1, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_PickUp }})"
                            class="px-4 py-2 text-lg font-black hover:bg-blue-700 transition-colors active:bg-blue-800 select-none">+</button>
                  </div>
                  @else
                  <button disabled class="w-full bg-blue-300 text-white py-2 rounded-xl text-sm font-semibold flex items-center justify-center gap-1.5 opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[16px]">remove_shopping_cart</span>
                    Stok Habis
                  </button>
                  @endif
                </div>
              </div>

              <!-- Truck -->
              <div class="bg-amber-50 border border-amber-100 rounded-2xl p-3 flex flex-col gap-2">
                <div class="flex items-center gap-2 mb-1">
                  <span class="material-symbols-outlined text-[18px] text-amber-600">local_shipping</span>
                  <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Truk</span>
                </div>
                <div class="flex items-end justify-between">
                  <div>
                    <div class="text-[10px] text-amber-400 uppercase font-semibold">Harga</div>
                    <div class="text-xl font-extrabold text-amber-800 tracking-tight">
                      Rp {{ number_format($produk->Harga_Truck, 0, ',', '.') }}
                    </div>
                  </div>
                  <div class="flex items-center gap-1.5 bg-white/80 py-1 px-2.5 rounded-full border border-amber-100">
                    <span class="w-2 h-2 rounded-full {{ $produk->Stock_Truck > 0 ? 'bg-green-500 animate-pulse' : 'bg-red-400' }}"></span>
                    <span class="text-xs font-bold text-slate-600">Sisa {{ $produk->Stock_Truck }}</span>
                  </div>
                </div>
                <div class="relative mt-1 min-h-[38px]">
                  @if($produk->Stock_Truck > 0)
                  <button
                    id="btn-add-truck-{{ $produk->ID_Isi_Toko }}"
                    onclick="addToCart('{{ $produk->ID_Isi_Toko }}', 'truck', {{ $produk->Harga_Truck }}, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}')"
                    class="qty-control w-full bg-amber-500 text-white py-2 rounded-xl text-sm font-semibold hover:bg-amber-600 transition-colors flex items-center justify-center gap-1.5 active:scale-95 duration-200">
                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                    Pesan Truk
                  </button>
                  <div id="qty-truck-{{ $produk->ID_Isi_Toko }}"
                       class="qty-control hidden w-full flex items-center justify-between bg-amber-500 text-white rounded-xl overflow-hidden">
                    <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'truck', -1, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_Truck }})"
                            class="px-4 py-2 text-lg font-black hover:bg-amber-600 transition-colors active:bg-amber-700 select-none">−</button>
                    <span id="qty-num-truck-{{ $produk->ID_Isi_Toko }}" class="font-bold text-base">1</span>
                    <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'truck', +1, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_Truck }})"
                            class="px-4 py-2 text-lg font-black hover:bg-amber-600 transition-colors active:bg-amber-700 select-none">+</button>
                  </div>
                  @else
                  <button disabled class="w-full bg-amber-300 text-white py-2 rounded-xl text-sm font-semibold flex items-center justify-center gap-1.5 opacity-50 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[16px]">remove_shopping_cart</span>
                    Stok Habis
                  </button>
                  @endif
                </div>
              </div>

            </div>
          </div>
        @empty
          <div class="col-span-full bg-surface-container-lowest p-16 rounded-3xl text-center border-2 border-dashed border-outline-variant/50 shadow-sm flex flex-col items-center justify-center">
            <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mb-6">
              <span class="material-symbols-outlined text-5xl text-outline">inventory_2</span>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-on-surface">Belum ada produk</h2>
            <p class="text-on-surface-variant max-w-md">Toko ini masih mempersiapkan katalog produk pasir mereka. Silakan kembali lagi nanti.</p>
          </div>
        @endforelse
      </div>

    </main>
  </div>

  <!-- ===== FLOATING CART FAB (Lingkaran Murni) ===== -->
  <!-- Ping ring (behind the FAB) -->
  <div id="cart-fab-ring"></div>

  <div id="cart-fab"
       role="button"
       aria-label="Lihat keranjang belanja"
       onclick="goToCheckout()">

    <!-- Ikon keranjang -->
    <span class="material-symbols-outlined"
          style="font-size:28px; color:#fff; pointer-events:none;
                 font-variation-settings:'FILL' 1,'wght' 600,'GRAD' 0,'opsz' 24;">
      shopping_cart
    </span>

    <!-- Badge merah (jumlah item) -->
    <div id="cart-fab-badge"
         style="position:absolute; top:-5px; right:-5px;
                width:22px; height:22px;
                background:#ef4444; color:#fff;
                border-radius:50%; border:2px solid #f8f9ff;
                display:flex; align-items:center; justify-content:center;
                font-size:11px; font-weight:900; line-height:1;
                box-shadow:0 2px 6px rgba(0,0,0,.3);
                pointer-events:none; user-select:none;">
      0
    </div>
  </div>

  <!-- ===== SCRIPTS ===== -->
  <script>
    const TOKO_DATA = {
      id: {{ $toko->ID_Toko }},
      nama: @json($toko->Nama_Toko),
      lokasi: @json($toko->Lokasi_Toko),
      ongkirPickUp: {{ $toko->Ongkir_PickUp }},
      ongkirTruck: {{ $toko->Ongkir_Truck }},
    };

    let cartItems = {};

    function totalCartQty() {
      return Object.values(cartItems).reduce((s, v) => s + v.qty, 0);
    }

    function updateCartUI() {
      const total = totalCartQty();
      const badge = document.getElementById('cart-fab-badge');
      const fab   = document.getElementById('cart-fab');
      const ring  = document.getElementById('cart-fab-ring');

      badge.textContent = total;

      // Badge bounce
      badge.classList.remove('bounce');
      void badge.offsetWidth;
      badge.classList.add('bounce');

      if (total > 0) {
        if (fab.style.display === 'none' || fab.style.display === '') {
          fab.style.display  = 'flex';
          ring.style.display = 'block';
          fab.classList.remove('pop-in');
          void fab.offsetWidth;
          fab.classList.add('pop-in');
        }
      } else {
        fab.style.display  = 'none';
        ring.style.display = 'none';
      }
    }

    function addToCart(produkId, type, harga, stock, namaPasir) {
      const key = produkId + '_' + type;
      cartItems[key] = { qty: 1, harga, stock, namaPasir, type };

      document.getElementById('btn-add-' + type + '-' + produkId).classList.add('hidden');
      const qtyDiv = document.getElementById('qty-' + type + '-' + produkId);
      qtyDiv.classList.remove('hidden');
      document.getElementById('qty-num-' + type + '-' + produkId).textContent = 1;

      updateCartUI();
    }

    function changeQty(produkId, type, delta, stock, namaPasir, harga) {
      const key = produkId + '_' + type;
      if (!cartItems[key]) cartItems[key] = { qty: 0, harga, stock, namaPasir, type };

      let newQty = cartItems[key].qty + delta;
      if (newQty > stock) newQty = stock;

      if (newQty <= 0) {
        delete cartItems[key];
        document.getElementById('qty-' + type + '-' + produkId).classList.add('hidden');
        document.getElementById('btn-add-' + type + '-' + produkId).classList.remove('hidden');
        document.getElementById('qty-num-' + type + '-' + produkId).textContent = 1;
      } else {
        cartItems[key].qty = newQty;
        document.getElementById('qty-num-' + type + '-' + produkId).textContent = newQty;
      }

      updateCartUI();
    }

    function goToCheckout() {
      if (totalCartQty() === 0) return;
      const items = Object.entries(cartItems).map(([key, v]) => ({
        key, namaPasir: v.namaPasir, type: v.type, qty: v.qty, harga: v.harga,
      }));
      sessionStorage.setItem('pasirku_cart', JSON.stringify(items));
      sessionStorage.setItem('pasirku_toko', JSON.stringify(TOKO_DATA));
      window.location.href = '{{ route('keranjang') }}';
    }
  </script>
</body>
</html>
