<x-layout-user title="Checkout">

  @push('head')
  {{-- Leaflet CSS --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  <style>
    .strata-grid {
      display: grid;
      grid-template-columns: 1fr 400px;
      gap: 2rem;
    }
    @media (max-width: 1024px) {
      .strata-grid {
        grid-template-columns: 1fr;
      }
    }
    .input-industrial {
      background-color: #edeeef;
      border: none;
      border-bottom: 2px solid transparent;
      transition: border-bottom 0.2s ease;
    }
    .input-industrial:focus {
      border-bottom: 2px solid #944a00;
      box-shadow: none;
      outline: none;
    }
    /* Shimmer for empty state */
    @keyframes shimmer {
      0% { background-position: -400px 0; }
      100% { background-position: 400px 0; }
    }
    .shimmer {
      background: linear-gradient(90deg, #edeeef 25%, #e1e3e4 50%, #edeeef 75%);
      background-size: 800px 100%;
      animation: shimmer 1.5s infinite;
    }
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    
    .animate-fadeUp { animation: fadeUp 0.3s ease forwards; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  </style>
  @endpush

  <div class="max-w-7xl mx-auto px-6 pb-12">

    <!-- Back link & header -->
    <div class="mb-6">
      <button onclick="history.back()" class="flex items-center gap-1.5 text-sm text-on-surface-variant hover:text-primary font-semibold transition-colors group">
        <span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
        Kembali ke Toko
      </button>
    </div>

    <div class="mb-10">
      <p class="text-primary font-bold uppercase tracking-[0.2em] text-xs mb-2">Finalisasi Pesanan</p>
      <h1 class="text-4xl md:text-5xl font-headline font-black tracking-tight text-on-surface">Checkout</h1>
      <p id="checkout-store-name" class="mt-2 text-on-surface-variant font-medium flex items-center gap-2">
        <span class="material-symbols-outlined text-primary text-[18px]">storefront</span>
        <span id="store-name-text">Memuat informasi toko...</span>
      </p>
    </div>

    <div class="strata-grid">

      <!-- Left Column: Forms -->
      <div class="space-y-8">

        <!-- Section: Item Summary (Grouped by Store) -->
        <section class="bg-surface-container-low/50 p-6 md:p-8 rounded-2xl border border-outline-variant/30 relative overflow-hidden" id="cart-items-section">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">shopping_basket</span>
            </div>
            <h2 class="text-xl md:text-2xl font-headline font-bold text-on-surface">Item yang Dipesan</h2>
          </div>
          
          <div id="cart-items-list" class="space-y-4">
            <!-- Populated by JS as store rows -->
            <div class="shimmer h-20 rounded-2xl"></div>
            <div class="shimmer h-20 rounded-2xl opacity-60"></div>
          </div>

          <!-- Empty cart notice -->
          <div id="cart-empty-notice" class="hidden text-center py-12 text-on-surface-variant bg-surface-container-lowest rounded-2xl border border-dashed border-outline-variant/50">
            <span class="material-symbols-outlined text-6xl mb-4 block text-outline/30">remove_shopping_cart</span>
            <p class="font-bold text-lg text-on-surface">Keranjang Anda kosong</p>
            <p class="text-sm mt-1">Silakan pilih produk terlebih dahulu sebelum checkout.</p>
            <button onclick="window.location.href='{{ route('MenuUtama') }}'" class="mt-6 bg-primary text-on-primary px-8 py-3 rounded-full text-sm font-bold hover:bg-primary-container transition-all shadow-sm hover:shadow-md active:scale-95">
              Cari Toko Sekarang
            </button>
          </div>
        </section>

        <!-- Section: Shipping Address -->
        <section class="bg-surface-container-low/50 p-6 md:p-8 rounded-2xl border border-outline-variant/30">
          <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-secondary" style="font-variation-settings:'FILL' 1">local_shipping</span>
            </div>
            <h2 class="text-xl md:text-2xl font-headline font-bold text-on-surface">Alamat Pengiriman</h2>
          </div>
          
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
              <div class="flex flex-col gap-2">
                <label for="lokasi-pengantaran" class="text-[10px] font-bold text-secondary uppercase tracking-[0.15em] px-1">Lokasi Pengantaran</label>
                <div class="relative group">
                  <span class="material-symbols-outlined absolute left-4 top-4 text-on-surface-variant group-focus-within:text-primary transition-colors">location_on</span>
                  <input id="lokasi-pengantaran" class="bg-surface-container-highest/50 border-none rounded-xl pl-12 pr-4 py-4 w-full font-medium text-sm focus:ring-2 focus:ring-primary/20 transition-all"
                         placeholder="Masukkan alamat lengkap..." type="text" />
                </div>
                <p class="text-[10px] text-on-surface-variant font-medium">Contoh: Jl. Merdeka No. 10, Jakarta Pusat</p>
              </div>
              
              <button type="button" id="btn-search-delivery"
                class="w-full bg-primary text-on-primary hover:bg-primary-container py-4 px-6 rounded-2xl text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-sm active:scale-95 group">
                <span class="material-symbols-outlined text-[18px] group-hover:rotate-12 transition-transform">search</span>
                Cari & Plot di Peta
              </button>

              <div class="flex flex-col gap-2">
                <label for="detail-lokasi" class="text-[10px] font-bold text-secondary uppercase tracking-[0.15em] px-1">Detail Tambahan Lokasi</label>
                <textarea id="detail-lokasi" class="bg-surface-container-highest/50 border-none rounded-xl px-4 py-4 w-full resize-none font-medium text-sm focus:ring-2 focus:ring-primary/20 transition-all"
                           placeholder="Contoh: Masuk gang kedua, dekat pos satpam..." rows="3"></textarea>
                <p class="text-[10px] text-on-surface-variant font-medium">Opsional — patokan spesifik lokasi bongkar pasir.</p>
              </div>
            </div>

            <div class="flex flex-col gap-2">
              <label class="text-[10px] font-bold text-secondary uppercase tracking-[0.15em] px-1">Tentukan Pin Lokasi Bongkar</label>
              <div id="checkout-map" class="w-full aspect-[4/3] min-h-[250px] rounded-2xl border border-outline-variant/50 overflow-hidden shadow-inner relative z-0"></div>
              <div class="flex items-start gap-2 mt-2">
                <span class="material-symbols-outlined text-primary text-[16px] shrink-0">info</span>
                <p class="text-[10px] text-on-surface-variant font-medium leading-relaxed">
                  Geser <strong class="text-blue-600">pin biru</strong> ke titik tepat pengiriman. <strong class="text-error">Pin merah</strong> adalah lokasi toko.
                </p>
              </div>
            </div>
          </div>
        </section>

        <!-- Section: Delivery Schedule -->
        <section class="bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-sm border-l-[6px] border-primary-container relative">
          <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-primary-container/10 rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-primary-container" style="font-variation-settings:'FILL' 1">calendar_today</span>
            </div>
            <h2 class="text-xl md:text-2xl font-headline font-bold text-on-surface">Jadwal Pengiriman</h2>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant/20">
              <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-4 px-1">Pilih Tanggal</p>
              <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">event</span>
                <input id="tanggal-pengiriman" type="date" class="bg-surface-container-highest/50 border-none rounded-xl pl-12 pr-4 py-3 w-full font-bold text-on-surface focus:ring-2 focus:ring-primary/20"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       value="{{ now()->addDay()->format('Y-m-d') }}" />
              </div>
              <p class="text-[10px] text-on-surface-variant mt-2 px-1 font-medium italic">*Pengiriman minimal H+1</p>
            </div>

            <div class="bg-surface-container-low p-5 rounded-2xl border border-outline-variant/20">
              <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-4 px-1">Estimasi Waktu Tiba</p>
              <div class="flex flex-col gap-3">
                <div class="relative">
                  <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">schedule</span>
                  <input id="jam-mulai" type="time" value="08:00"
                         class="bg-surface-container-highest/50 border-none rounded-xl pl-12 pr-4 py-3 w-full font-bold text-on-surface text-lg focus:ring-2 focus:ring-primary/20"
                         oninput="hitungEstimasi()" />
                </div>
                <div id="estimasi-box" class="bg-primary/5 rounded-xl px-4 py-3 flex items-center gap-3 border border-primary/10">
                  <span class="material-symbols-outlined text-primary text-[24px]">timelapse</span>
                  <div>
                    <p id="estimasi-label" class="font-headline font-black text-primary text-base">08:00 – 12:00</p>
                    <p class="text-[10px] text-on-surface-variant font-medium">Rentang waktu kedatangan (±4 jam)</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>

      <!-- Right Column: Payment & Summary -->
      <div class="space-y-6">
        <div class="sticky top-[84px]">

          <!-- Order Summary Card -->
          <div class="bg-on-surface text-surface rounded-3xl p-8 mb-6 relative overflow-hidden shadow-xl">
            <div class="absolute -top-10 -right-10 opacity-[0.03]">
              <span class="material-symbols-outlined text-[200px]" style="font-variation-settings:'wght' 800">receipt_long</span>
            </div>

            <h3 class="text-[10px] font-bold uppercase tracking-[0.25em] mb-8 text-primary-fixed-dim">Ringkasan Pembayaran</h3>
            
            <div id="payment-summary-lines" class="space-y-4 mb-8 relative z-10">
              <!-- Populated by JS -->
            </div>

            <!-- Ongkir Section -->
            <div class="border-t border-surface-variant/10 pt-6 mb-4 space-y-4 relative z-10" id="ongkir-section">
              <!-- Populated by JS -->
            </div>

            <div class="border-t border-surface-variant/20 pt-8 mt-4 relative z-10">
              <div class="flex justify-between items-baseline">
                <span class="text-xs font-bold uppercase tracking-widest text-primary-fixed">Total Tagihan</span>
                <span id="grand-total" class="text-3xl font-headline font-black text-on-primary">Rp 0</span>
              </div>
            </div>
          </div>

          <!-- Payment Section -->
          <div class="bg-surface-container-lowest p-6 md:p-8 rounded-3xl shadow-xl border border-outline-variant/30">
            <h3 class="text-lg font-headline font-extrabold text-on-surface mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">qr_code_2</span>
              Pembayaran QRIS
            </h3>

            <div id="qris_wrapper" class="flex flex-col items-center mb-8">
              <div id="qris_loading" class="flex flex-col items-center justify-center py-10 gap-4 w-full bg-surface-container-low/30 rounded-2xl border border-dashed border-outline-variant/50">
                <div class="w-10 h-10 rounded-full border-[3px] border-primary/20 border-t-primary animate-spin"></div>
                <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest">Memuat QRIS Toko...</p>
              </div>
              <div id="qris_content" class="hidden w-full flex flex-col items-center gap-3"></div>
            </div>

            <!-- FORM KONFIRMASI PESANAN -->
            <form id="form-konfirmasi" method="POST"
                  action="{{ route('pesanan.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-6">
              @csrf

              {{-- Hidden inputs --}}
              <input type="hidden" name="id_toko"            id="h-id-toko">
              <input type="hidden" name="lokasi_pengantaran" id="h-lokasi">
              <input type="hidden" name="detail_lokasi"      id="h-detail-lokasi">
              <input type="hidden" name="unit"               id="h-unit">
              <input type="hidden" name="tanggal_pengiriman" id="h-tanggal">
              <input type="hidden" name="jam_tiba"           id="h-jam-tiba">
              <input type="hidden" name="total_harga"        id="h-total-harga">
              <input type="hidden" name="nama_produk"        id="h-nama-produk">
              <input type="hidden" name="tipe_pengiriman"    id="h-tipe-pengiriman">
              <input type="hidden" name="cart_items"         id="h-cart-items">

              <input type="file" id="input-bukti" name="bukti_pembayaran"
                     accept="image/*" class="hidden">

              <button type="button" id="btn-upload-bukti"
                      onclick="document.getElementById('input-bukti').click()"
                      class="w-full flex flex-col items-center justify-center gap-2 bg-surface-container-low border-2 border-dashed border-outline-variant/50 py-8 rounded-2xl font-bold hover:bg-surface-container-high hover:border-primary/50 transition-all group">
                <span class="material-symbols-outlined text-4xl text-outline group-hover:text-primary group-hover:scale-110 transition-all">cloud_upload</span>
                <span id="upload-label" class="text-xs text-on-surface-variant group-hover:text-primary transition-colors">Unggah Bukti Pembayaran (Max 5MB)</span>
              </button>

              <div id="preview-bukti" class="hidden rounded-2xl overflow-hidden border border-primary/30 bg-primary/5 p-4 animate-fadeUp">
                <div class="flex items-center gap-4">
                  <div class="relative flex-shrink-0">
                    <img id="preview-img" src="" alt="Preview Bukti"
                         class="w-16 h-16 object-cover rounded-xl shadow-md border-2 border-white">
                    <div class="absolute -top-1.5 -right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow-sm">
                      <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'wght' 700">check</span>
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-on-surface truncate" id="preview-filename"></p>
                    <p class="text-[10px] text-on-surface-variant font-medium mt-0.5" id="preview-filesize"></p>
                    <div class="flex items-center gap-1.5 mt-1.5">
                      <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                      <p class="text-[9px] text-green-700 font-bold uppercase tracking-wider">Siap Unggah</p>
                    </div>
                  </div>
                  <button type="button" id="btn-ganti-file"
                          onclick="resetUpload()"
                          class="flex-shrink-0 text-on-surface-variant hover:text-error transition-colors p-2 hover:bg-error/10 rounded-xl">
                    <span class="material-symbols-outlined text-[22px]">delete</span>
                  </button>
                </div>
              </div>

              @error('bukti_pembayaran')
                <p class="text-xs text-error font-bold px-1">{{ $message }}</p>
              @enderror

              <button type="submit" id="btn-konfirmasi"
                      class="w-full bg-primary text-on-primary py-5 rounded-2xl font-headline font-black text-lg shadow-lg hover:bg-primary-container hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:scale-100">
                <span id="konfirmasi-icon" class="material-symbols-outlined">verified_user</span>
                <span id="konfirmasi-label">KONFIRMASI PESANAN</span>
              </button>

              <p class="text-[9px] text-center text-on-surface-variant font-medium px-4">
                Dengan mengklik Konfirmasi, Anda menyetujui <span class="text-primary hover:underline cursor-pointer">Syarat & Ketentuan</span> pengiriman pasir.
              </p>
            </form>
          </div>

        </div>
      </div>

    </div>
  </div>

  @push('scripts')
  {{-- Leaflet JS --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  
  <script>
    /* -- Helpers ------------------------------------------- */
    function formatRupiah(angka) {
      return 'Rp ' + angka.toLocaleString('id-ID');
    }
    function formatBytes(bytes) {
      if (bytes < 1024) return bytes + ' B';
      if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
      return (bytes / 1048576).toFixed(1) + ' MB';
    }

    /* ── Render QRIS dari API ────────────────────────────────── */
    function loadQris(tokoId, tokoNama, grandTotal) {
      const loading = document.getElementById('qris_loading');
      const content = document.getElementById('qris_content');
      if(loading) loading.classList.remove('hidden');
      if(content) content.classList.add('hidden');

      fetch(`/api/store/${tokoId}/qris`)
        .then(res => res.json())
        .then(data => {
          if(loading) loading.classList.add('hidden');
          if(content) content.classList.remove('hidden');

          if (data.status === 'success') {
            content.innerHTML = `
              <div class="w-full bg-surface-container-low/50 rounded-2xl border border-outline-variant/30 p-5 flex flex-col items-center gap-4 animate-fadeUp">
                <div class="flex items-center justify-between w-full pb-3 border-b border-outline-variant/20">
                  <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">storefront</span>
                    <span class="text-xs font-bold text-on-surface">${tokoNama}</span>
                  </div>
                  <span class="text-xs font-black text-primary">${formatRupiah(grandTotal)}</span>
                </div>
                <div class="w-full flex justify-center py-2 relative group cursor-pointer" onclick="openQrisPreview('${data.url}', '${tokoNama}')">
                  <div class="absolute inset-0 bg-primary/5 rounded-2xl scale-110 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                  <img src="${data.url}"
                       alt="QRIS ${tokoNama}"
                       class="w-56 h-56 object-contain rounded-2xl border border-outline-variant/30 shadow-sm bg-white p-3 relative z-10 transition-transform duration-200 group-hover:scale-[1.03]"
                       title="Klik untuk memperbesar QRIS">
                  <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-20">
                     <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-full flex items-center gap-1 font-semibold backdrop-blur-sm">
                       <span class="material-symbols-outlined text-[16px]">zoom_in</span> Perbesar
                     </span>
                  </div>
                </div>
                <div class="text-center">
                  <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest leading-relaxed">
                    Scan QRIS ini untuk membayar ke <br><span class="text-primary">${tokoNama}</span> (Klik gambar untuk memperbesar)
                  </p>
                </div>
                <div class="flex items-center gap-2 text-[10px] text-green-700 bg-green-50 border border-green-100 px-4 py-2 rounded-full font-bold">
                  <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1">verified</span>
                  QRIS TERVERIFIKASI
                </div>
              </div>
            `;
          } else {
            content.innerHTML = `
              <div class="w-full bg-amber-50 border border-amber-200 rounded-2xl p-6 flex flex-col items-center gap-3 text-center">
                <span class="material-symbols-outlined text-amber-500 text-5xl">qr_code_scanner</span>
                <div>
                  <p class="text-sm font-bold text-amber-900">QRIS Toko Belum Tersedia</p>
                  <p class="text-[11px] text-amber-700 mt-1 leading-relaxed">
                    Toko <strong>${tokoNama}</strong> belum mengunggah QRIS. Silakan hubungi toko melalui fitur <a href="{{ route('Pesan') }}" class="text-primary font-bold hover:underline">Chat</a> untuk metode pembayaran lainnya.
                  </p>
                </div>
              </div>
            `;
          }
        })
        .catch(() => {
          if(loading) loading.classList.add('hidden');
          if(content) content.classList.remove('hidden');
          if(content) content.innerHTML = `
            <div class="w-full bg-red-50 border border-red-200 rounded-2xl p-6 flex flex-col items-center gap-2 text-center">
              <span class="material-symbols-outlined text-red-500 text-4xl">error</span>
              <p class="text-sm font-bold text-red-900">Gagal Memuat QRIS</p>
              <p class="text-xs text-red-700">Periksa koneksi internet Anda dan muat ulang halaman.</p>
            </div>
          `;
        });
    }

    /* -- Cart Management ----------------------------------- */
    function removeItem(key) {
      if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) return;
      const cartRaw = sessionStorage.getItem('pasirku_cart');
      if (!cartRaw) return;
      let cartItems = JSON.parse(cartRaw);
      cartItems = cartItems.filter(item => item.key !== key);
      sessionStorage.setItem('pasirku_cart', JSON.stringify(cartItems));
      renderCheckout();
    }

    function updateStoreMarker(store) {
      if (!window.checkoutMap) return;
      const lat = parseFloat(store.latitude);
      const lng = parseFloat(store.longitude);
      if (!isNaN(lat) && !isNaN(lng)) {
        window.checkoutMap.setView([lat, lng], 13);
        if (window.storeMarker) window.checkoutMap.removeLayer(window.storeMarker);
        const redIcon = new L.Icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
          iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
        });
        window.storeMarker = L.marker([lat, lng], { icon: redIcon }).addTo(window.checkoutMap);
        window.storeMarker.bindPopup(`<strong class="text-primary font-headline">${store.nama}</strong><br><span class="text-xs text-on-surface-variant">Material dimuat dari sini</span>`).openPopup();
        if (window.routeLine && window.deliveryMarker) {
          const dPos = window.deliveryMarker.getLatLng();
          window.routeLine.setLatLngs([[lat, lng], [dPos.lat, dPos.lng]]);
        }
      }
    }

    function renderCheckout() {
      const cartRaw = sessionStorage.getItem('pasirku_cart');
      const cartItemsList = document.getElementById('cart-items-list');
      const paymentLines  = document.getElementById('payment-summary-lines');
      const ongkirSection = document.getElementById('ongkir-section');
      const grandTotalEl  = document.getElementById('grand-total');
      const emptyNotice   = document.getElementById('cart-empty-notice');
      const storeNameText = document.getElementById('store-name-text');

      if (!cartRaw || JSON.parse(cartRaw).length === 0) {
        if(cartItemsList) cartItemsList.innerHTML = '';
        if(emptyNotice) emptyNotice.classList.remove('hidden');
        if(paymentLines) paymentLines.innerHTML = '<p class="text-surface/50 text-xs text-center font-bold">TIDAK ADA ITEM</p>';
        if(ongkirSection) ongkirSection.innerHTML = '';
        if(grandTotalEl) grandTotalEl.textContent = formatRupiah(0);
        const loading = document.getElementById('qris_loading');
        if(loading) loading.classList.add('hidden');
        return;
      }

      const cartItems = JSON.parse(cartRaw);
      const groupedItems = cartItems.reduce((acc, item) => {
        if (!acc[item.tokoId]) {
          acc[item.tokoId] = {
            id: item.tokoId, nama: item.tokoNama, lokasi: item.tokoLokasi,
            ongkirPickUp: item.ongkirPickUp, ongkirTruck: item.ongkirTruck,
            latitude: item.latitude || null, longitude: item.longitude || null,
            items: []
          };
        }
        acc[item.tokoId].items.push(item);
        return acc;
      }, {});

      const storeIds = Object.keys(groupedItems);
      let selectedStoreId = sessionStorage.getItem('pasirku_selected_store');
      if (!selectedStoreId || !groupedItems[selectedStoreId]) {
        selectedStoreId = storeIds[0];
        sessionStorage.setItem('pasirku_selected_store', selectedStoreId);
      }

      const selectedStore = groupedItems[selectedStoreId];
      if(storeNameText) storeNameText.textContent = selectedStore.nama + ' | ' + selectedStore.lokasi;

      cartItemsList.innerHTML = '';
      storeIds.forEach(tId => {
        const store = groupedItems[tId];
        const isSelected = tId === selectedStoreId;
        const storeHeader = document.createElement('div');
        storeHeader.className = `flex items-center justify-between p-4 rounded-xl mb-2 transition-all cursor-pointer border ${isSelected ? 'bg-primary/10 border-primary' : 'bg-surface-container-low border-outline-variant/30 hover:border-primary/50'}`;
        storeHeader.onclick = () => { sessionStorage.setItem('pasirku_selected_store', tId); renderCheckout(); };
        storeHeader.innerHTML = `
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 ${isSelected ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant'} rounded-lg flex items-center justify-center">
              <span class="material-symbols-outlined text-[18px]">${isSelected ? 'check_circle' : 'storefront'}</span>
            </div>
            <div>
              <p class="font-headline font-bold text-sm text-on-surface">${store.nama}</p>
              <p class="text-[10px] text-on-surface-variant font-medium">${store.lokasi}</p>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full ${isSelected ? 'bg-primary/20 text-primary' : 'bg-surface-container-highest text-on-surface-variant'}">${store.items.length} Item</span>
            <span class="material-symbols-outlined text-[18px] text-outline transition-transform ${isSelected ? 'rotate-0' : '-rotate-90'}">expand_more</span>
          </div>`;
        cartItemsList.appendChild(storeHeader);

        if (isSelected) {
          const itemsContainer = document.createElement('div');
          itemsContainer.className = 'space-y-3 mb-6 ml-4 pl-4 border-l-2 border-primary/20 animate-fadeUp';
          store.items.forEach(item => {
            const lineTotal = item.harga * item.qty;
            const typeLabel = item.type === 'pickup'
              ? '<span class="inline-flex items-center gap-1.5 text-blue-700 font-bold text-[10px] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100 uppercase tracking-wider"><span class="material-symbols-outlined text-[14px]">directions_car</span>Pick Up</span>'
              : '<span class="inline-flex items-center gap-1.5 text-amber-700 font-bold text-[10px] bg-amber-50 px-2.5 py-1 rounded-full border border-amber-100 uppercase tracking-wider"><span class="material-symbols-outlined text-[14px]">local_shipping</span>Truk</span>';
            const row = document.createElement('div');
            row.className = 'flex flex-col gap-3 bg-surface-container-lowest rounded-2xl px-5 py-4 shadow-sm border border-outline-variant/30 hover:border-primary/20 transition-colors group/item';
            row.innerHTML = `
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                  <div class="w-10 h-10 bg-surface-container-low rounded-xl flex items-center justify-center flex-shrink-0 border border-outline-variant/20">
                    <span class="material-symbols-outlined text-xl text-primary" style="font-variation-settings:'FILL' 1">landscape</span>
                  </div>
                  <div class="flex flex-col gap-0.5">
                    <p class="font-headline font-bold text-xs text-on-surface leading-tight">${item.namaPasir}</p>
                    <div class="flex items-center gap-2 mt-1">
                      ${typeLabel} <span class="text-[10px] text-on-surface-variant font-bold px-2 py-0.5 bg-surface-container rounded-lg">x ${item.qty} UNIT</span>
                    </div>
                  </div>
                </div>
                <div class="flex items-center gap-4">
                  <div class="text-right flex flex-col items-end">
                    <p class="font-headline font-black text-sm text-on-surface leading-none">${formatRupiah(lineTotal)}</p>
                    <p class="text-[9px] text-on-surface-variant font-medium mt-1 opacity-70">${formatRupiah(item.harga)} / unit</p>
                  </div>
                  <button onclick="removeItem('${item.key}')" class="p-2 text-outline hover:text-error hover:bg-error/10 rounded-xl transition-all opacity-0 group-hover/item:opacity-100 focus:opacity-100" title="Hapus Item"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                </div>
              </div>
              <div class="flex flex-wrap items-center justify-between border-t border-outline-variant/10 pt-3 mt-1 gap-2">
                <div id="stock-badge-${item.key}" class="flex items-center">
                  <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-outline bg-surface-container/30 px-2.5 py-1 rounded-full border border-outline-variant/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-outline/30 animate-pulse"></span>MEMERIKSA STOK...
                  </span>
                </div>
                <div id="stock-warning-${item.key}"></div>
              </div>`;
            itemsContainer.appendChild(row);
          });
          cartItemsList.appendChild(itemsContainer);
        }
      });

      // Stock check for selected store
      const productIds = [...new Set(selectedStore.items.map(item => parseInt(item.key.split('_')[0], 10)))];
      if (productIds.length > 0) {
        fetch('/api/products/check-stock', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
          body: JSON.stringify({ ids: productIds })
        })
        .then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            const stocks = response.data;
            let hasInsufficientStock = false;
            selectedStore.items.forEach(item => {
              const productId = parseInt(item.key.split('_')[0], 10);
              const prodStock = stocks.find(s => s.ID_Isi_Toko === productId);
              const badgeContainer = document.getElementById(`stock-badge-${item.key}`);
              const warningContainer = document.getElementById(`stock-warning-${item.key}`);
              if (prodStock && badgeContainer && warningContainer) {
                const availableStock = item.type === 'pickup' ? prodStock.Stock_PickUp : prodStock.Stock_Truck;
                let badgeHtml = availableStock === 0 
                  ? `<span class="inline-flex items-center gap-1.5 text-[9px] font-black text-error bg-error/5 border border-error/20 px-2.5 py-1 rounded-full uppercase tracking-wider"><span class="w-2 h-2 rounded-full bg-error"></span>Stok Habis</span>`
                  : availableStock <= 10 
                  ? `<span class="inline-flex items-center gap-1.5 text-[9px] font-black text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full uppercase tracking-wider"><span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>Stok Menipis (${availableStock})</span>`
                  : `<span class="inline-flex items-center gap-1.5 text-[9px] font-black text-green-700 bg-green-50 border border-green-200 px-2.5 py-1 rounded-full uppercase tracking-wider"><span class="w-2 h-2 rounded-full bg-green-500"></span>Stok Tersedia (${availableStock})</span>`;
                badgeContainer.innerHTML = badgeHtml;
                if (item.qty > availableStock) { hasInsufficientStock = true; warningContainer.innerHTML = `<p class="text-error text-[10px] font-bold flex items-center gap-1 bg-error/5 px-2 py-0.5 rounded-lg border border-error/10"><span class="material-symbols-outlined text-[14px]">warning</span>Melebihi stok!</p>`; } 
                else { warningContainer.innerHTML = ''; }
              }
            });
            const btnKonfirmasi = document.getElementById('btn-konfirmasi');
            if (hasInsufficientStock) {
              if (btnKonfirmasi) { btnKonfirmasi.disabled = true; btnKonfirmasi.classList.add('opacity-50', 'cursor-not-allowed'); }
              if (!document.getElementById('stock-error-alert')) {
                const alert = document.createElement('div'); alert.id = 'stock-error-alert'; alert.className = 'mt-4 p-4 bg-error/5 border border-error/20 text-error rounded-2xl text-[11px] font-bold text-center animate-fadeUp'; alert.innerHTML = `Stok tidak mencukupi untuk item terpilih.`;
                btnKonfirmasi.parentNode.insertBefore(alert, btnKonfirmasi);
              }
            } else {
              if (btnKonfirmasi) { btnKonfirmasi.disabled = false; btnKonfirmasi.classList.remove('opacity-50', 'cursor-not-allowed'); }
              const alert = document.getElementById('stock-error-alert'); if (alert) alert.remove();
            }
          }
        });
      }

      let subtotalPickUp = 0, subtotalTruck = 0, qtyPickUp = 0, qtyTruck = 0, subTotal = 0;
      selectedStore.items.forEach(item => {
        const lineTotal = item.harga * item.qty; subTotal += lineTotal;
        if (item.type === 'pickup') { subtotalPickUp += lineTotal; qtyPickUp += item.qty; } else { subtotalTruck += lineTotal; qtyTruck += item.qty; }
      });

      const ongPick = qtyPickUp > 0 ? (selectedStore.ongkirPickUp || 0) : 0;
      const ongTruck = qtyTruck > 0 ? (selectedStore.ongkirTruck || 0) : 0;
      const totalOngkir = ongPick + ongTruck;
      const grandTotal = subTotal + totalOngkir;

      paymentLines.innerHTML = '';
      if (qtyPickUp > 0) { const r = document.createElement('div'); r.className = 'flex justify-between text-xs font-bold items-center'; r.innerHTML = `<span class="flex items-center gap-2 text-primary-fixed-dim/80"><span class="material-symbols-outlined text-[16px]">directions_car</span>Pick Up (${qtyPickUp} unit)</span><span class="text-surface">${formatRupiah(subtotalPickUp)}</span>`; paymentLines.appendChild(r); }
      if (qtyTruck > 0) { const r = document.createElement('div'); r.className = 'flex justify-between text-xs font-bold items-center'; r.innerHTML = `<span class="flex items-center gap-2 text-primary-fixed-dim/80"><span class="material-symbols-outlined text-[16px]">local_shipping</span>Truk (${qtyTruck} unit)</span><span class="text-surface">${formatRupiah(subtotalTruck)}</span>`; paymentLines.appendChild(r); }
      const subRow = document.createElement('div'); subRow.className = 'flex justify-between text-[11px] font-black text-primary-fixed uppercase tracking-widest pt-4 mt-2 border-t border-surface-variant/5'; subRow.innerHTML = `<span>Subtotal Produk</span><span>${formatRupiah(subTotal)}</span>`; paymentLines.appendChild(subRow);

      ongkirSection.innerHTML = '';
      if (ongPick > 0) { const r = document.createElement('div'); r.className = 'flex justify-between text-xs font-bold items-center'; r.innerHTML = `<span class="flex items-center gap-2 text-primary-fixed-dim/70 font-medium"><span class="material-symbols-outlined text-[16px]">directions_car</span>Ongkir Pick Up</span><span class="text-surface-variant">${formatRupiah(ongPick)}</span>`; ongkirSection.appendChild(r); }
      if (ongTruck > 0) { const r = document.createElement('div'); r.className = 'flex justify-between text-xs font-bold items-center'; r.innerHTML = `<span class="flex items-center gap-2 text-primary-fixed-dim/70 font-medium"><span class="material-symbols-outlined text-[16px]">local_shipping</span>Ongkir Truk</span><span class="text-surface-variant">${formatRupiah(ongTruck)}</span>`; ongkirSection.appendChild(r); }
      if (totalOngkir === 0) { const r = document.createElement('div'); r.className = 'flex justify-between text-[10px] font-bold items-center text-primary-fixed-dim/50 uppercase tracking-widest'; r.innerHTML = `<span>Ongkos Kirim</span><span>- GRATIS -</span>`; ongkirSection.appendChild(r); }

      grandTotalEl.textContent = formatRupiah(grandTotal);
      document.getElementById('h-id-toko').value = selectedStore.id;
      document.getElementById('h-cart-items').value = JSON.stringify(selectedStore.items);
      document.getElementById('h-nama-produk').value = selectedStore.items.map(item => item.namaPasir + ' (' + item.qty + ' ' + (item.type === 'pickup' ? 'Pick Up' : 'Truk') + ')').join(', ');
      const tps = []; if (qtyPickUp > 0) tps.push('pickup'); if (qtyTruck > 0) tps.push('truck');
      document.getElementById('h-tipe-pengiriman').value = tps.join(',');
      document.getElementById('h-total-harga').value = grandTotal;
      document.getElementById('h-unit').value = qtyPickUp + qtyTruck;

      loadQris(selectedStore.id, selectedStore.nama, grandTotal);
      updateStoreMarker(selectedStore);
    }

    /* ── Initial Load ─────────────────────────────── */
    document.addEventListener('DOMContentLoaded', () => {
      // Setup Map
      const checkoutMap = L.map('checkout-map', { scrollWheelZoom: false }).setView([-6.2, 106.8], 13);
      window.checkoutMap = checkoutMap;
      L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'] }).addTo(checkoutMap);

      const deliveryMarker = L.marker([-6.197, 106.827], { draggable: true }).addTo(checkoutMap);
      deliveryMarker.bindPopup(`<strong class="text-secondary font-headline">Titik Bongkar Pasir</strong>`).openPopup();
      window.deliveryMarker = deliveryMarker;
      window.deliveryLat = -6.197; window.deliveryLng = 106.827;

      const routeLine = L.polyline([], { color: '#944a00', dashArray: '8, 12', weight: 3, opacity: 0.6 }).addTo(checkoutMap);
      window.routeLine = routeLine;

      deliveryMarker.on('dragend', function (e) {
        const pos = e.target.getLatLng();
        window.deliveryLat = pos.lat.toFixed(8); window.deliveryLng = pos.lng.toFixed(8);
        if (window.storeMarker) {
          const sPos = window.storeMarker.getLatLng();
          routeLine.setLatLngs([[sPos.lat, sPos.lng], [pos.lat, pos.lng]]);
        }
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${pos.lat}&lon=${pos.lng}`)
          .then(res => res.json()).then(data => { if(data && data.display_name) document.getElementById('lokasi-pengantaran').value = data.display_name.split(',').slice(0, 4).join(',').trim(); });
      });

      renderCheckout();
      hitungEstimasi();

      const btnSearch = document.getElementById('btn-search-delivery');
      if(btnSearch) {
        btnSearch.addEventListener('click', () => {
          const query = document.getElementById('lokasi-pengantaran').value.trim();
          if (!query) return alert('Silakan ketik lokasi!');
          btnSearch.disabled = true;
          fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
            .then(res => res.json()).then(data => {
              btnSearch.disabled = false;
              if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat), lon = parseFloat(data[0].lon);
                checkoutMap.setView([lat, lon], 14);
                deliveryMarker.setLatLng([lat, lon]);
                window.deliveryLat = lat; window.deliveryLng = lon;
                if (window.storeMarker) routeLine.setLatLngs([[window.storeMarker.getLatLng().lat, window.storeMarker.getLatLng().lng], [lat, lon]]);
              }
            });
        });
      }

      const inputBukti = document.getElementById('input-bukti');
      if(inputBukti) {
        inputBukti.addEventListener('change', function () {
          const file = this.files[0]; if (!file) return;
          
          if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file bukti pembayaran melebihi batas maksimal 5 MB.');
            this.value = '';
            return;
          }

          const reader = new FileReader();
          reader.onload = (e) => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('preview-filename').textContent = file.name;
            document.getElementById('preview-filesize').textContent = formatBytes(file.size);
            document.getElementById('preview-bukti').classList.remove('hidden');
            document.getElementById('btn-upload-bukti').classList.add('hidden');
          };
          reader.readAsDataURL(file);
        });
      }
    });

    function resetUpload() {
      document.getElementById('input-bukti').value = '';
      document.getElementById('preview-bukti').classList.add('hidden');
      document.getElementById('btn-upload-bukti').classList.remove('hidden');
    }

    function hitungEstimasi() {
      const input = document.getElementById('jam-mulai');
      const label = document.getElementById('estimasi-label');
      if (!input || !input.value || !label) return;
      const [h, m] = input.value.split(':').map(Number);
      const total = h * 60 + m + 240;
      const h2 = Math.floor(total / 60) % 24, m2 = total % 60;
      const pad = (n) => String(n).padStart(2, '0');
      label.textContent = `${pad(h)}:${pad(m)} – ${pad(h2)}:${pad(m2)}`;
    }

    const formKonfirmasi = document.getElementById('form-konfirmasi');
    if(formKonfirmasi) {
      formKonfirmasi.addEventListener('submit', function (e) {
        const lok = (document.getElementById('lokasi-pengantaran')?.value ?? '').trim();
        const det = (document.getElementById('detail-lokasi')?.value ?? '').trim();
        document.getElementById('h-lokasi').value = lok + (window.deliveryLat ? ` | Koordinat: ${window.deliveryLat}, ${window.deliveryLng}` : '');
        document.getElementById('h-detail-lokasi').value = det;
        document.getElementById('h-tanggal').value = document.getElementById('tanggal-pengiriman').value;
        document.getElementById('h-jam-tiba').value = document.getElementById('estimasi-label').textContent;

        if (!document.getElementById('input-bukti').files[0]) {
          e.preventDefault(); return alert('Harap upload bukti pembayaran!');
        }
        document.getElementById('loading-overlay').classList.remove('hidden');
        document.getElementById('loading-overlay').classList.add('flex');
        const btn = document.getElementById('btn-konfirmasi');
        btn.disabled = true; btn.innerHTML = '<span class="material-symbols-outlined animate-spin">autorenew</span> Memproses...';
      });
    }

    /* ── QRIS Preview Modal Functions ───────────────────────── */
    window.openQrisPreview = function(url, storeName) {
      const modal = document.getElementById('qris-preview-modal');
      const img = document.getElementById('qris-preview-img');
      const title = document.getElementById('qris-preview-toko-name');
      if (modal && img && title) {
        img.src = url;
        title.textContent = `QRIS ${storeName}`;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }
    }

    window.closeQrisPreview = function() {
      const modal = document.getElementById('qris-preview-modal');
      if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }
    }
  </script>

  <!-- Loading Overlay -->
  <div id="loading-overlay" class="fixed inset-0 bg-on-surface/80 backdrop-blur-md hidden flex flex-col items-center justify-center z-[99999]">
    <div class="bg-surface-container-lowest p-10 rounded-[40px] shadow-2xl flex flex-col items-center max-w-sm text-center">
      <div class="relative w-24 h-24 mb-8">
        <div class="absolute inset-0 rounded-full border-[6px] border-surface-container-highest"></div>
        <div class="absolute inset-0 rounded-full border-[6px] border-t-primary border-r-primary animate-spin"></div>
      </div>
      <h3 class="font-headline font-black text-2xl text-on-surface mb-3">Memproses Pesanan</h3>
      <p class="text-on-surface-variant text-sm px-4 font-medium">Mohon tunggu sebentar...</p>
    </div>
  </div>

  <!-- QRIS Preview Modal -->
  <div id="qris-preview-modal" class="fixed inset-0 bg-on-surface/80 backdrop-blur-md hidden flex flex-col items-center justify-center z-[99999]" onclick="closeQrisPreview()">
    <div class="bg-surface-container-lowest p-6 rounded-[32px] shadow-2xl flex flex-col items-center max-w-sm w-[90%] text-center relative animate-fadeUp" onclick="event.stopPropagation()">
      <button onclick="closeQrisPreview()" class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface transition-colors p-1.5 hover:bg-surface-container rounded-full">
        <span class="material-symbols-outlined text-[24px]">close</span>
      </button>
      <div class="flex items-center gap-2 mb-4 self-start">
        <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings:'FILL' 1">storefront</span>
        <h4 id="qris-preview-toko-name" class="font-headline font-bold text-on-surface text-sm">Nama Toko</h4>
      </div>
      <div class="w-full flex justify-center py-4 bg-white rounded-2xl border border-outline-variant/30 shadow-inner mb-4">
        <img id="qris-preview-img" src="" alt="QRIS Preview" class="w-64 h-64 object-contain">
      </div>
      <p class="text-xs text-on-surface-variant font-medium leading-relaxed mb-3">
        Arahkan kamera aplikasi pembayaran/bank Anda ke kode QR ini untuk melakukan pembayaran.
      </p>
      <div class="flex items-center gap-1.5 text-[10px] text-green-700 bg-green-50 border border-green-100 px-4 py-1.5 rounded-full font-bold">
        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1">verified</span>
        QRIS TERVERIFIKASI
      </div>
    </div>
  </div>
  @endpush

</x-layout-user>
