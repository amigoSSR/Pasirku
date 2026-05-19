<x-layout-user title="Marketplace">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Store Header Banner --}}
    <div class="relative overflow-hidden bg-primary text-on-primary rounded-2xl p-7 shadow-sm">
      <div class="absolute top-0 right-0 -mr-12 -mt-12 w-56 h-56 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-40 h-40 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-5">
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
        <div class="flex gap-2">
          <a href="{{ route('chat.start', $toko->ID_Toko) }}" class="bg-surface-container-lowest text-primary py-2 px-5 rounded-full font-bold hover:bg-surface-container-low transition-all hover:shadow-md flex items-center gap-2 text-sm">
            <span class="material-symbols-outlined text-[18px]">chat</span>
            Chat Toko
          </a>
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

          {{-- Pricing --}}
          <div class="p-4 flex flex-col flex-1 gap-3">

            {{-- Pick Up --}}
            <div class="bg-surface-container-low border border-outline-variant/30 rounded-xl p-3 flex flex-col gap-2">
              <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-tertiary/10 rounded-lg flex items-center justify-center">
                  <span class="material-symbols-outlined text-[16px] text-tertiary">directions_car</span>
                </div>
                <span class="text-xs font-bold text-tertiary uppercase tracking-wider">Mobil Pick Up</span>
              </div>
              <div class="flex items-end justify-between">
                <div>
                  <div class="text-[10px] text-on-surface-variant uppercase font-semibold">Harga / unit</div>
                  <div class="text-lg font-headline font-extrabold text-on-surface tracking-tight">
                    Rp {{ number_format($produk->Harga_PickUp, 0, ',', '.') }}
                  </div>
                </div>
                <div class="flex items-center gap-1.5 bg-surface-container py-1 px-2.5 rounded-full border border-outline-variant/30">
                  <span class="w-1.5 h-1.5 rounded-full {{ $produk->Stock_PickUp > 0 ? 'bg-green-500 animate-pulse' : 'bg-error' }}"></span>
                  <span class="text-xs font-bold text-on-surface-variant">Sisa {{ $produk->Stock_PickUp }}</span>
                </div>
              </div>
              <div class="relative mt-1 min-h-[38px]">
                @if($produk->Stock_PickUp > 0)
                <button
                  id="btn-add-pickup-{{ $produk->ID_Isi_Toko }}"
                  onclick="addToCart('{{ $produk->ID_Isi_Toko }}', 'pickup', {{ $produk->Harga_PickUp }}, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}')"
                  class="qty-control w-full bg-tertiary text-on-tertiary py-2 rounded-xl text-sm font-semibold hover:bg-tertiary-container transition-colors flex items-center justify-center gap-1.5 active:scale-95 duration-200">
                  <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                  Pesan Pick Up
                </button>
                <div id="qty-pickup-{{ $produk->ID_Isi_Toko }}"
                     class="qty-control hidden w-full flex items-center justify-between bg-tertiary text-on-tertiary rounded-xl overflow-hidden">
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'pickup', -1, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_PickUp }})"
                          class="px-4 py-2 text-lg font-black hover:bg-on-tertiary/10 transition-colors active:bg-on-tertiary/20 select-none">−</button>
                  <span id="qty-num-pickup-{{ $produk->ID_Isi_Toko }}" class="font-bold text-base">1</span>
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'pickup', +1, {{ $produk->Stock_PickUp }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_PickUp }})"
                          class="px-4 py-2 text-lg font-black hover:bg-on-tertiary/10 transition-colors active:bg-on-tertiary/20 select-none">+</button>
                </div>
                @else
                <button disabled class="w-full bg-surface-container text-on-surface-variant py-2 rounded-xl text-sm font-semibold flex items-center justify-center gap-1.5 opacity-60 cursor-not-allowed">
                  <span class="material-symbols-outlined text-[16px]">remove_shopping_cart</span>
                  Stok Habis
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
                <span class="text-xs font-bold text-primary uppercase tracking-wider">Truk</span>
              </div>
              <div class="flex items-end justify-between">
                <div>
                  <div class="text-[10px] text-on-surface-variant uppercase font-semibold">Harga / unit</div>
                  <div class="text-lg font-headline font-extrabold text-on-surface tracking-tight">
                    Rp {{ number_format($produk->Harga_Truck, 0, ',', '.') }}
                  </div>
                </div>
                <div class="flex items-center gap-1.5 bg-surface-container py-1 px-2.5 rounded-full border border-outline-variant/30">
                  <span class="w-1.5 h-1.5 rounded-full {{ $produk->Stock_Truck > 0 ? 'bg-green-500 animate-pulse' : 'bg-error' }}"></span>
                  <span class="text-xs font-bold text-on-surface-variant">Sisa {{ $produk->Stock_Truck }}</span>
                </div>
              </div>
              <div class="relative mt-1 min-h-[38px]">
                @if($produk->Stock_Truck > 0)
                <button
                  id="btn-add-truck-{{ $produk->ID_Isi_Toko }}"
                  onclick="addToCart('{{ $produk->ID_Isi_Toko }}', 'truck', {{ $produk->Harga_Truck }}, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}')"
                  class="qty-control w-full bg-primary text-on-primary py-2 rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors flex items-center justify-center gap-1.5 active:scale-95 duration-200">
                  <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                  Pesan Truk
                </button>
                <div id="qty-truck-{{ $produk->ID_Isi_Toko }}"
                     class="qty-control hidden w-full flex items-center justify-between bg-primary text-on-primary rounded-xl overflow-hidden">
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'truck', -1, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_Truck }})"
                          class="px-4 py-2 text-lg font-black hover:bg-on-primary/10 transition-colors active:bg-on-primary/20 select-none">−</button>
                  <span id="qty-num-truck-{{ $produk->ID_Isi_Toko }}" class="font-bold text-base">1</span>
                  <button onclick="changeQty('{{ $produk->ID_Isi_Toko }}', 'truck', +1, {{ $produk->Stock_Truck }}, '{{ $produk->Nama_Pasir }}', {{ $produk->Harga_Truck }})"
                          class="px-4 py-2 text-lg font-black hover:bg-on-primary/10 transition-colors active:bg-on-primary/20 select-none">+</button>
                </div>
                @else
                <button disabled class="w-full bg-surface-container text-on-surface-variant py-2 rounded-xl text-sm font-semibold flex items-center justify-center gap-1.5 opacity-60 cursor-not-allowed">
                  <span class="material-symbols-outlined text-[16px]">remove_shopping_cart</span>
                  Stok Habis
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
    };
    let cartItems = {};
    function totalCartQty() { return Object.values(cartItems).reduce((s,v)=>s+v.qty,0); }
    function updateCartUI() {
      const total=totalCartQty(), badge=document.getElementById('cart-fab-badge'), fab=document.getElementById('cart-fab'), ring=document.getElementById('cart-fab-ring');
      badge.textContent=total;
      badge.classList.remove('bounce'); void badge.offsetWidth; badge.classList.add('bounce');
      if(total>0){if(fab.style.display==='none'||fab.style.display===''){fab.style.display='flex';ring.style.display='block';fab.classList.remove('pop-in');void fab.offsetWidth;fab.classList.add('pop-in');}}else{fab.style.display='none';ring.style.display='none';}
    }
    function addToCart(produkId,type,harga,stock,namaPasir){
      const key=produkId+'_'+type;
      cartItems[key]={qty:1,harga,stock,namaPasir,type};
      document.getElementById('btn-add-'+type+'-'+produkId).classList.add('hidden');
      const qtyDiv=document.getElementById('qty-'+type+'-'+produkId);
      qtyDiv.classList.remove('hidden');
      document.getElementById('qty-num-'+type+'-'+produkId).textContent=1;
      updateCartUI();
    }
    function changeQty(produkId,type,delta,stock,namaPasir,harga){
      const key=produkId+'_'+type;
      if(!cartItems[key])cartItems[key]={qty:0,harga,stock,namaPasir,type};
      let newQty=cartItems[key].qty+delta;
      if(newQty>stock)newQty=stock;
      if(newQty<=0){delete cartItems[key];document.getElementById('qty-'+type+'-'+produkId).classList.add('hidden');document.getElementById('btn-add-'+type+'-'+produkId).classList.remove('hidden');document.getElementById('qty-num-'+type+'-'+produkId).textContent=1;}else{cartItems[key].qty=newQty;document.getElementById('qty-num-'+type+'-'+produkId).textContent=newQty;}
      updateCartUI();
    }
    function goToCheckout(){
      if(totalCartQty()===0)return;
      const items=Object.entries(cartItems).map(([key,v])=>({key,namaPasir:v.namaPasir,type:v.type,qty:v.qty,harga:v.harga}));
      sessionStorage.setItem('pasirku_cart',JSON.stringify(items));
      sessionStorage.setItem('pasirku_toko',JSON.stringify(TOKO_DATA));
      window.location.href='{{ route('keranjang') }}';
    }
  </script>
  @endpush

</x-layout-user>
