<x-layout-user title="Active Orders | Pasir Ku" :fullHeight="false">
  @push('head')
  <style>
    .tectonic-shadow {
      box-shadow: 0px 24px 48px rgba(11, 28, 48, 0.08);
    }
    .glass-overlay {
      backdrop-filter: blur(20px);
      background-color: rgba(248, 249, 255, 0.8);
    }
  </style>
  @endpush

  {{-- Toast Notifikasi Sukses --}}
  @if(session('success'))
    <div id="toast-success" class="fixed top-20 left-1/2 -translate-x-1/2 z-[99999] bg-gradient-to-r from-emerald-600 to-green-500 text-white font-bold py-4 px-6 rounded-2xl shadow-2xl flex items-center gap-3 border border-white/20 transition-all duration-500 animate-bounce">
      <span class="material-symbols-outlined bg-white/20 p-1.5 rounded-full text-lg leading-none" style="font-variation-settings: 'FILL' 1">check_circle</span>
      <span class="text-sm font-semibold tracking-tight">{{ session('success') }}</span>
      <button onclick="document.getElementById('toast-success').remove()" class="hover:bg-white/20 p-1 rounded-lg transition-colors ml-4 flex items-center justify-center">
        <span class="material-symbols-outlined text-sm leading-none">close</span>
      </button>
    </div>
    
    <script>
      // Otomatis hilangkan toast setelah 5 detik
      setTimeout(() => {
        const toast = document.getElementById('toast-success');
        if (toast) {
          toast.style.opacity = '0';
          toast.style.transform = 'translate(-50%, -20px)';
          setTimeout(() => toast.remove(), 500);
        }
      }, 5000);
    </script>
  @endif

  <!-- Content Shell -->
  <div class="p-6 md:p-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 mb-24 md:mb-10">

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
        <button class="bg-surface-container-lowest p-3 rounded-lg shadow-md text-on-surface hover:bg-surface-variant transition-colors">
          <span class="material-symbols-outlined">add</span>
        </button>
        <button class="bg-surface-container-lowest p-3 rounded-lg shadow-md text-on-surface hover:bg-surface-variant transition-colors">
          <span class="material-symbols-outlined">remove</span>
        </button>
        <button class="bg-primary text-on-primary p-3 rounded-lg shadow-md hover:bg-primary-container transition-all">
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
      <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4 tectonic-shadow">
        <div class="flex justify-between items-end">
          <div>
            <p class="text-on-surface-variant text-[10px] uppercase font-black tracking-widest mb-1">Material</p>
            <h4 class="text-on-surface font-bold text-lg">Pasir Cor Super (5m³)</h4>
          </div>
        </div>
        <!-- Dual Price Display -->
        <div class="grid grid-cols-2 gap-3 pt-2">
          <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex flex-col gap-1">
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[15px] text-blue-600">directions_car</span>
              <span class="text-[10px] font-bold text-blue-500 uppercase tracking-wide">Pick Up</span>
            </div>
            <span class="text-blue-800 font-black text-base">Rp 150.000</span>
          </div>
          <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 flex flex-col gap-1">
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[15px] text-amber-600">local_shipping</span>
              <span class="text-[10px] font-bold text-amber-500 uppercase tracking-wide">Truk</span>
            </div>
            <span class="text-amber-800 font-black text-base">Rp 350.000</span>
          </div>
        </div>
        <div class="pt-4 border-t border-outline-variant/30 flex items-start gap-3">
          <span class="material-symbols-outlined text-secondary">location_on</span>
          <p class="text-on-surface-variant text-xs leading-relaxed font-medium">
            Jl. Menteng No. 45, Blok C12, <br />
            Kecamatan Menteng, Jakarta Pusat
          </p>
        </div>
      </div>

    </section>
  </div>

  <!-- Floating Action Button: Chat dengan Toko -->
  <button class="fixed bottom-24 right-6 md:bottom-10 md:right-10 bg-gradient-to-br from-primary to-primary-container text-white px-6 py-4 rounded-full flex items-center gap-3 shadow-2xl z-50 active:scale-95 transition-transform hover:shadow-primary/30">
    <span class="material-symbols-outlined">chat_bubble</span>
    <span class="font-bold tracking-tight">Chat dengan Toko</span>
  </button>

</x-layout-user>
