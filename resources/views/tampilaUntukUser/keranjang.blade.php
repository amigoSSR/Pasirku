<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Checkout | Pasir Ku</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Public+Sans:wght@300;400;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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
      background-color: #f8f9ff;
      color: #0b1c30;
    }
    h1, h2, h3, h4 {
      font-family: 'Manrope', sans-serif;
    }
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
      background-color: #dce9ff;
      border: none;
      border-bottom: 2px solid transparent;
      transition: border-bottom 0.2s ease;
    }
    .input-industrial:focus {
      border-bottom: 2px solid #00488d;
      box-shadow: none;
      outline: none;
    }
    .glass-panel {
      background: rgba(248, 249, 255, 0.8);
      backdrop-filter: blur(20px);
    }
    /* Shimmer for empty state */
    @keyframes shimmer {
      0% { background-position: -400px 0; }
      100% { background-position: 400px 0; }
    }
    .shimmer {
      background: linear-gradient(90deg, #e5eeff 25%, #dce9ff 50%, #e5eeff 75%);
      background-size: 800px 100%;
      animation: shimmer 1.5s infinite;
    }
  </style>
</head>

<body class="bg-surface text-on-surface">

  @include('tampilaUntukUser.topbar')

  <main class="max-w-7xl mx-auto px-6 pt-24 pb-12">

    <!-- Back link & header -->
    <div class="mb-4">
      <button onclick="history.back()" class="flex items-center gap-1.5 text-sm text-on-surface-variant hover:text-primary font-semibold transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Toko
      </button>
    </div>
    <div class="mb-12">
      <p class="text-secondary font-bold uppercase tracking-widest text-xs mb-2">Finalisasi Pesanan</p>
      <h1 class="text-5xl font-extrabold tracking-tight text-on-surface">Checkout</h1>
      <p id="checkout-store-name" class="mt-2 text-on-surface-variant font-medium"></p>
    </div>

    <div class="strata-grid">

      <!-- Left Column: Forms -->
      <div class="space-y-8">

        <!-- Section: Item Summary (from cart) -->
        <section class="bg-surface-container-low p-8 rounded-xl relative overflow-hidden" id="cart-items-section">
          <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary">shopping_basket</span>
            <h2 class="text-2xl font-bold">Item yang Dipesan</h2>
          </div>
          <div id="cart-items-list" class="space-y-3">
            <!-- Populated by JS -->
            <div class="shimmer h-16 rounded-xl"></div>
            <div class="shimmer h-16 rounded-xl opacity-60"></div>
          </div>
          <!-- Empty cart notice -->
          <div id="cart-empty-notice" class="hidden text-center py-8 text-on-surface-variant">
            <span class="material-symbols-outlined text-5xl mb-3 block opacity-40">remove_shopping_cart</span>
            <p class="font-semibold">Keranjang kosong.<br>Silakan pilih produk terlebih dahulu.</p>
            <button onclick="history.back()" class="mt-4 bg-primary text-white px-6 py-2 rounded-full text-sm font-bold hover:bg-primary-container transition-colors">
              Pilih Produk
            </button>
          </div>
        </section>

        <!-- Section: Shipping Address -->
        <section class="bg-surface-container-low p-8 rounded-xl relative overflow-hidden">
          <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-primary">local_shipping</span>
            <h2 class="text-2xl font-bold">Alamat Pengiriman</h2>
          </div>
          <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-2">
              <label for="lokasi-pengantaran" class="text-xs font-bold text-secondary uppercase tracking-wider">Lokasi Pengantaran</label>
              <input id="lokasi-pengantaran" class="input-industrial px-4 py-3 rounded-lg w-full"
                     placeholder="Contoh: Jl. Merdeka No. 10, Jakarta Pusat" type="text" />
              <p class="text-[11px] text-on-surface-variant">Masukkan alamat lengkap lokasi pengiriman pasir.</p>
            </div>
            <div class="flex flex-col gap-2">
              <label for="detail-lokasi" class="text-xs font-bold text-secondary uppercase tracking-wider">Detail Tambahan Lokasi Pengantaran</label>
              <textarea id="detail-lokasi" class="input-industrial px-4 py-3 rounded-lg w-full resize-none"
                        placeholder="Contoh: Masuk gang kedua, dekat pos satpam, patokan warung Bu Sari..." rows="3"></textarea>
              <p class="text-[11px] text-on-surface-variant">Opsional — bantu pengemudi menemukan lokasi dengan lebih mudah.</p>
            </div>
          </div>
        </section>

        <!-- Section: Delivery Schedule -->
        <section class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border-l-8 border-secondary">
          <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-secondary">calendar_today</span>
            <h2 class="text-2xl font-bold">Jadwal Pengiriman Pasir</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Pilih Tanggal --}}
            <div class="bg-surface-container-low p-6 rounded-lg">
              <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-4">Pilih Tanggal</p>
              <input id="tanggal-pengiriman" type="date" class="input-industrial px-4 py-3 rounded-lg w-full font-semibold"
                     min="{{ now()->addDay()->format('Y-m-d') }}"
                     value="{{ now()->addDay()->format('Y-m-d') }}" />
              <p class="text-[11px] text-on-surface-variant mt-2">Pengiriman minimal H+1 dari hari ini.</p>
            </div>

            {{-- Estimasi Waktu Tiba --}}
            <div class="bg-surface-container-low p-6 rounded-lg">
              <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-4">Estimasi Waktu Tiba</p>
              <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3">
                  <input id="jam-mulai" type="time" value="08:00"
                         class="input-industrial px-4 py-3 rounded-lg flex-1 font-bold text-lg text-center"
                         oninput="hitungEstimasi()" />
                  <span class="text-on-surface-variant font-semibold text-sm">WIB</span>
                </div>
                {{-- Display estimasi hasil kalkulasi --}}
                <div id="estimasi-box" class="bg-white rounded-lg px-4 py-3 flex items-center gap-3">
                  <span class="material-symbols-outlined text-secondary text-[20px]">schedule</span>
                  <div>
                    <p id="estimasi-label" class="font-black text-on-surface text-sm">08:00 – 12:00</p>
                    <p class="text-[10px] text-on-surface-variant italic">*Estimasi rentang waktu kedatangan (±4 jam)</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>

      </div>

      <!-- Right Column: Payment & Summary -->
      <div class="space-y-6">
        <div class="sticky top-24">

          <!-- Order Summary Card -->
          <div class="bg-on-surface text-surface rounded-xl p-8 mb-6 relative">
            <div class="absolute top-0 right-0 p-4 opacity-10">
              <span class="material-symbols-outlined text-9xl" style="font-variation-settings: 'wght' 700">receipt_long</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] mb-6 text-surface-dim">Ringkasan Pembayaran</h3>
            <div id="payment-summary-lines" class="space-y-4 mb-8">
              <!-- Populated by JS -->
            </div>

            <!-- Ongkir Section -->
            <div class="border-t border-white/10 pt-4 mb-4 space-y-3" id="ongkir-section">
              <!-- Populated by JS -->
            </div>

            <div class="border-t border-white/10 pt-6 mb-2">
              <div class="flex justify-between items-end">
                <span class="text-sm font-bold uppercase">Total Tagihan</span>
                <span id="grand-total" class="text-3xl font-black text-primary-fixed">Rp 0</span>
              </div>
            </div>
          </div>

          <!-- Payment Section -->
          <div class="bg-white p-8 rounded-xl shadow-xl">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">qr_code_2</span>
              Pembayaran QRIS
            </h3>

              {{-- QRIS image + store info --}}
              <div id="qris_wrapper" class="flex flex-col items-center mb-6">
                {{-- Loading state --}}
                <div id="qris_loading" class="flex flex-col items-center justify-center py-8 gap-3 w-full">
                  <div class="w-10 h-10 rounded-full border-4 border-primary/20 border-t-primary animate-spin"></div>
                  <p class="text-xs text-on-surface-variant font-medium">Memuat QRIS Toko...</p>
                </div>
                {{-- Content injected by JS --}}
                <div id="qris_content" class="hidden w-full flex flex-col items-center gap-3"></div>
              </div>

            <!-- FORM KONFIRMASI PESANAN -->
            <form id="form-konfirmasi" method="POST"
                  action="{{ route('pesanan.store') }}"
                  enctype="multipart/form-data"
                  class="space-y-4">
              @csrf

              {{-- Hidden inputs: diisi oleh JS sebelum submit --}}
              <input type="hidden" name="id_toko"            id="h-id-toko">
              <input type="hidden" name="lokasi_pengantaran" id="h-lokasi">
              <input type="hidden" name="detail_lokasi"      id="h-detail-lokasi">
              <input type="hidden" name="unit"               id="h-unit">
              <input type="hidden" name="tanggal_pengiriman" id="h-tanggal">
              <input type="hidden" name="jam_tiba"           id="h-jam-tiba">

              {{-- Input file tersembunyi --}}
              <input type="file" id="input-bukti" name="bukti_pembayaran"
                     accept="image/*" class="hidden">

              {{-- Tombol trigger file manager --}}
              <button type="button" id="btn-upload-bukti"
                      onclick="document.getElementById('input-bukti').click()"
                      class="w-full flex items-center justify-center gap-2 bg-surface-container-high py-4 rounded-lg font-bold hover:bg-surface-container-highest transition-colors group">
                <span class="material-symbols-outlined group-hover:scale-110 transition-transform">cloud_upload</span>
                <span id="upload-label">Upload Bukti Pembayaran</span>
              </button>

              {{-- Preview bukti pembayaran --}}
              <div id="preview-bukti" class="hidden rounded-xl overflow-hidden border-2 border-primary/30 bg-surface-container-low p-3">
                <div class="flex items-center gap-3">
                  <div class="relative flex-shrink-0">
                    <img id="preview-img" src="" alt="Preview Bukti"
                         class="w-20 h-20 object-cover rounded-lg shadow">
                    <div class="absolute -top-1 -right-1 bg-green-500 rounded-full p-0.5">
                      <span class="material-symbols-outlined text-white text-[14px]">check</span>
                    </div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-on-surface truncate" id="preview-filename"></p>
                    <p class="text-[10px] text-on-surface-variant" id="preview-filesize"></p>
                    <p class="text-[10px] text-green-600 font-bold mt-1">OK Siap diunggah | Akan dikonversi ke PNG</p>
                  </div>
                  <button type="button" id="btn-ganti-file"
                          onclick="resetUpload()"
                          class="flex-shrink-0 text-on-surface-variant hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                  </button>
                </div>
              </div>

              {{-- Error bukti jika ada dari server --}}
              @error('bukti_pembayaran')
                <p class="text-xs text-red-600 font-semibold">{{ $message }}</p>
              @enderror

              {{-- Tombol konfirmasi --}}
              <button type="submit" id="btn-konfirmasi"
                      class="w-full bg-gradient-to-br from-primary to-primary-container text-white py-5 rounded-lg font-black text-lg shadow-lg hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed disabled:scale-100">
                <span id="konfirmasi-icon" class="material-symbols-outlined">task_alt</span>
                <span id="konfirmasi-label">KONFIRMASI PESANAN</span>
              </button>

              <p class="text-[10px] text-center text-on-surface-variant italic">
                *Dengan mengklik Konfirmasi, Anda menyetujui syarat &amp; ketentuan pengiriman.
              </p>
            </form>
          </div>

        </div>
      </div>

    </div>
  </main>

  <footer class="mt-20 bg-surface-container-low py-12 px-6">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
      <div class="flex flex-col">
        <span class="text-2xl font-black text-blue-900 tracking-tighter">Pasir Ku</span>
        <p class="text-sm text-on-surface-variant mt-1">Industrial Raw Material Hub</p>
      </div>
      <div class="flex gap-8">
        <a class="text-xs font-bold uppercase text-on-surface-variant hover:text-primary" href="#">Bantuan</a>
        <a class="text-xs font-bold uppercase text-on-surface-variant hover:text-primary" href="#">Kebijakan Pengembalian</a>
        <a class="text-xs font-bold uppercase text-on-surface-variant hover:text-primary" href="#">Kontak Support</a>
      </div>
      <div class="text-[10px] font-medium text-slate-400">
        ﾂｩ 2024 Pasir Ku. All rights reserved.
      </div>
    </div>
  </footer>

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

      fetch(`/api/store/${tokoId}/qris`)
        .then(res => res.json())
        .then(data => {
          if(loading) loading.classList.add('hidden');
          if(content) content.classList.remove('hidden');

          if (data.status === 'success') {
            content.innerHTML = `
              <div class="w-full bg-surface-container-low rounded-2xl border border-outline-variant/20 p-4 flex flex-col items-center gap-3">
                <div class="flex items-center justify-between w-full">
                  <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">storefront</span>
                    <span class="text-xs font-bold text-on-surface">${tokoNama}</span>
                  </div>
                  <span class="text-xs font-black text-primary">${formatRupiah(grandTotal)}</span>
                </div>
                <div class="w-full border-t border-outline-variant/20 pt-3 flex justify-center">
                  <img src="${data.url}"
                       alt="QRIS ${tokoNama}"
                       class="w-52 h-52 object-contain rounded-xl border border-outline-variant/30 shadow-sm bg-white p-2">
                </div>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider text-center">
                  Scan QRIS ini untuk membayar ke <span class="text-primary">${tokoNama}</span>
                </p>
                <div class="flex items-center gap-2 text-[10px] text-green-700 bg-green-50 border border-green-100 px-3 py-1.5 rounded-full">
                  <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">verified</span>
                  QRIS Terverifikasi
                </div>
              </div>
            `;
          } else {
            content.innerHTML = `
              <div class="w-full bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col items-center gap-3 text-center">
                <span class="material-symbols-outlined text-amber-500 text-4xl">qr_code_scanner</span>
                <div>
                  <p class="text-sm font-bold text-amber-800">QRIS Toko Belum Tersedia</p>
                  <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                    Toko <strong>${tokoNama}</strong> belum mengunggah QRIS. Silakan hubungi toko melalui fitur Chat untuk informasi pembayaran.
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
            <div class="w-full bg-red-50 border border-red-200 rounded-2xl p-5 flex flex-col items-center gap-2 text-center">
              <span class="material-symbols-outlined text-red-500 text-3xl">error</span>
              <p class="text-sm font-bold text-red-700">Gagal Memuat QRIS</p>
              <p class="text-xs text-red-600">Periksa koneksi internet Anda dan muat ulang halaman.</p>
            </div>
          `;
        });
    }

    /* -- Checkout Render ----------------------------------- */
    function renderCheckout() {
      const cartRaw  = sessionStorage.getItem('pasirku_cart');
      const tokoRaw  = sessionStorage.getItem('pasirku_toko');

      const cartItemsList = document.getElementById('cart-items-list');
      const paymentLines  = document.getElementById('payment-summary-lines');
      const ongkirSection = document.getElementById('ongkir-section');
      const grandTotalEl  = document.getElementById('grand-total');
      const emptyNotice   = document.getElementById('cart-empty-notice');
      const storeName     = document.getElementById('checkout-store-name');

      if (!cartRaw || !tokoRaw) {
        cartItemsList.innerHTML = '';
        emptyNotice.classList.remove('hidden');
        paymentLines.innerHTML  = '<p class="text-white/50 text-sm text-center">Tidak ada item</p>';
        ongkirSection.innerHTML = '';
        grandTotalEl.textContent = formatRupiah(0);
        const loading = document.getElementById('qris_loading');
        if(loading) loading.classList.add('hidden');
        return;
      }

      const cartItems = JSON.parse(cartRaw);
      const toko      = JSON.parse(tokoRaw);

      storeName.textContent = 'Toko: ' + toko.nama + ' | ' + toko.lokasi;

      if (!cartItems || cartItems.length === 0) {
        cartItemsList.innerHTML = '';
        emptyNotice.classList.remove('hidden');
        paymentLines.innerHTML  = '<p class="text-white/50 text-sm text-center">Tidak ada item</p>';
        ongkirSection.innerHTML = '';
        grandTotalEl.textContent = formatRupiah(0);
        return;
      }

      /*Render cart items*/
      cartItemsList.innerHTML = '';
      let subtotalPickUp = 0, subtotalTruck = 0;
      let qtyPickUp = 0,      qtyTruck = 0;
      let subTotal  = 0;

      cartItems.forEach(item => {
        const lineTotal = item.harga * item.qty;
        subTotal += lineTotal;
        if (item.type === 'pickup') { subtotalPickUp += lineTotal; qtyPickUp += item.qty; }
        else                        { subtotalTruck  += lineTotal; qtyTruck  += item.qty; }

        const typeLabel = item.type === 'pickup'
          ? '<span class="inline-flex items-center gap-1 text-blue-600 font-bold text-xs bg-blue-50 px-2 py-0.5 rounded-full"><span class="material-symbols-outlined text-[13px]">directions_car</span>Pick Up</span>'
          : '<span class="inline-flex items-center gap-1 text-amber-600 font-bold text-xs bg-amber-50 px-2 py-0.5 rounded-full"><span class="material-symbols-outlined text-[13px]">local_shipping</span>Truk</span>';

        const row = document.createElement('div');
        row.className = 'flex items-center justify-between bg-white rounded-xl px-4 py-3 shadow-sm border border-outline-variant/20';
        row.innerHTML = `
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-surface-container rounded-lg flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-[18px] text-on-surface-variant">landscape</span>
            </div>
            <div>
              <p class="font-bold text-sm text-on-surface leading-tight">${item.namaPasir}</p>
              <div class="flex items-center gap-2 mt-0.5">${typeLabel} <span class="text-xs text-on-surface-variant">x ${item.qty}</span></div>
            </div>
          </div>
          <div class="text-right">
            <p class="font-black text-sm text-on-surface">${formatRupiah(lineTotal)}</p>
            <p class="text-[10px] text-on-surface-variant">${formatRupiah(item.harga)} / unit</p>
          </div>`;
        cartItemsList.appendChild(row);
      });

      /* -- Ongkir & grand total ---------------------------- */
      const ongkirPickUpTotal = qtyPickUp > 0 ? toko.ongkirPickUp : 0;
      const ongkirTruckTotal  = qtyTruck  > 0 ? toko.ongkirTruck  : 0;
      const totalOngkir       = ongkirPickUpTotal + ongkirTruckTotal;
      const grandTotal        = subTotal + totalOngkir;

      /* -- Payment summary lines --------------------------- */
      paymentLines.innerHTML = '';
      if (qtyPickUp > 0) {
        const r = document.createElement('div');
        r.className = 'flex justify-between text-sm opacity-80 items-center';
        r.innerHTML = `<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">directions_car</span>Pick Up (${qtyPickUp} unit)</span><span>${formatRupiah(subtotalPickUp)}</span>`;
        paymentLines.appendChild(r);
      }
      if (qtyTruck > 0) {
        const r = document.createElement('div');
        r.className = 'flex justify-between text-sm opacity-80 items-center';
        r.innerHTML = `<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">local_shipping</span>Truk (${qtyTruck} unit)</span><span>${formatRupiah(subtotalTruck)}</span>`;
        paymentLines.appendChild(r);
      }
      const subtotalRow = document.createElement('div');
      subtotalRow.className = 'flex justify-between text-sm opacity-60 border-t border-white/10 pt-3 mt-1';
      subtotalRow.innerHTML = `<span>Subtotal Produk</span><span>${formatRupiah(subTotal)}</span>`;
      paymentLines.appendChild(subtotalRow);

      /* -- Ongkir section ---------------------------------- */
      ongkirSection.innerHTML = '';
      if (ongkirPickUpTotal > 0) {
        const r = document.createElement('div');
        r.className = 'flex justify-between text-sm opacity-80 items-center';
        r.innerHTML = `<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">directions_car</span>Ongkir Pick Up</span><span>${formatRupiah(ongkirPickUpTotal)}</span>`;
        ongkirSection.appendChild(r);
      }
      if (ongkirTruckTotal > 0) {
        const r = document.createElement('div');
        r.className = 'flex justify-between text-sm opacity-80 items-center';
        r.innerHTML = `<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">local_shipping</span>Ongkir Truk</span><span>${formatRupiah(ongkirTruckTotal)}</span>`;
        ongkirSection.appendChild(r);
      }
      if (totalOngkir === 0) {
        const r = document.createElement('div');
        r.className = 'flex justify-between text-sm opacity-50 items-center';
        r.innerHTML = `<span>Ongkos Kirim</span><span>-</span>`;
        ongkirSection.appendChild(r);
      }

      grandTotalEl.textContent = formatRupiah(grandTotal);

      /* -- Isi hidden inputs dari sessionStorage ----------- */
      document.getElementById('h-id-toko').value      = toko.id   ?? '';

      // Unit = total qty semua item (pickUp + truck)
      const totalQty = qtyPickUp + qtyTruck;
      document.getElementById('h-unit').value = totalQty > 0 ? totalQty : 1;

      /* Load QRIS from API */
      loadQris(toko.id, toko.nama, grandTotal);
    }

    /* ── File Upload Preview ─────────────────────────────── */
    document.addEventListener('DOMContentLoaded', () => {
      renderCheckout();
      hitungEstimasi(); // inisialisasi estimasi awal

      const inputBukti   = document.getElementById('input-bukti');
      const previewBox   = document.getElementById('preview-bukti');
      const previewImg   = document.getElementById('preview-img');
      const previewName  = document.getElementById('preview-filename');
      const previewSize  = document.getElementById('preview-filesize');
      const uploadLabel  = document.getElementById('upload-label');
      const btnUpload    = document.getElementById('btn-upload-bukti');

      inputBukti.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Tampilkan preview
        const reader = new FileReader();
        reader.onload = (e) => {
          previewImg.src      = e.target.result;
          previewName.textContent = file.name;
          previewSize.textContent = formatBytes(file.size) + ' | ' + file.type.split('/')[1].toUpperCase();
          previewBox.classList.remove('hidden');
          btnUpload.classList.add('hidden');
        };
        reader.readAsDataURL(file);
      });
    });

    function resetUpload() {
      document.getElementById('input-bukti').value  = '';
      document.getElementById('preview-bukti').classList.add('hidden');
      document.getElementById('btn-upload-bukti').classList.remove('hidden');
      document.getElementById('preview-img').src = '';
    }

    /* ── Hitung Estimasi Waktu Tiba (+4 jam) ────────────── */
    function hitungEstimasi() {
      const input = document.getElementById('jam-mulai');
      if (!input || !input.value) return;

      const [jamStr, menitStr] = input.value.split(':');
      const jamMulai   = parseInt(jamStr,  10);
      const menitMulai = parseInt(menitStr, 10);

      // Tambah 4 jam
      const totalMenitSelesai = jamMulai * 60 + menitMulai + 240;
      const jamSelesai   = Math.floor(totalMenitSelesai / 60) % 24;
      const menitSelesai = totalMenitSelesai % 60;

      const pad = (n) => String(n).padStart(2, '0');
      document.getElementById('estimasi-label').textContent =
        `${pad(jamMulai)}:${pad(menitMulai)} – ${pad(jamSelesai)}:${pad(menitSelesai)}`;
    }

    /* ── Form Submit: validasi + isi lokasi + loading ───── */
    document.getElementById('form-konfirmasi').addEventListener('submit', function (e) {
      // Ambil lokasi dari field baru
      const lokasiUtama = (document.getElementById('lokasi-pengantaran')?.value ?? '').trim();
      const detailTambahan = (document.getElementById('detail-lokasi')?.value ?? '').trim();
      
      document.getElementById('h-lokasi').value = lokasiUtama || 'Belum diisi';
      document.getElementById('h-detail-lokasi').value = detailTambahan;

      // Ambil tanggal pengiriman & jam tiba
      const tanggalPengiriman = (document.getElementById('tanggal-pengiriman')?.value ?? '').trim();
      const jamTiba = (document.getElementById('estimasi-label')?.textContent ?? '').trim();
      
      document.getElementById('h-tanggal').value = tanggalPengiriman;
      document.getElementById('h-jam-tiba').value = jamTiba;

      // Validasi: file harus sudah dipilih
      const file = document.getElementById('input-bukti').files[0];
      if (!file) {
        e.preventDefault();
        alert('Harap upload bukti pembayaran terlebih dahulu!');
        document.getElementById('btn-upload-bukti').classList.add('ring-2', 'ring-red-400');
        setTimeout(() => document.getElementById('btn-upload-bukti').classList.remove('ring-2', 'ring-red-400'), 2000);
        return;
      }

      // Tampilkan Loading Overlay Premium
      const overlay = document.getElementById('loading-overlay');
      if (overlay) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
      }

      // Loading state di tombol
      const btn   = document.getElementById('btn-konfirmasi');
      const icon  = document.getElementById('konfirmasi-icon');
      const label = document.getElementById('konfirmasi-label');
      if (btn) btn.disabled   = true;
      if (icon) {
        icon.textContent  = 'hourglass_top';
        icon.style.animation = 'spin 1s linear infinite';
      }
      if (label) label.textContent = 'Memproses...';
    });
  </script>

  <!-- Loading Overlay Glassmorphic Premium -->
  <div id="loading-overlay" class="fixed inset-0 bg-slate-950/70 backdrop-blur-md hidden flex flex-col items-center justify-center z-[99999] transition-all duration-300">
    <div class="bg-white/95 backdrop-blur-xl p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-sm text-center border border-white/20 transform scale-100 transition-transform duration-300">
      <div class="relative w-24 h-24 mb-6">
        <!-- Outer Animated Spin Ring -->
        <div class="absolute inset-0 rounded-full border-[6px] border-slate-100"></div>
        <div class="absolute inset-0 rounded-full border-[6px] border-t-primary border-r-primary animate-spin"></div>
        <!-- Inner Decorative Pulse Icon -->
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="material-symbols-outlined text-4xl text-primary animate-pulse">local_shipping</span>
        </div>
      </div>
      <h3 class="font-headline font-black text-xl text-on-surface mb-2">Memproses Pesanan</h3>
      <p class="text-on-surface-variant text-sm px-4 leading-relaxed font-medium">Mohon tunggu sebentar, kami sedang mengunggah bukti pembayaran dan menyimpan pesanan Anda...</p>
    </div>
  </div>

  <style>
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  </style>

</body>
