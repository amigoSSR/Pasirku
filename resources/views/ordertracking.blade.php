<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Active Orders | Pasir Ku</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Public+Sans:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
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
            "surface": "#f8f9ff",
            "surface-dim": "#cbdbf5",
            "secondary": "#7d562d",
            "surface-container-low": "#eff4ff",
            "on-primary-fixed": "#001b3d",
            "inverse-on-surface": "#eaf1ff",
            "surface-tint": "#005db5",
            "inverse-surface": "#213145",
            "outline": "#727783",
            "on-primary-fixed-variant": "#00468b",
            "on-tertiary-fixed-variant": "#5d4037",
            "tertiary-container": "#78584e",
            "background": "#f8f9ff",
            "error": "#ba1a1a",
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
            "primary": "#00488d",
            "outline-variant": "#c2c6d4",
            "surface-bright": "#f8f9ff",
            "tertiary": "#5e4138",
            "inverse-primary": "#a8c8ff",
            "secondary-fixed": "#ffdcbd",
            "on-tertiary": "#ffffff",
            "tertiary-fixed": "#ffdbd0",
            "on-error": "#ffffff"
          },
          borderRadius: {
            DEFAULT: "0.125rem",
            lg: "0.25rem",
            xl: "0.5rem",
            full: "0.75rem"
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Public Sans"],
            label: ["Public Sans"]
          }
        }
      }
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    body {
      font-family: 'Public Sans', sans-serif;
    }
    h1, h2, h3, h4 {
      font-family: 'Manrope', sans-serif;
    }
    .tectonic-shadow {
      box-shadow: 0px 24px 48px rgba(11, 28, 48, 0.08);
    }
    .glass-overlay {
      backdrop-filter: blur(20px);
      background-color: rgba(248, 249, 255, 0.8);
    }
  </style>
</head>

<body class="bg-surface text-on-surface min-h-screen">

  @include('topbar')

  <div class="flex pt-[60px] min-h-screen">

