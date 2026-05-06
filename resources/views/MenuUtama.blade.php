<!doctype html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Menu Utama</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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
      font-variation-settings:
        "FILL" 0,
        "wght" 400,
        "GRAD" 0,
        "opsz" 24;
    }

    body {
      font-family: "Public Sans", sans-serif;
    }

    h1,
    h2,
    h3,
    .headline {
      font-family: "Manrope", sans-serif;
    }

    .glass-nav {
      backdrop-filter: blur(20px);
    }
  </style>
</head>

<body class="bg-surface text-on-surface overflow-x-hidden">
  @include('topbar')
  <div class="flex h-screen pt-[60px]">
    <!-- SideNavBar (Desktop Only) — shared component -->
    <x-sidebar />
    <!-- Main Content Canvas -->
    <main class="flex-1 md:ml-64 flex flex-col md:flex-row overflow-hidden bg-surface">
      <!-- Left Side: Shop List -->
      <section
        class="w-full md:w-[400px] lg:w-[480px] bg-surface-container-low overflow-y-auto p-6 scrollbar-hide flex flex-col gap-6">
        <header class="mb-2">
          <span class="text-xs font-bold text-secondary uppercase tracking-[0.2em] mb-1 block">Tectonic Precision</span>
          <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter leading-none">
            Toko pasir terdekat
          </h1>
        </header>
        <!-- Shop Filter Tabs -->
        <!-- Shop Card List buat nanti ini mengisi ketika ada toko didatabase -->
        <div id="shop-card-list" class="grid gap-4">
          <!-- Pesan jika tidak ada hasil pencarian -->
          <div id="no-result-msg" class="hidden text-center py-12">
            <span class="material-symbols-outlined text-4xl text-slate-300 mb-3 block" data-icon="search_off">search_off</span>
            <p class="text-slate-400 font-semibold">Toko tidak ditemukan</p>
            <p class="text-slate-300 text-sm mt-1">Coba kata kunci lain</p>
          </div>

          {{-- Loop data toko dari database --}}
          @forelse ($tokoList as $toko)
          <div
            class="shop-card bg-surface-container-lowest p-5 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.02)] group hover:translate-y-[-2px] transition-all cursor-pointer"
            data-shop-name="{{ strtolower($toko->Nama_Toko) }}">
            <div class="flex justify-between items-start mb-4">
              <div class="w-16 h-16 rounded-lg bg-surface-container flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl text-primary" style="font-variation-settings: 'FILL' 1">storefront</span>
              </div>
              <span class="text-xs font-bold bg-secondary/10 text-secondary px-3 py-1 rounded-full">Available Now</span>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-1">
              {{ $toko->Nama_Toko }}
            </h3>
            <div class="flex flex-col gap-1 text-sm text-on-surface-variant mb-4">
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-base" data-icon="location_on">location_on</span>
                <span>{{ $toko->Lokasi_Toko }}</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-base" data-icon="call">call</span>
                <span>{{ $toko->Nomer_Telepon_Toko }}</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-base" data-icon="mail">mail</span>
                <span>{{ $toko->Email_Toko }}</span>
              </div>
            </div>
            <div class="flex justify-between items-end border-t border-slate-100 pt-4 mt-2">
              <div>
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Pembelian</p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">
                  {{ number_format($toko->Total_Pembelian) }}<span class="text-xs font-normal text-slate-400"> order</span>
                </p>
              </div>
              <a href="{{ route('MarketPlace', $toko->ID_Toko) }}"
                class="bg-surface-container-high p-3 rounded-lg hover:bg-primary hover:text-white transition-all inline-flex items-center justify-center">
                <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
              </a>
            </div>
          </div>
          @empty
          <div class="text-center py-12">
            <span class="material-symbols-outlined text-4xl text-slate-300 mb-3 block">store</span>
            <p class="text-slate-400 font-semibold">Belum ada toko terdaftar</p>
          </div>
          @endforelse
        </div>
      </section>
      <!-- Sampe sini untuk toko dari database -->
      <!-- Right Side: Interactive Map -->

      <div id="map" style="height: 100vh;" class="w-full h-full"></div>

      <!-- Pass asset URL dari Blade ke Maps.js -->
      <script>
        window.MAP_CONFIG = {
          iconUrl: '{{ asset("img/rumah1.png") }}'
        };
      </script>

      <!-- Leaflet JS -->
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

      <!-- Maps Logic (external) -->
      <script src="{{ asset('js/Maps.js') }}"></script>

      <script>
        // === Fitur Pencarian Shop Card ===
        const searchInput = document.getElementById('search-input');
        const shopCards  = document.querySelectorAll('.shop-card');
        const noResult   = document.getElementById('no-result-msg');

        searchInput.addEventListener('input', function () {
          const query = this.value.trim().toLowerCase();
          let visibleCount = 0;

          shopCards.forEach(function (card) {
            const name = card.getAttribute('data-shop-name') || '';
            if (name.includes(query)) {
              card.style.display = '';
              visibleCount++;
            } else {
              card.style.display = 'none';
            }
          });

          // Tampilkan pesan jika tidak ada hasil
          noResult.classList.toggle('hidden', visibleCount > 0);
        });
      </script>

</body>

</html>