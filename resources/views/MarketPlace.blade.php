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
      font-variation-settings:
        "FILL" 0,
        "wght" 400,
        "GRAD" 0,
        "opsz" 24;
    }

    body {
      font-family: "Public Sans", sans-serif;
    }

    h1, h2, h3, .headline {
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
    <main class="flex-1 md:ml-64 flex flex-col p-4 md:p-8 overflow-y-auto bg-surface">
        <header class="mb-8 relative overflow-hidden bg-primary text-on-primary rounded-3xl p-8 shadow-lg">
          <!-- Abstract Background Elements -->
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

        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-on-surface">Produk Tersedia</h2>
            <div class="text-sm text-on-surface-variant bg-surface-container py-1 px-4 rounded-full font-semibold">
                {{ $isiToko->count() }} Produk
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-12">
            @forelse($isiToko as $produk)
                <div class="group bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 hover:shadow-xl hover:border-primary/30 transition-all duration-300 flex flex-col overflow-hidden hover:-translate-y-1">
                    <!-- Product Header / Icon Area -->
                    <div class="bg-gradient-to-br from-surface-container to-surface-container-high flex items-center justify-center relative overflow-hidden h-40 group-hover:from-primary-container/30 group-hover:to-primary-container/10 transition-colors duration-300 p-4">
                        <span class="material-symbols-outlined text-8xl text-primary/25 group-hover:text-primary/60 transition-all duration-300 group-hover:scale-110 transform">landscape</span>
                        <!-- Nama Pasir Badge -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-on-surface/60 to-transparent p-4">
                            <h3 class="font-extrabold text-xl text-white tracking-tight drop-shadow-md">{{ $produk->Nama_Pasir }}</h3>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="p-4 flex flex-col flex-1 gap-3">

                        <!-- Pick Up Card -->
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
                            <button class="w-full mt-1 bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center gap-1.5 active:scale-95 duration-200 {{ $produk->Stock_PickUp <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $produk->Stock_PickUp <= 0 ? 'disabled' : '' }}>
                                <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                {{ $produk->Stock_PickUp > 0 ? 'Pesan Pick Up' : 'Stok Habis' }}
                            </button>
                        </div>

                        <!-- Truck Card -->
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
                            <button class="w-full mt-1 bg-amber-500 text-white py-2 rounded-xl text-sm font-semibold hover:bg-amber-600 transition-colors flex items-center justify-center gap-1.5 active:scale-95 duration-200 {{ $produk->Stock_Truck <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $produk->Stock_Truck <= 0 ? 'disabled' : '' }}>
                                <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                {{ $produk->Stock_Truck > 0 ? 'Pesan Truk' : 'Stok Habis' }}
                            </button>
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
</body>

</html>