<aside class="hidden md:flex flex-col h-full w-64 bg-slate-100 py-8 border-r-0 fixed left-0">
      <div class="px-6 pb-8">
        <h2 class="text-sm font-bold text-blue-900 uppercase tracking-widest opacity-50">
          Industrial Hub
        </h2>
        <div class="flex items-center mt-2 gap-2">
          <span class="material-symbols-outlined text-secondary" data-icon="verified"
            style="font-variation-settings: &quot;FILL&quot; 1">verified</span>
          <span class="text-xs font-semibold text-slate-500 uppercase tracking-tighter">Verified Seller</span>
        </div>
      </div>
      <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-4 px-6 py-4 text-blue-900 font-bold border-r-4 border-blue-900 bg-white/50 transition-colors"
          href="#">
          <span class="material-symbols-outlined" data-icon="storefront">storefront</span>
          <span>Menu Utama</span>
        </a>
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 transition-colors group"
          href="{{route('ordertracking')}}">
          <span class="material-symbols-outlined mr-4" data-icon="local_shipping">local_shipping</span>
          <span class="font-bold text-slate-500">Active Orders</span>
        </a>
        <a class="flex items-center gap-4 px-6 py-4 text-slate-500 hover:text-blue-800 hover:bg-slate-200 transition-colors"
          href="{{ route('Pesan') }}">
          <span class="material-symbols-outlined" data-icon="forum">forum</span>
          <span>Messages</span>
        </a>
        <a class="flex items-center gap-4 px-6 py-4 text-slate-500 hover:text-blue-800 hover:bg-slate-200 transition-colors"
          href="{{ route('Profil') }}">
          <span class="material-symbols-outlined" data-icon="person">person</span>
          <span>Profile</span>
        </a>
      </nav>
      <div class="px-6 mt-auto mb-16">
        
      </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="flex-1 md:ml-64 flex flex-col min-h-screen relative">

      <!-- Content Shell -->
      <div class="flex-1 p-6 md:p-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 mb-24 md:mb-10">

        <!-- Tracking Map Section (Large Bento Block) -->
        <section class="lg:col-span-8 bg-surface-container-low rounded-xl overflow-hidden min-h-[400px] lg:min-h-[600px] relative tectonic-shadow">
          <div class="absolute inset-0 z-0">
            <img
              class="w-full h-full object-cover grayscale-[0.2] contrast-[1.1]"
              alt="Peta pengiriman"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuBq5DKJKlNW9YxlkLe8drqR2ugGoBGO38hppAxGA_7ZRhJoPUN9JUBOBmsKazSDOSh5nyakHj_yUyzqqU6iJydop5T5rVVBva1ExQuQ7sLpAu2HHBCONcxXMdRSu6HvhzBEv6FfEPXaE2Z0wzYSOx9PWBoWRvcPZ6rmHXHYjWJc4HlvIZpkOtwlaJ495zKRONy41DdJcrLpZlNTrDCyUpIsfKEGEgHwBywLPnLgehdcMeU-ux4foCAH40IO_GR3dTb3GjVwLzKX5A" />
          </div>

          <!-- Floating Map Controls -->
          <div class="absolute top-6 left-6 z-10 glass-overlay p-4 rounded-xl shadow-lg border border-white/20">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
              </div>
              <div>
                <h3 class="text-on-surface font-bold text-lg tracking-tight">TRUCK-992-B</h3>
                <p class="text-on-surface-variant text-sm font-medium">Hino Ranger - Sand Delivery</p>
              </div>
            </div>
          </div>

          <!-- Map Zoom Controls -->
          <div class="absolute bottom-6 right-6 z-10 flex flex-col gap-2">
            <button class="bg-white p-3 rounded-lg shadow-md text-on-surface hover:bg-surface-variant transition-colors">
              <span class="material-symbols-outlined">add</span>
            </button>
            <button class="bg-white p-3 rounded-lg shadow-md text-on-surface hover:bg-surface-variant transition-colors">
              <span class="material-symbols-outlined">remove</span>
            </button>
            <button class="bg-primary text-white p-3 rounded-lg shadow-md hover:opacity-90 transition-all">
              <span class="material-symbols-outlined">my_location</span>
            </button>
          </div>
        </section>

        <!-- Status & Details Section -->
        <section class="lg:col-span-4 space-y-6">

          <!-- Delivery Stepper Card -->
          <div class="bg-surface-container-lowest p-8 rounded-xl tectonic-shadow border-b-4 border-primary">
            <div class="mb-8">
              <p class="text-secondary font-bold text-xs uppercase tracking-[0.2em] mb-1">Status Pengiriman</p>
              <h2 class="text-on-surface text-3xl font-extrabold tracking-tighter leading-none">Menuju ke lokasi anda</h2>
            </div>
            <div class="space-y-0">

              <!-- Step 1: Done -->
              <div class="flex gap-4 min-h-[80px]">
                <div class="flex flex-col items-center">
                  <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                  </div>
                  <div class="w-0.5 flex-1 bg-primary"></div>
                </div>
                <div class="pb-6">
                  <h4 class="text-on-surface font-bold text-sm">Diterima oleh toko</h4>
                  <p class="text-on-surface-variant text-xs mt-1">12 Oct, 09:15 AM</p>
                </div>
              </div>

              <!-- Step 2: Done -->
              <div class="flex gap-4 min-h-[80px]">
                <div class="flex flex-col items-center">
                  <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                  </div>
                  <div class="w-0.5 flex-1 bg-primary"></div>
                </div>
                <div class="pb-6">
                  <h4 class="text-on-surface font-bold text-sm">Sedang di proses</h4>
                  <p class="text-on-surface-variant text-xs mt-1">12 Oct, 10:30 AM</p>
                </div>
              </div>

              <!-- Step 3: Active -->
              <div class="flex gap-4">
                <div class="flex flex-col items-center">
                  <div class="w-8 h-8 -ml-1 rounded-full bg-surface-container-high border-2 border-primary flex items-center justify-center">
                    <div class="w-3 h-3 bg-primary rounded-full"></div>
                  </div>
                </div>
                <div>
                  <h4 class="text-primary font-extrabold text-sm">Menuju ke lokasi anda</h4>
                  <p class="text-on-surface-variant text-xs mt-1">Estimasi tiba: 15 Menit</p>
                </div>
              </div>

            </div>
          </div>

          <!-- Driver Card -->
          <div class="bg-surface-container-high p-6 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-4">
              <img
                class="w-14 h-14 rounded-full object-cover border-2 border-white"
                alt="Foto pengemudi"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuByKeGgBGPyb-1LrlmcJl9Tr5oKO1fSuuolVQHCpNgA-QAvE5pE3nfTBIX85hfox0WV4CZ5_-KqRsnXDWLPMZmzbjsDEZXKsWsqU0HhA0CoEXdCckfBAGrXd8TsJidbUrMloqtfP1zeImk7OoqITYWzNkgt7hsEPBmtXhvyZLZCUerLobHs8JfiGRJAU0SOo7nUI1ORwDzlwdPwW5HNAIsc_iDGvWY-nY7ZPOB9ORFlH_z0AoN5vlgf-llKRZSTLcqKLLxONxbgPw" />
              <div>
                <h4 class="text-on-surface font-bold">Budi Santoso</h4>
                <div class="flex items-center gap-1">
                  <span class="material-symbols-outlined text-sm text-secondary"
                    style="font-variation-settings: 'FILL' 1;">star</span>
                  <span class="text-xs font-bold text-on-surface-variant">4.9 (240+ reviews)</span>
                </div>
              </div>
            </div>
            <button class="bg-surface-container-lowest p-3 rounded-full text-primary hover:bg-primary hover:text-white transition-all shadow-sm">
              <span class="material-symbols-outlined">call</span>
            </button>
          </div>

          <!-- Order Details Card -->
          <div class="bg-white p-6 rounded-xl space-y-4 tectonic-shadow">
            <div class="flex justify-between items-end">
              <div>
                <p class="text-on-surface-variant text-[10px] uppercase font-black tracking-widest mb-1">Material</p>
                <h4 class="text-on-surface font-bold text-lg">Pasir Cor Super (5m³)</h4>
              </div>
              <span class="text-primary font-black text-xl">Rp 2.450.000</span>
            </div>
            <div class="pt-4 border-t border-slate-100 flex items-start gap-3">
              <span class="material-symbols-outlined text-secondary">location_on</span>
              <p class="text-on-surface-variant text-xs leading-relaxed font-medium">
                Jl. Menteng No. 45, Blok C12, <br />
                Kecamatan Menteng, Jakarta Pusat
              </p>
            </div>
          </div>

        </section>
      </div>

      <!-- Mobile BottomNavBar -->
      <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-slate-50/80 backdrop-blur-xl shadow-[0px_-8px_24px_rgba(11,28,48,0.05)] rounded-t-xl">
        <div class="flex flex-col items-center justify-center text-slate-500 px-6 py-1">
          <span class="material-symbols-outlined">trolley</span>
          <span class="text-[10px] font-bold uppercase tracking-wider mt-1">Home</span>
        </div>
        <div class="flex flex-col items-center justify-center bg-blue-100 text-blue-900 rounded-xl px-6 py-1">
          <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
          <span class="text-[10px] font-bold uppercase tracking-wider mt-1">Cart</span>
        </div>
        <div class="flex flex-col items-center justify-center text-slate-500 px-6 py-1">
          <span class="material-symbols-outlined">person</span>
          <span class="text-[10px] font-bold uppercase tracking-wider mt-1">Profile</span>
        </div>
      </nav>

      <!-- Floating Action Button: Chat dengan Toko -->
      <button class="fixed bottom-24 right-6 md:bottom-10 md:right-10 bg-gradient-to-br from-primary to-primary-container text-white px-6 py-4 rounded-full flex items-center gap-3 shadow-2xl z-50 active:scale-95 transition-transform">
        <span class="material-symbols-outlined">chat_bubble</span>
        <span class="font-bold tracking-tight">Chat dengan Toko</span>
      </button>

    </main>
  </div>

</body>
</html>