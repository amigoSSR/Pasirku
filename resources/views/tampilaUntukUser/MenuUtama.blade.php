<x-layout-user title="Temukan Toko" :fullHeight="true">

  @push('head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  @endpush


  {{-- Two-column layout: shop list + map --}}
  <div class="flex flex-1 overflow-hidden h-full">

    {{-- Left: Shop List --}}
    <section class="w-full md:w-[500px] lg:w-[600px] xl:w-[700px] bg-surface-container-low overflow-y-auto p-6 scrollbar-hide flex flex-col gap-2 shrink-0">

      {{-- Header --}}
      <header class="mb-4">
        <div class="flex justify-between items-start mb-2">
            <div>
                <span class="text-xs font-bold text-primary uppercase tracking-[0.2em] mb-1 block flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">location_on</span>
                  Toko Terdekat
                </span>
                <h1 class="text-2xl font-headline font-extrabold text-on-surface tracking-tight leading-tight">
                  Temukan toko pasir di sekitarmu
                </h1>
            </div>
            <div class="flex gap-2">
                {{-- Dark Mode Toggle --}}
                <button 
                    @click="darkMode = !darkMode"
                    class="bg-surface-container-highest text-on-surface p-2 rounded-xl hover:bg-surface-container-high transition-all" 
                    title="Toggle Dark Mode">
                    <span class="material-symbols-outlined text-[20px]" x-show="!darkMode">light_mode</span>
                    <span class="material-symbols-outlined text-[20px]" x-show="darkMode" x-cloak>dark_mode</span>
                </button>
                <button id="btn-update-location" class="bg-primary/10 text-primary p-2 rounded-xl hover:bg-primary/20 transition-all active:scale-95 group" title="Gunakan Lokasi Saat Ini">
                    <span class="material-symbols-outlined text-[20px] group-hover:rotate-12 transition-transform">my_location</span>
                </button>
            </div>
        </div>
        
        {{-- Radius Filter --}}
        <div class="flex flex-wrap gap-2 mt-4">
            <button class="radius-filter bg-primary text-on-primary px-4 py-2 rounded-full text-xs font-bold shadow-sm transition-all" data-radius="">Semua</button>
            <button class="radius-filter bg-surface-container-highest text-on-surface-variant px-4 py-2 rounded-full text-xs font-bold hover:bg-outline-variant/30 transition-all" data-radius="1">1 km</button>
            <button class="radius-filter bg-surface-container-highest text-on-surface-variant px-4 py-2 rounded-full text-xs font-bold hover:bg-outline-variant/30 transition-all" data-radius="5">5 km</button>
            <button class="radius-filter bg-surface-container-highest text-on-surface-variant px-4 py-2 rounded-full text-xs font-bold hover:bg-outline-variant/30 transition-all" data-radius="10">10 km</button>
            <button class="radius-filter bg-surface-container-highest text-on-surface-variant px-4 py-2 rounded-full text-xs font-bold hover:bg-outline-variant/30 transition-all" data-radius="25">25 km</button>
        </div>
      </header>

      {{-- Search --}}
      <div class="relative mb-4">
          <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
          <input type="text" id="search-input" placeholder="Cari nama toko..." 
            class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-2xl py-3.5 pl-12 pr-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all">
      </div>

      {{-- Shop Cards Container --}}
      <div id="shop-card-list" class="grid grid-cols-1 md:grid-cols-1 xl:grid-cols-2 gap-4">
        @include('tampilaUntukUser.partials.store-list', ['tokoList' => $tokoList])
      </div>

      {{-- Pesan ketika hasil pencarian kosong (client-side) --}}
      <div id="no-result-msg" class="hidden col-span-full text-center py-16">
        <span class="material-symbols-outlined text-5xl text-outline mb-3 block">search_off</span>
        <p class="text-on-surface-variant font-semibold">Toko tidak ditemukan dengan nama tersebut</p>
        <p class="text-outline text-sm mt-1">Coba gunakan kata kunci lain</p>
      </div>
    </section>

    {{-- Right: Map --}}
    <div id="map" class="flex-1 h-full relative">
      <div id="map-loader" class="absolute inset-0 bg-surface/50 backdrop-blur-[2px] z-[600] flex flex-col items-center justify-center hidden">
          <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin mb-4"></div>
          <p class="text-sm font-bold text-on-surface">Mencari toko terdekat...</p>
      </div>
      <button id="btn-locate-me" class="absolute top-4 right-4 z-[500] bg-surface-container-lowest p-3 rounded-2xl shadow-xl border border-outline-variant/30 hover:bg-surface-container-low transition-all active:scale-95 group" title="Cari Lokasi Saya">
        <span class="material-symbols-outlined text-[20px] text-primary group-hover:rotate-12 transition-transform">my_location</span>
      </button>
    </div>

    <script>
      window.MAP_CONFIG = {
        iconUrl: '{{ asset("img/rumah1.png") }}',
        userLat: {{ $lat ?? 'null' }},
        userLng: {{ $lng ?? 'null' }},
        radius: {{ $radius ?? 'null' }},
        nearbyUrl: '{{ route("nearby-stores") }}',
        stores: [
          @foreach($tokoList as $toko)
            @if($toko->latitude && $toko->longitude)
              {
                id: {{ $toko->ID_Toko }},
                name: "{!! addslashes($toko->Nama_Toko) !!}",
                lat: {{ $toko->latitude }},
                lng: {{ $toko->longitude }},
                address: "{!! addslashes($toko->detail_alamat ?: $toko->Lokasi_Toko) !!}",
                url: "{{ route('MarketPlace', $toko->ID_Toko) }}",
                distance: {{ isset($toko->distance) ? $toko->distance : 'null' }}
              },
            @endif
          @endforeach
        ]
      };
    </script>

  </div>

  @push('scripts')
  {{-- Floating CS Chat Popup --}}
  <div x-data="csChatPopup()" x-cloak class="fixed bottom-24 md:bottom-10 right-6 z-[100]">
    {{-- Main Chat Popup --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-10 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-90"
         class="absolute bottom-16 right-0 w-80 md:w-96 bg-surface-container-lowest rounded-3xl shadow-2xl border border-outline-variant/30 overflow-hidden flex flex-col">
      
      {{-- Header --}}
      <div class="bg-primary p-4 text-on-primary flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-on-primary/20 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings:'FILL' 1">support_agent</span>
          </div>
          <div>
            <h4 class="font-headline font-bold text-sm">Customer Service</h4>
            <p class="text-[10px] text-primary-fixed flex items-center gap-1">
              <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span> Online
            </p>
          </div>
        </div>
        <button @click="open = false" class="hover:bg-on-primary/10 p-1 rounded-lg transition-colors">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      {{-- Message Body --}}
      <div class="p-5 bg-surface-container-low/30 space-y-4">
        <div class="bg-surface-container-lowest p-4 rounded-2xl rounded-tl-none border border-outline-variant/20 shadow-sm">
          <p class="text-xs text-on-surface leading-relaxed">
            Halo! Ada yang bisa kami bantu hari ini? Silakan tinggalkan pesan Anda di bawah.
          </p>
        </div>
        
        <div class="space-y-1.5">
          <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Pesan Anda</label>
          <textarea x-model="message" rows="3" 
            class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all resize-none"
            placeholder="Tulis kendala atau pertanyaan Anda..."></textarea>
        </div>

        <button @click="startChat()" :disabled="!message.trim() || sending"
          class="w-full bg-primary text-on-primary py-3 rounded-2xl font-bold text-sm shadow-sm hover:shadow-md active:scale-[0.98] transition-all flex items-center justify-center gap-2">
          <span x-show="!sending">Mulai Chat</span>
          <span x-show="sending" class="animate-spin material-symbols-outlined text-[18px]">autorenew</span>
          <span class="material-symbols-outlined text-[18px]" x-show="!sending">arrow_forward</span>
        </button>
      </div>

      {{-- Footer --}}
      <div class="p-3 bg-surface-container-lowest text-center border-t border-outline-variant/10">
        <a href="{{ route('chat.admin') }}" class="text-[10px] font-bold text-primary hover:underline">LIHAT SEMUA PERCAKAPAN</a>
      </div>
    </div>

    {{-- Floating Toggle Button --}}
    <button @click="open = !open" 
      class="w-14 h-14 bg-primary text-on-primary rounded-2xl shadow-xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all group relative">
      <span class="material-symbols-outlined text-[28px]" x-show="!open" style="font-variation-settings:'FILL' 1">chat_bubble</span>
      <span class="material-symbols-outlined text-[28px]" x-show="open">close</span>
      
      {{-- Badge --}}
      <span class="absolute -top-1 -right-1 w-5 h-5 bg-error text-on-error text-[10px] font-bold rounded-full border-2 border-surface flex items-center justify-center shadow-sm">CS</span>
    </button>
  </div>

  <script>
    function csChatPopup() {
      return {
        open: false, message: '', sending: false,
        startChat() {
          if (!this.message.trim() || this.sending) return;
          this.sending = true;
          window.location.href = `{{ route('chat.admin') }}?initial_msg=${encodeURIComponent(this.message)}`;
        }
      }
    }
  </script>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script src="{{ asset('js/Maps.js') }}"></script>
  <script>
    const searchInput = document.getElementById('search-input');
    const shopCards  = document.querySelectorAll('.shop-card');
    const noResult   = document.getElementById('no-result-msg');

    if (searchInput) {
      searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        let visible = 0;
        shopCards.forEach(card => {
          const name = card.getAttribute('data-shop-name') || '';
          const show = name.includes(query);
          card.style.display = show ? '' : 'none';
          if (show) visible++;
        });
        noResult.classList.toggle('hidden', visible > 0);
      });
    }
  </script>
  @endpush

</x-layout-user>
