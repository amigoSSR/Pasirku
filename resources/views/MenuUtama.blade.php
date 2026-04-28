

<body class="bg-surface text-on-surface overflow-x-hidden">
  @include('topbar')
  <div class="flex h-screen pt-[60px]">
    <!-- SideNavBar (Desktop Only) -->
    <aside class="hidden md:flex flex-col h-full w-64 bg-slate-100 dark:bg-slate-950 py-8 border-r-0 fixed left-0">
      <div class="px-6 pb-8">
        <h2 class="text-sm font-bold text-blue-900 dark:text-white uppercase tracking-widest opacity-50">
          Industrial Hub
        </h2>
        <div class="flex items-center mt-2 gap-2">
          <span class="material-symbols-outlined text-secondary" data-icon="verified"
            style="font-variation-settings: &quot;FILL&quot; 1">verified</span>
          <span class="text-xs font-semibold text-slate-500 uppercase tracking-tighter">Verified Seller</span>
        </div>
      </div>
      <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-4 px-6 py-4 text-blue-900 dark:text-white font-bold border-r-4 border-blue-900 dark:border-blue-400 bg-white/50 dark:bg-white/5 transition-colors"
          href="#">
          <span class="material-symbols-outlined" data-icon="storefront">storefront</span>
          <span>Menu Utama</span>
        </a>
        <a class="flex items-center px-6 py-4 text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors group"
          href="{{route('ordertracking')}}">
          <span class="material-symbols-outlined mr-4" data-icon="local_shipping">local_shipping</span>
          <span class="font-bold text-slate-500">Active Orders</span>
        </a>
        <a class="flex items-center gap-4 px-6 py-4 text-slate-500 dark:text-slate-400 hover:text-blue-800 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors"
          href="{{ route('Pesan') }}">
          <span class="material-symbols-outlined" data-icon="forum">forum</span>
          <span>Messages</span>
        </a>
        <a class="flex items-center gap-4 px-6 py-4 text-slate-500 dark:text-slate-400 hover:text-blue-800 hover:bg-slate-200 dark:hover:bg-slate-800 transition-colors"
          href="{{ route('profil') }}">
          <span class="material-symbols-outlined" data-icon="person">person</span>
          <span>Profile</span>
        </a>
      </nav>
      <div class="px-6 mt-auto mb-16">
        
      </div>
    </aside>
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
          <!-- Shop Card 1 -->
          <div
            class="shop-card bg-surface-container-lowest p-5 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.02)] group hover:translate-y-[-2px] transition-all cursor-pointer"
            data-shop-name="toko berkah jaya">
            <div class="flex justify-between items-start mb-4">
              <div class="w-16 h-16 rounded-lg bg-surface-container overflow-hidden">
                <img alt="Sand sample" class="w-full h-full object-cover"
                  data-alt="macro shot of clean building sand with golden hues and fine texture under bright sunlight"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRPmqkY9YaAmVnUhOdWP6PIEvE0y1BCfAO0a118FDRYN6QR91WZ6LcF4-2FTIwXfvYRriODv0SbKcpLe2jWyXWstMJQ2Hb8WKHrpgmLsuS-vMhJAyykAeq8fDcnrYCr3T9aQk1O8ljE0vL5ltSKenYcKcOW3G4iSg3f17ZFf3axisp2_U8AAMs775uaTVBd-r4eo3HAQOgbRLh0Kh7PPlGKMKctLYruIet2jdK60_aDkpMh-AiRn8xtOgv9PibMvJ8iUIPep_JRA" />
              </div>
              <span class="text-xs font-bold bg-secondary/10 text-secondary px-3 py-1 rounded-full">Available Now</span>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-1">
              Toko Berkah Jaya
            </h3>
            <div class="flex items-center gap-3 text-sm text-on-surface-variant mb-4">
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-yellow-500 text-base" data-icon="star"
                  style="font-variation-settings: &quot;FILL&quot; 1">star</span>
                <span class="font-bold text-on-surface">4.9</span>
              </div>
              <span class="opacity-30">|</span>
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-base" data-icon="location_on">location_on</span>
                <span>2.4 miles</span>
              </div>
            </div>
            <div class="flex justify-between items-end border-t border-slate-100 pt-4 mt-2">
              <div>
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                  Starting at
                </p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">
                  $42.50<span class="text-xs font-normal text-slate-400">/ton</span>
                </p>
              </div>
              <button class="bg-surface-container-high p-3 rounded-lg hover:bg-primary hover:text-white transition-all">
                <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
              </button>
            </div>
          </div>
          <!-- Shop Card 2 -->
          <div
            class="shop-card bg-surface-container-lowest p-5 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.02)] group hover:translate-y-[-2px] transition-all cursor-pointer"
            data-shop-name="toko sentosa abadi">
            <div class="flex justify-between items-start mb-4">
              <div class="w-16 h-16 rounded-lg bg-surface-container overflow-hidden">
                <img alt="Quarry site" class="w-full h-full object-cover"
                  data-alt="aerial drone photography of an active sand quarry showing heavy machinery and layered earth excavations"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxF9Hvyu16AWmgXgxSuyPh-hAsJdhyDQqEfJ9Ks71tlGMfK78kVwITVVlwVpxAn6eXsEGm9Z8zMLmI8edK6imuUyjoa0O2w4Fs0z32ZUPSffRB09QlYZQI1mXiFPMVwDIQhkGRGBxAkya2-4HkTfE3nFNdI1Oal2yFcSYGuDDIhdC0R6WtWDpps5nRrZ9mGyKvVbrYwKBAQuAoClNn7yHMQJVYHiDU-hfvPwdtZgOTlk3RHe8h33pW2znJznNjhJ6sQPpI34JEvA" />
              </div>
              <span class="text-xs font-bold bg-green-50 text-green-700 px-3 py-1 rounded-full">Fast Delivery</span>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-1">
              Toko Sentosa Abadi
            </h3>
            <div class="flex items-center gap-3 text-sm text-on-surface-variant mb-4">
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-yellow-500 text-base" data-icon="star"
                  style="font-variation-settings: &quot;FILL&quot; 1">star</span>
                <span class="font-bold text-on-surface">4.7</span>
              </div>
              <span class="opacity-30">|</span>
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-base" data-icon="location_on">location_on</span>
                <span>5.1 miles</span>
              </div>
            </div>
            <div class="flex justify-between items-end border-t border-slate-100 pt-4 mt-2">
              <div>
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                  Starting at
                </p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">
                  $38.00<span class="text-xs font-normal text-slate-400">/ton</span>
                </p>
              </div>
              <button class="bg-surface-container-high p-3 rounded-lg hover:bg-primary hover:text-white transition-all">
                <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
              </button>
            </div>
          </div>
          <!-- Shop Card 3 -->
          <div
            class="shop-card bg-surface-container-lowest p-5 rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.02)] group hover:translate-y-[-2px] transition-all cursor-pointer"
            data-shop-name="toko pak somat">
            <div class="flex justify-between items-start mb-4">
              <div class="w-16 h-16 rounded-lg bg-surface-container overflow-hidden">
                <img alt="Conveyor" class="w-full h-full object-cover"
                  data-alt="industrial conveyor belt at a quarry carrying washed sand towards a large pile under hazy morning sky"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuBwgxJlBwpxwiwZloBC9FXuXF83Yo40GMGBzNRblxlgjuOV4jyf_eaJFlXPMJX2kyI_LO6JwrTQgreh7Gp6x3e3FheRsAkHWtB6l9zQ8KqUL6Rs9tBuT7Sb9jSV1kgGd2STo0xJPfBJEvbHVZklj2sStXFGASvk1xYzJR47-lacKOpQnB157KfFBfdusGJnmb-HdMLUghUGoe3InxjeF4-2PYHdKSM4tX6f3H8ppSdyPRBSRc3A08XQPuKIxj8voiufxEE19hqP1A" />
              </div>
              <span class="text-xs font-bold bg-slate-100 text-slate-500 px-3 py-1 rounded-full">Bulk Orders Only</span>
            </div>
            <h3 class="text-xl font-bold text-blue-900 mb-1">
              Toko Pak Somat
            </h3>
            <div class="flex items-center gap-3 text-sm text-on-surface-variant mb-4">
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-yellow-500 text-base" data-icon="star"
                  style="font-variation-settings: &quot;FILL&quot; 1">star</span>
                <span class="font-bold text-on-surface">4.8</span>
              </div>
              <span class="opacity-30">|</span>
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-base" data-icon="location_on">location_on</span>
                <span>8.7 miles</span>
              </div>
            </div>
            <div class="flex justify-between items-end border-t border-slate-100 pt-4 mt-2">
              <div>
                <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                  Starting at
                </p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">
                  $35.25<span class="text-xs font-normal text-slate-400">/ton</span>
                </p>
              </div>
              <button class="bg-surface-container-high p-3 rounded-lg hover:bg-primary hover:text-white transition-all">
                <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
              </button>
            </div>
          </div>
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