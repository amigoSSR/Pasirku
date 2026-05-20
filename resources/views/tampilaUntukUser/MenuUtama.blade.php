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
      <header class="mb-2">
        <span class="text-xs font-bold text-primary uppercase tracking-[0.2em] mb-1 block flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">location_on</span>
          Toko Terdekat
        </span>
        <h1 class="text-2xl font-headline font-extrabold text-on-surface tracking-tight leading-tight">
          Temukan toko pasir di sekitarmu
        </h1>
        <p class="text-sm text-on-surface-variant mt-1">{{ count($tokoList) }} toko tersedia</p>
      </header>

      {{-- No results --}}
      <div id="no-result-msg" class="hidden text-center py-12">
        <span class="material-symbols-outlined text-4xl text-outline mb-3 block">search_off</span>
        <p class="text-on-surface-variant font-semibold">Toko tidak ditemukan</p>
        <p class="text-outline text-sm mt-1">Coba kata kunci lain</p>
      </div>

      {{-- Shop Cards --}}
      <div id="shop-card-list" class="grid grid-cols-1 md:grid-cols-1 xl:grid-cols-2 gap-4">
        @forelse ($tokoList as $toko)
        <div
          class="shop-card stat-card bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 cursor-pointer group hover:border-primary/30"
          data-shop-name="{{ strtolower($toko->Nama_Toko) }}">
          <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
              <span class="material-symbols-outlined text-2xl text-primary" style="font-variation-settings:'FILL' 1">storefront</span>
            </div>
            <span class="text-xs font-bold bg-green-50 text-green-600 px-3 py-1 rounded-full flex items-center gap-1">
              <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse inline-block"></span>
              Buka
            </span>
          </div>
          <h3 class="text-base font-headline font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">
            {{ $toko->Nama_Toko }}
          </h3>
          <div class="flex flex-col gap-1.5 text-sm text-on-surface-variant mb-4">
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[16px] text-outline">location_on</span>
              <span class="truncate">{{ $toko->Lokasi_Toko }}</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[16px] text-outline">call</span>
              <span>{{ $toko->Nomer_Telepon_Toko }}</span>
            </div>
            <div class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[16px] text-outline">mail</span>
              <span class="truncate">{{ $toko->Email_Toko }}</span>
            </div>
          </div>
          <div class="flex justify-between items-center border-t border-outline-variant/30 pt-3 mt-1">
            <div>
              <p class="text-[10px] uppercase font-bold text-outline tracking-wider">Total Transaksi</p>
              <p class="text-lg font-headline font-bold text-on-surface">
                {{ number_format($toko->Total_Pembelian) }}<span class="text-xs font-normal text-outline"> order</span>
              </p>
            </div>
            <a href="{{ route('MarketPlace', $toko->ID_Toko) }}"
              class="bg-primary text-on-primary p-2.5 rounded-xl hover:bg-primary-container transition-all inline-flex items-center justify-center shadow-sm hover:shadow-md">
              <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            </a>
          </div>
        </div>
        @empty
        <div class="text-center py-16">
          <span class="material-symbols-outlined text-5xl text-outline mb-3 block">store</span>
          <p class="text-on-surface-variant font-semibold">Belum ada toko terdaftar</p>
          <p class="text-outline text-sm mt-1">Daftar sebagai penjual pertama!</p>
        </div>
        @endforelse
      </div>
    </section>

    {{-- Right: Map --}}
    <div id="map" class="flex-1 h-full"></div>

    <script>
      window.MAP_CONFIG = {
        iconUrl: '{{ asset("img/rumah1.png") }}',
        stores: [
          @foreach($tokoList as $toko)
            @if($toko->latitude && $toko->longitude)
              {
                id: {{ $toko->ID_Toko }},
                name: "{!! addslashes($toko->Nama_Toko) !!}",
                lat: {{ $toko->latitude }},
                lng: {{ $toko->longitude }},
                address: "{!! addslashes($toko->Lokasi_Toko) !!}",
                url: "{{ route('MarketPlace', $toko->ID_Toko) }}"
              },
            @endif
          @endforeach
        ]
      };
    </script>

  </div>

  @push('scripts')
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
