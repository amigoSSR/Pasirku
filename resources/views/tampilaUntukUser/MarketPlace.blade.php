@push('leaflet-css')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush

@push('leaflet-js')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endpush

<x-layout-user title="Marketplace">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Store Header Banner --}}
    <div class="relative overflow-hidden bg-primary text-on-primary rounded-2xl p-7 shadow-sm">
      <div class="absolute top-0 right-0 -mr-12 -mt-12 w-56 h-56 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-40 h-40 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-5">
        <div class="flex flex-col md:flex-row gap-6 md:items-center">
          <div class="w-28 h-28 md:w-36 md:h-36 rounded-3xl bg-white/20 backdrop-blur-md border-4 border-white/30 overflow-hidden shadow-2xl shrink-0">
            @if($toko->Foto_Toko)
              <img src="{{ asset('storage/' . $toko->Foto_Toko) }}" class="w-full h-full object-cover" alt="{{ $toko->Nama_Toko }}">
            @else
              <div class="w-full h-full flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-6xl" style="font-variation-settings:'FILL' 1">storefront</span>
              </div>
            @endif
          </div>
          <div>
            <span class="text-xs font-bold text-primary-fixed uppercase tracking-widest mb-2 block flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[15px]" style="font-variation-settings:'FILL' 1">storefront</span>
              Profil Toko
            </span>
            <h1 class="text-3xl md:text-4xl font-headline font-extrabold tracking-tight mb-3 drop-shadow-sm">
              {{ $toko->Nama_Toko }}
            </h1>
            <div class="flex flex-wrap gap-2 text-sm">
              <div class="flex items-center gap-1.5 bg-on-primary/15 backdrop-blur-md py-1.5 px-3 rounded-full">
                <span class="material-symbols-outlined text-[16px]">location_on</span>
                {{ $toko->Lokasi_Toko }}
              </div>
              <div class="flex items-center gap-1.5 bg-on-primary/15 backdrop-blur-md py-1.5 px-3 rounded-full">
                <span class="material-symbols-outlined text-[16px]">call</span>
                {{ $toko->Nomer_Telepon_Toko }}
              </div>
            </div>
          </div>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('chat.start', $toko->ID_Toko) }}" class="bg-surface-container-lowest text-primary py-2 px-5 rounded-full font-bold hover:bg-surface-container-low transition-all hover:shadow-md flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-[18px]">chat</span>
            Chat Toko
          </a>
        </div>
      </div>
    </div>

    {{-- Store Info & Location --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      {{-- Address Details --}}
      <div class="lg:col-span-1 bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30 flex flex-col justify-between">
        <div>
          <div class="flex items-center gap-2.5 mb-4">
            <div class="w-9 h-9 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">pin_drop</span>
            </div>
            <h3 class="font-headline font-bold text-lg text-on-surface">Detail Alamat Toko</h3>
          </div>
          
          <div class="space-y-3.5 text-sm">
            @if($toko->detail_alamat)
              <div>
                <span class="text-[10px] font-bold text-outline uppercase tracking-wider block">Alamat Lengkap</span>
                <p class="text-on-surface font-semibold mt-0.5">{{ $toko->detail_alamat }}</p>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider block">Kecamatan</span>
                  <p class="text-on-surface font-semibold mt-0.5">{{ $toko->kecamatan }}</p>
                </div>
                <div>
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider block">Kota / Kabupaten</span>
                  <p class="text-on-surface font-semibold mt-0.5">{{ $toko->kota }}</p>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider block">Provinsi</span>
                  <p class="text-on-surface font-semibold mt-0.5">{{ $toko->provinsi }}</p>
                </div>
                <div>
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider block">Kode Pos</span>
                  <p class="text-on-surface font-semibold mt-0.5">{{ $toko->kode_pos }}</p>
                </div>
              </div>
            @else
              <div class="text-on-surface-variant flex items-center gap-2 py-4">
                <span class="material-symbols-outlined text-outline">info</span>
                <span>Toko belum memperbarui alamat terstruktur.</span>
              </div>
              <div>
                <span class="text-[10px] font-bold text-outline uppercase tracking-wider block">Lokasi</span>
                <p class="text-on-surface font-semibold mt-0.5">{{ $toko->Lokasi_Toko }}</p>
              </div>
            @endif
          </div>
        </div>

        @if($toko->latitude && $toko->longitude)
          <div class="mt-6 pt-4 border-t border-outline-variant/30 flex items-center justify-between text-xs text-on-surface-variant">
            <span class="flex items-center gap-1 font-mono">
              <span class="material-symbols-outlined text-sm text-primary">my_location</span>
              {{ number_format($toko->latitude, 6) }}, {{ number_format($toko->longitude, 6) }}
            </span>
            <a href="https://www.google.com/maps/search/?api=1&query={{ $toko->latitude }},{{ $toko->longitude }}" target="_blank" class="text-primary font-bold hover:underline flex items-center gap-0.5">
              Buka di Google Maps
              <span class="material-symbols-outlined text-sm">open_in_new</span>
            </a>
          </div>
        @endif
      </div>

      {{-- Read-only Leaflet Map --}}
      <div class="lg:col-span-2 bg-surface-container-lowest p-4 rounded-2xl shadow-sm border border-outline-variant/30 flex flex-col h-[320px] lg:h-auto min-h-[300px]">
        @if($toko->latitude && $toko->longitude)
          <div id="read-only-map" class="w-full h-full rounded-xl border border-outline-variant/20 overflow-hidden shadow-inner relative z-0"></div>
        @else
          <div class="w-full h-full rounded-xl bg-surface-container-low/40 flex flex-col items-center justify-center text-center p-6 border-2 border-dashed border-outline-variant/40">
            <div class="w-14 h-14 bg-surface-container rounded-full flex items-center justify-center mb-3">
              <span class="material-symbols-outlined text-3xl text-outline">map</span>
            </div>
            <h4 class="font-headline font-bold text-on-surface mb-1">Peta tidak tersedia</h4>
            <p class="text-xs text-on-surface-variant max-w-xs">Toko belum memetakan lokasi operasional mereka di peta.</p>
          </div>
        @endif
      </div>
    </div>

    {{-- Rating & Reviews Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      {{-- Rating Summary --}}
      <div class="lg:col-span-4 bg-surface-container-lowest p-6 rounded-3xl shadow-sm border border-outline-variant/30">
        <h3 class="font-headline font-bold text-lg text-on-surface mb-6 flex items-center gap-2">
          <span class="material-symbols-outlined text-amber-500" style="font-variation-settings:'FILL' 1">star</span>
          Rating & Ulasan Toko
        </h3>

        <div class="flex items-center gap-6 mb-8">
          <div class="text-center">
            <div class="text-5xl font-black text-on-surface tracking-tighter">{{ number_format($averageRating, 1) }}</div>
            <div class="flex text-amber-500 justify-center mt-1">
              @for($i=1; $i<=5; $i++)
                <span class="material-symbols-outlined text-lg {{ $i <= round($averageRating) ? '' : 'opacity-30' }}" style="font-variation-settings:'FILL' 1">star</span>
              @endfor
            </div>
            <p class="text-[10px] font-bold text-on-surface-variant uppercase mt-2 tracking-widest">{{ $totalReviews }} Ulasan</p>
          </div>
          <div class="flex-1 space-y-2">
             @foreach($ratingDistribution as $star => $count)
               @php
                 $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
               @endphp
               <div class="flex items-center gap-3">
                 <span class="text-[10px] font-black text-on-surface-variant w-3">{{ $star }}</span>
                 <div class="flex-1 h-2 bg-surface-container rounded-full overflow-hidden">
                   <div class="h-full bg-amber-500 rounded-full" style="width: {{ $percentage }}%"></div>
                 </div>
                 <span class="text-[10px] font-bold text-on-surface-variant w-6 text-right">{{ $count }}</span>
               </div>
             @endforeach
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="bg-surface-container-low p-4 rounded-2xl border border-outline-variant/20">
            <span class="material-symbols-outlined text-primary mb-1">groups</span>
            <div class="text-lg font-black text-on-surface leading-none">{{ $totalBuyers }}</div>
            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mt-1">Total Pembeli</p>
          </div>
          <div class="bg-surface-container-low p-4 rounded-2xl border border-outline-variant/20">
            <span class="material-symbols-outlined text-green-600 mb-1">verified</span>
            <div class="text-lg font-black text-on-surface leading-none">{{ $totalReviews }}</div>
            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider mt-1">Ulasan Valid</p>
          </div>
        </div>
      </div>

      {{-- Reviews List --}}
      <div class="lg:col-span-8 bg-surface-container-lowest p-6 rounded-3xl shadow-sm border border-outline-variant/30 flex flex-col">
        <div class="flex items-center justify-between mb-6">
          <h3 class="font-headline font-bold text-lg text-on-surface">Ulasan Terbaru</h3>
          @if($totalReviews > 5)
            <button class="text-sm font-bold text-primary hover:underline">Lihat Semua</button>
          @endif
        </div>

        <div class="space-y-6 flex-1">
          @forelse($recentReviews as $review)
            <div class="flex gap-4 pb-6 border-b border-outline-variant/10 last:border-0">
              <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-primary text-xl">person</span>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2 mb-1">
                  <h4 class="font-bold text-sm text-on-surface truncate">
                    {{ $review->is_anonymous ? 'Anonim' : ($review->akun->Username ?? 'User') }}
                  </h4>
                  <span class="text-[10px] font-medium text-on-surface-variant shrink-0">{{ $review->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex text-amber-500 mb-2">
                  @for($i=1; $i<=5; $i++)
                    <span class="material-symbols-outlined text-sm {{ $i <= $review->Rating ? '' : 'opacity-30' }}" style="font-variation-settings:'FILL' 1">star</span>
                  @endfor
                </div>
                <p class="text-sm text-on-surface-variant leading-relaxed">
                  {{ $review->Ulasan ?: 'Tidak ada komentar.' }}
                </p>
                @if($review->Foto_Review)
                  <div class="mt-3">
                    <img src="{{ asset('storage/' . $review->Foto_Review) }}" class="w-24 h-24 object-cover rounded-xl border border-outline-variant/20 cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src)">
                  </div>
                @endif
              </div>
            </div>
          @empty
            <div class="flex flex-col items-center justify-center h-full py-10 text-center">
               <span class="material-symbols-outlined text-4xl text-outline-variant mb-2">rate_review</span>
               <p class="text-sm text-on-surface-variant font-medium">Belum ada ulasan untuk toko ini.</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Product Count Header --}}
    <div class="flex items-center justify-between">
      <div>
        <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-1">
          <a href="{{ route('MenuUtama') }}" class="hover:text-primary transition-colors">Home</a>
          <span class="material-symbols-outlined text-[14px]">chevron_right</span>
          <span class="font-semibold text-primary">{{ $toko->Nama_Toko }}</span>
        </nav>
        <h2 class="text-xl font-headline font-bold text-on-surface">Produk Tersedia</h2>
      </div>
      <div class="text-sm text-on-surface-variant bg-surface-container py-1.5 px-4 rounded-full font-semibold border border-outline-variant/30">
        {{ $isiToko->count() }} Produk
      </div>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 pb-24 md:pb-10">
      @forelse($isiToko as $produk)
        @php
          $kubikasiPickUp = $produk->Kubikasi_PickUp ?? 1;
          $kubikasiTruck = $produk->Kubikasi_Truck ?? 1;
          $hargaKendaraanPickUp = $produk->Harga * $kubikasiPickUp;
          $hargaKendaraanTruck = $produk->Harga * $kubikasiTruck;
        @endphp
        <div class="stat-card group bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 hover:border-primary/30 transition-all duration-300 flex flex-col overflow-hidden">

          {{-- Product Image/Header --}}
          <div class="bg-surface-container-low flex items-center justify-center relative overflow-hidden h-40 p-0">
            @if($produk->Gambar)
              <img src="{{ asset('storage/' . $produk->Gambar) }}" alt="{{ $produk->Nama_Pasir }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
              <span class="material-symbols-outlined text-7xl text-primary/20 group-hover:text-primary/40 transition-all duration-300 group-hover:scale-110 transform">landscape</span>
            @endif
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-4">
              <h3 class="font-headline font-bold text-lg text-white tracking-tight drop-shadow-md">{{ $produk->Nama_Pasir }}</h3>
            </div>
          </div>

          {{-- Pricing Grid --}}
          <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1">

            {{-- Pick Up --}}
            <div class="bg-surface-container-low border border-outline-variant/30 rounded-xl p-3 flex flex-col gap-2">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-tertiary/10 rounded-lg flex items-center justify-center">
                  <span class="material-symbols-outlined text-[16px] text-tertiary">directions_car</span>
                </div>
                <span class="text-[10px] font-bold text-tertiary uppercase tracking-wider">Pick Up</span>
              </div>
              <div class="flex flex-col gap-0.5">
                <div class="text-[9px] text-on-surface-variant uppercase font-semibold">Harga per {{ (float)$kubikasiPickUp }} m³</div>
                <div class="text-base font-headline font-extrabold text-on-surface tracking-tight">
                  Rp {{ number_format($hargaKendaraanPickUp, 0, ',', '.') }}
                </div>
              </div>
              
              <div class="flex items-center justify-between mt-auto pt-1">
                @if($produk->Stock_PickUp === 0)
                  <span class="text-[9px] font-bold text-rose-600 uppercase">Habis</span>
                @else
                  <span class="text-[9px] font-bold text-emerald-600 uppercase">Stok {{ $produk->Stock_PickUp }}</span>
                @endif
              </div>

              <div class="relative mt-1 min-h-[34px]">
                @if($produk->Stock_PickUp > 0)
                <button
                  id="btn-add-pickup-{{ $produk->ID_Isi_Toko }}"
                  onclick="addToCart('{{ $produk->ID_Isi_Toko }}', 'pickup', {{ $hargaKendaraanPickUp }}, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Ongkir_PickUp ?? 0 }})"
                  class="qty-control w-full bg-tertiary text-on-tertiary py-1.5 rounded-lg text-xs font-semibold hover:bg-tertiary-container transition-colors flex items-center justify-center gap-1 active:scale-95 duration-200">
                  <span class="material-symbols-outlined text-[14px]">add_shopping_cart</span>
                  Pesan
                </button>
                <div id="qty-pickup-{{ $produk->ID_Isi_Toko }}"
                     class="qty-control hidden w-full flex items-center justify-between bg-tertiary text-on-tertiary rounded-lg overflow-hidden">
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'pickup', -1, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $hargaKendaraanPickUp }}, {{ $produk->Ongkir_PickUp ?? 0 }})"
                          class="px-2.5 py-1.5 text-base font-black hover:bg-on-tertiary/10 transition-colors active:bg-on-tertiary/20 select-none">−</button>
                  <span id="qty-num-pickup-{{ $produk->ID_Isi_Toko }}" class="font-bold text-xs">1</span>
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'pickup', +1, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $hargaKendaraanPickUp }}, {{ $produk->Ongkir_PickUp ?? 0 }})"
                          class="px-2.5 py-1.5 text-base font-black hover:bg-on-tertiary/10 transition-colors active:bg-on-tertiary/20 select-none">+</button>
                </div>
                @else
                <button disabled class="w-full bg-surface-container text-on-surface-variant py-1.5 rounded-lg text-xs font-semibold flex items-center justify-center opacity-60 cursor-not-allowed">
                  Habis
                </button>
                @endif
              </div>
            </div>

            {{-- Truck --}}
            <div class="bg-surface-container-low border border-outline-variant/30 rounded-xl p-3 flex flex-col gap-2">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-primary/10 rounded-lg flex items-center justify-center">
                  <span class="material-symbols-outlined text-[16px] text-primary">local_shipping</span>
                </div>
                <span class="text-[10px] font-bold text-primary uppercase tracking-wider">Truk</span>
              </div>
              <div class="flex flex-col gap-0.5">
                <div class="text-[9px] text-on-surface-variant uppercase font-semibold">Harga per {{ (float)$kubikasiTruck }} m³</div>
                <div class="text-base font-headline font-extrabold text-on-surface tracking-tight">
                  Rp {{ number_format($hargaKendaraanTruck, 0, ',', '.') }}
                </div>
              </div>

              <div class="flex items-center justify-between mt-auto pt-1">
                @if($produk->Stock_Truck === 0)
                  <span class="text-[9px] font-bold text-rose-600 uppercase">Habis</span>
                @else
                  <span class="text-[9px] font-bold text-emerald-600 uppercase">Stok {{ $produk->Stock_Truck }}</span>
                @endif
              </div>

              <div class="relative mt-1 min-h-[34px]">
                @if($produk->Stock_Truck > 0)
                <button
                  id="btn-add-truck-{{ $produk->ID_Isi_Toko }}"
                  onclick="addToCart('{{ $produk->ID_Isi_Toko }}', 'truck', {{ $hargaKendaraanTruck }}, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Ongkir_Truck ?? 0 }})"
                  class="qty-control w-full bg-primary text-on-primary py-1.5 rounded-lg text-xs font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-1 active:scale-95 duration-200">
                  <span class="material-symbols-outlined text-[14px]">add_shopping_cart</span>
                  Pesan
                </button>
                <div id="qty-truck-{{ $produk->ID_Isi_Toko }}"
                     class="qty-control hidden w-full flex items-center justify-between bg-primary text-on-primary rounded-lg overflow-hidden">
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'truck', -1, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $hargaKendaraanTruck }}, {{ $produk->Ongkir_Truck ?? 0 }})"
                          class="px-2.5 py-1.5 text-base font-black hover:bg-on-primary/10 transition-colors active:bg-on-primary/20 select-none">−</button>
                  <span id="qty-num-truck-{{ $produk->ID_Isi_Toko }}" class="font-bold text-xs">1</span>
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'truck', +1, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $hargaKendaraanTruck }}, {{ $produk->Ongkir_Truck ?? 0 }})"
                          class="px-2.5 py-1.5 text-base font-black hover:bg-on-primary/10 transition-colors active:bg-on-primary/20 select-none">+</button>
                </div>
                @else
                <button disabled class="w-full bg-surface-container text-on-surface-variant py-1.5 rounded-lg text-xs font-semibold flex items-center justify-center opacity-60 cursor-not-allowed">
                  Habis
                </button>
                @endif
              </div>
            </div>

          </div>
        </div>
      @empty
        <div class="col-span-full bg-surface-container-lowest p-16 rounded-2xl text-center border-2 border-dashed border-outline-variant/50 shadow-sm flex flex-col items-center justify-center">
          <div class="w-20 h-20 bg-surface-container rounded-full flex items-center justify-center mb-5">
            <span class="material-symbols-outlined text-4xl text-outline">inventory_2</span>
          </div>
          <h2 class="text-xl font-headline font-bold mb-2 text-on-surface">Belum ada produk</h2>
          <p class="text-on-surface-variant max-w-sm text-sm">Toko ini masih mempersiapkan katalog. Silakan kembali lagi nanti.</p>
        </div>
      @endforelse
    </div>

  </div>

  {{-- Floating Cart FAB --}}
  <style>
    #cart-fab { position:fixed; bottom:5rem; right:1.5rem; z-index:9999; width:60px; height:60px; border-radius:50%; background:#944a00; box-shadow:0 6px 24px rgba(148,74,0,.5); display:none; align-items:center; justify-content:center; cursor:pointer; user-select:none; transition:transform .18s cubic-bezier(.34,1.56,.64,1),box-shadow .18s ease; }
    #cart-fab:hover { transform:scale(1.12); box-shadow:0 10px 32px rgba(148,74,0,.65); }
    #cart-fab:active { transform:scale(0.92); }
    @keyframes fabPopIn { 0%{transform:scale(.4);opacity:0} 70%{transform:scale(1.1);opacity:1} 100%{transform:scale(1);opacity:1} }
    #cart-fab.pop-in { animation:fabPopIn .35s cubic-bezier(.34,1.56,.64,1) both; }
    @keyframes badgeBounce { 0%,100%{transform:scale(1)} 40%{transform:scale(1.5)} 70%{transform:scale(.85)} }
    #cart-fab-badge.bounce { animation:badgeBounce .35s ease; }
    #cart-fab-ring { position:fixed; bottom:5rem; right:1.5rem; z-index:9998; width:60px; height:60px; border-radius:50%; background:rgba(148,74,0,.3); display:none; animation:fabPing 1.4s ease-out infinite; pointer-events:none; }
    @keyframes fabPing { 0%{transform:scale(1);opacity:.6} 100%{transform:scale(1.75);opacity:0} }
    .qty-control { transition:all .25s cubic-bezier(.34,1.56,.64,1); }
  </style>

  <div id="cart-fab-ring"></div>
  <div id="cart-fab" role="button" aria-label="Lihat keranjang belanja" onclick="goToCheckout()">
    <span class="material-symbols-outlined" style="font-size:26px;color:#fff;pointer-events:none;font-variation-settings:'FILL' 1,'wght' 600,'GRAD' 0,'opsz' 24;">shopping_cart</span>
    <div id="cart-fab-badge" style="position:absolute;top:-5px;right:-5px;width:20px;height:20px;background:#ba1a1a;color:#fff;border-radius:50%;border:2px solid #f8f9fa;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:900;line-height:1;box-shadow:0 2px 6px rgba(0,0,0,.3);pointer-events:none;user-select:none;">0</div>
  </div>

  @push('scripts')
  <script>
    const TOKO_DATA = {
      id: {{ $toko->ID_Toko }},
      nama: @json($toko->Nama_Toko),
      lokasi: @json($toko->Lokasi_Toko),
      ongkirPickUp: {{ $toko->Ongkir_PickUp }},
      ongkirTruck: {{ $toko->Ongkir_Truck }},
      latitude: {{ $toko->latitude ?? 'null' }},
      longitude: {{ $toko->longitude ?? 'null' }},
    };

    let cartItems = {};

    // Load existing cart for THIS store if any
    document.addEventListener('DOMContentLoaded', () => {
      const existingCart = JSON.parse(sessionStorage.getItem('pasirku_cart') || '[]');
      existingCart.forEach(item => {
        if (item.tokoId === TOKO_DATA.id) {
          cartItems[item.key] = {
            qty: item.qty,
            harga: item.harga,
            stock: 999, // stock info might be outdated, but we need it for UI
            namaPasir: item.namaPasir,
            type: item.type
          };
          
          // Update UI for buttons
          const btn = document.getElementById('btn-add-'+item.type+'-'+item.key.split('_')[0]);
          const qtyDiv = document.getElementById('qty-'+item.type+'-'+item.key.split('_')[0]);
          const qtyNum = document.getElementById('qty-num-'+item.type+'-'+item.key.split('_')[0]);
          
          if (btn && qtyDiv && qtyNum) {
            btn.classList.add('hidden');
            qtyDiv.classList.remove('hidden');
            qtyNum.textContent = item.qty;
          }
        }
      });
      updateCartUI();
    });

    function totalCartQty() { 
      // Total for all stores in sessionStorage + current local cart
      const existingCart = JSON.parse(sessionStorage.getItem('pasirku_cart') || '[]');
      const otherStoresQty = existingCart.filter(i => i.tokoId !== TOKO_DATA.id).reduce((s,v)=>s+v.qty, 0);
      return otherStoresQty + Object.values(cartItems).reduce((s,v)=>s+v.qty,0); 
    }

    function updateCartUI() {
      const total=totalCartQty(), badge=document.getElementById('cart-fab-badge'), fab=document.getElementById('cart-fab'), ring=document.getElementById('cart-fab-ring');
      if (badge) {
        badge.textContent=total;
        badge.classList.remove('bounce'); void badge.offsetWidth; badge.classList.add('bounce');
      }
      if(total>0){if(fab && (fab.style.display==='none'||fab.style.display==='')){fab.style.display='flex';if(ring)ring.style.display='block';fab.classList.remove('pop-in');void fab.offsetWidth;fab.classList.add('pop-in');}}else{if(fab)fab.style.display='none';if(ring)ring.style.display='none';}
    }

    function addToCart(produkId,type,harga,stock,namaPasir,ongkir){
      const key=produkId+'_'+type;
      cartItems[key]={qty:1,harga,stock,namaPasir,type,ongkir};
      const btn = document.getElementById('btn-add-'+type+'-'+produkId);
      const qtyDiv = document.getElementById('qty-'+type+'-'+produkId);
      if (btn) btn.classList.add('hidden');
      if (qtyDiv) {
        qtyDiv.classList.remove('hidden');
        document.getElementById('qty-num-'+type+'-'+produkId).textContent=1;
      }
      updateCartUI();
    }

    function changeQty(produkId,type,delta,stock,namaPasir,harga,ongkir){
      const key=produkId+'_'+type;
      if(!cartItems[key])cartItems[key]={qty:0,harga,stock,namaPasir,type,ongkir};
      let newQty=cartItems[key].qty+delta;
      if(newQty>stock)newQty=stock;
      if(newQty<=0){
        delete cartItems[key];
        document.getElementById('qty-'+type+'-'+produkId).classList.add('hidden');
        document.getElementById('btn-add-'+type+'-'+produkId).classList.remove('hidden');
      }else{
        cartItems[key].qty=newQty;
        document.getElementById('qty-num-'+type+'-'+produkId).textContent=newQty;
      }
      updateCartUI();
    }

    function goToCheckout(){
      // Get all items from sessionStorage (other stores)
      let fullCart = JSON.parse(sessionStorage.getItem('pasirku_cart') || '[]');
      
      // Remove items from THIS store (we will re-add current state)
      fullCart = fullCart.filter(item => item.tokoId !== TOKO_DATA.id);
      
      // Add current store's items
      const currentItems = Object.entries(cartItems).map(([key,v])=>({
        key,
        namaPasir:v.namaPasir,
        type:v.type,
        qty:v.qty,
        harga:v.harga,
        ongkir:v.ongkir,
        tokoId: TOKO_DATA.id,
        tokoNama: TOKO_DATA.nama,
        tokoLokasi: TOKO_DATA.lokasi,
        ongkirPickUp: TOKO_DATA.ongkirPickUp,
        ongkirTruck: TOKO_DATA.ongkirTruck
      }));
      
      fullCart = [...fullCart, ...currentItems];
      
      if(fullCart.length===0)return;
      
      sessionStorage.setItem('pasirku_cart', JSON.stringify(fullCart));
      // Store info for each store in a map
      let storesMap = JSON.parse(sessionStorage.getItem('pasirku_stores') || '{}');
      storesMap[TOKO_DATA.id] = TOKO_DATA;
      sessionStorage.setItem('pasirku_stores', JSON.stringify(storesMap));
      
      // For backward compatibility (legacy pages might still expect pasirku_toko)
      sessionStorage.setItem('pasirku_toko', JSON.stringify(TOKO_DATA));
      
      window.location.href='{{ route('keranjang') }}';
    }

    @if($toko->latitude && $toko->longitude)
    document.addEventListener('DOMContentLoaded', () => {
      let lat = {{ $toko->latitude }};
      let lng = {{ $toko->longitude }};
      
      const readOnlyMap = L.map('read-only-map').setView([lat, lng], 14);
      
      L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
      }).addTo(readOnlyMap);

      const marker = L.marker([lat, lng]).addTo(readOnlyMap);
      marker.bindPopup(`<strong class="text-primary font-headline">{{ $toko->Nama_Toko }}</strong><br><span class="text-xs text-on-surface-variant">{{ $toko->Lokasi_Toko }}</span>`).openPopup();
    });
    @endif
  </script>
  @endpush

</x-layout-user>
