<x-layout-user title="Checkout">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
      <button onclick="history.back()" class="flex items-center gap-1.5 text-sm text-on-surface-variant hover:text-primary font-semibold transition-colors mb-4">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Toko
      </button>
      <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
        <a href="{{ route('MenuUtama') }}" class="hover:text-primary transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="font-semibold text-primary">Checkout</span>
      </nav>
      <h1 class="font-headline text-3xl font-bold text-on-surface">Checkout</h1>
      <p id="checkout-store-name" class="mt-1 text-on-surface-variant text-sm font-medium"></p>
    </div>

    {{-- Main Grid --}}
    <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      @csrf
      <input type="hidden" name="id_toko" id="id_toko_input" value="">
      <input type="hidden" name="items" id="items_input" value="">

      {{-- Left Column: Forms --}}
      <div class="lg:col-span-2 space-y-6">

        {{-- Cart Items --}}
        <section class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6" id="cart-items-section">
          <div class="flex items-center gap-3 mb-5">
            <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">shopping_basket</span>
            </div>
            <h2 class="font-headline text-lg font-bold text-on-surface">Item yang Dipesan</h2>
          </div>
          <div id="cart-items-list" class="space-y-3">
            <div class="h-16 rounded-xl bg-surface-container animate-pulse"></div>
            <div class="h-16 rounded-xl bg-surface-container animate-pulse opacity-60"></div>
          </div>
          <div id="cart-empty-notice" class="hidden text-center py-10 text-on-surface-variant">
            <span class="material-symbols-outlined text-5xl mb-3 block opacity-30">remove_shopping_cart</span>
            <p class="font-semibold">Keranjang kosong.</p>
            <p class="text-sm mt-1">Silakan pilih produk terlebih dahulu.</p>
            <button onclick="history.back()" class="mt-4 bg-primary text-on-primary px-6 py-2 rounded-full text-sm font-bold hover:bg-primary-container transition-colors">
              Pilih Produk
            </button>
          </div>
        </section>

        {{-- Shipping Address --}}
        <section class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 bg-secondary/10 rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-secondary" style="font-variation-settings:'FILL' 1">local_shipping</span>
            </div>
            <h2 class="font-headline text-lg font-bold text-on-surface">Alamat Pengiriman</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="flex flex-col gap-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nama Penerima</label>
              <input name="nama_penerima" required class="bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 transition-all outline-none" placeholder="Contoh: PT. Konstruksi Maju" type="text" />
            </div>
            <div class="flex flex-col gap-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nomor Telepon</label>
              <input name="no_telepon" required class="bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 transition-all outline-none" placeholder="+62 812 XXXX" type="tel" />
            </div>
            <div class="md:col-span-2 flex flex-col gap-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Detail Lokasi Proyek</label>
              <textarea name="detail_lokasi" required class="bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 transition-all outline-none resize-none" placeholder="Jl. Industrial No. 45, Area Konstruksi Blok B" rows="3"></textarea>
            </div>
            <div class="flex flex-col gap-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Kode Pos / Area</label>
              <input class="bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30 transition-all outline-none" placeholder="12345" type="text" />
            </div>
          </div>
        </section>

        {{-- Delivery Schedule --}}
        <section class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 border-l-4 border-l-primary p-6">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
              <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">calendar_today</span>
            </div>
            <h2 class="font-headline text-lg font-bold text-on-surface">Jadwal Pengiriman</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-surface-container-low p-5 rounded-xl">
              <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">Pilih Tanggal</p>
              <div class="flex items-center justify-between bg-surface-container-lowest px-4 py-3 rounded-xl border border-outline-variant/30">
                <input type="date" name="jadwal_pengiriman" required class="w-full bg-transparent border-none p-0 focus:ring-0 font-semibold text-sm outline-none text-on-surface" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
              </div>
            </div>
            <div class="bg-surface-container-low p-5 rounded-xl">
              <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">Estimasi Waktu Tiba</p>
              <div class="grid grid-cols-2 gap-2">
                <button class="bg-primary text-on-primary py-2.5 rounded-xl font-bold text-sm hover:bg-primary-container transition-colors">Pagi (08:00)</button>
                <button class="bg-surface-container-lowest text-on-surface py-2.5 rounded-xl font-bold text-sm hover:bg-primary-fixed/20 border border-outline-variant/30 transition-colors">Siang (13:00)</button>
              </div>
            </div>
          </div>
        </section>

      </div>

      {{-- Right Column: Payment Summary --}}
      <div class="space-y-5">
        <div class="sticky top-[76px] space-y-5">

          {{-- Order Summary --}}
          <div class="bg-on-surface text-on-primary rounded-2xl p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-5">
              <span class="material-symbols-outlined" style="font-size:120px;font-variation-settings:'wght' 700">receipt_long</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] mb-5 text-surface-dim">Ringkasan Pembayaran</h3>
            <div id="payment-summary-lines" class="space-y-3 mb-6"></div>
            <div class="border-t border-white/10 pt-4 mb-2" id="ongkir-section"></div>
            <div class="border-t border-white/10 pt-5">
              <div class="flex justify-between items-end">
                <span class="text-sm font-bold uppercase text-surface-dim">Total Tagihan</span>
                <span id="grand-total" class="text-2xl font-headline font-black text-primary-fixed">Rp 0</span>
              </div>
            </div>
          </div>

          {{-- Payment Method: QRIS --}}
          <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            {{-- Header --}}
            <div class="flex items-center gap-3 px-5 py-4 border-b border-outline-variant/20">
              <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings:'FILL' 1">qr_code_2</span>
              </div>
              <div>
                <h3 class="font-headline text-base font-bold text-on-surface leading-tight">Bayar via QRIS</h3>
                <p class="text-[10px] text-on-surface-variant">Scan QR dari aplikasi Bank/e-Wallet Anda</p>
              </div>
            </div>

            {{-- QRIS Card Body --}}
            <div class="p-5 space-y-5">

              {{-- QRIS image + store info --}}
              <div id="qris_wrapper" class="flex flex-col items-center">
                {{-- Loading state --}}
                <div id="qris_loading" class="flex flex-col items-center justify-center py-8 gap-3 w-full">
                  <div class="w-10 h-10 rounded-full border-4 border-primary/20 border-t-primary animate-spin"></div>
                  <p class="text-xs text-on-surface-variant font-medium">Memuat QRIS Toko...</p>
                </div>
                {{-- Content injected by JS --}}
                <div id="qris_content" class="hidden w-full flex flex-col items-center gap-3"></div>
              </div>

              {{-- Divider --}}
              <div class="flex items-center gap-3">
                <div class="flex-1 h-px bg-outline-variant/30"></div>
                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Langkah selanjutnya</span>
                <div class="flex-1 h-px bg-outline-variant/30"></div>
              </div>

              {{-- Steps --}}
              <div class="space-y-3">
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-black shrink-0 mt-0.5">1</div>
                  <p class="text-xs text-on-surface-variant leading-relaxed">Scan QRIS toko menggunakan aplikasi Bank atau e-Wallet Anda.</p>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-black shrink-0 mt-0.5">2</div>
                  <p class="text-xs text-on-surface-variant leading-relaxed">Masukkan jumlah sesuai <strong class="text-on-surface">Total Tagihan</strong> di atas.</p>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-black shrink-0 mt-0.5">3</div>
                  <p class="text-xs text-on-surface-variant leading-relaxed">Upload foto bukti pembayaran lalu tekan <strong class="text-on-surface">Konfirmasi Pesanan</strong>.</p>
                </div>
              </div>

              {{-- Upload Bukti Pembayaran (existing feature, preserved) --}}
              <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/20">
                <p class="text-xs font-bold text-on-surface uppercase tracking-wider mb-3">Upload Bukti Pembayaran</p>
                <label for="bukti_pembayaran" class="w-full flex items-center justify-center gap-2 bg-surface-container-lowest border-2 border-dashed border-outline-variant/50 py-4 rounded-xl font-bold text-sm hover:border-primary/40 hover:bg-primary/5 transition-all cursor-pointer group">
                  <span class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">cloud_upload</span>
                  <span id="bukti_label" class="text-on-surface-variant group-hover:text-primary transition-colors">Pilih Foto Bukti Transfer</span>
                </label>
                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="hidden" accept="image/*" onchange="previewBukti(event)">
                <div id="bukti_preview_wrap" class="hidden mt-3">
                  <img id="bukti_preview_img" src="" alt="Preview" class="w-full max-h-40 object-contain rounded-lg border border-outline-variant/30">
                </div>
              </div>

              {{-- Submit --}}
              <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-xl font-headline font-bold text-base shadow-sm hover:opacity-90 transition-all active:scale-95 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                KONFIRMASI PESANAN
              </button>
              <p class="text-[10px] text-center text-on-surface-variant italic">
                *Dengan mengklik Konfirmasi, Anda menyetujui syarat &amp; ketentuan pengiriman.
              </p>

            </div>
          </div>

        </div>
      </div>

    </form>
  </div>


  @push('scripts')
  <script>
    function formatRupiah(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

    /* ── Preview foto bukti pembayaran ──────────────────────── */
    function previewBukti(event) {
      const file = event.target.files[0];
      if (!file) return;
      const label = document.getElementById('bukti_label');
      const wrap  = document.getElementById('bukti_preview_wrap');
      const img   = document.getElementById('bukti_preview_img');
      label.textContent = file.name;
      img.src = URL.createObjectURL(file);
      wrap.classList.remove('hidden');
    }

    /* ── Render QRIS dari API ────────────────────────────────── */
    function loadQris(tokoId, tokoNama, grandTotal) {
      const loading = document.getElementById('qris_loading');
      const content = document.getElementById('qris_content');

      fetch(`/api/store/${tokoId}/qris`)
        .then(res => res.json())
        .then(data => {
          loading.classList.add('hidden');
          content.classList.remove('hidden');

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
                <a href="{{ route('Pesan') }}" class="text-xs font-bold text-amber-700 border border-amber-300 px-4 py-2 rounded-full hover:bg-amber-100 transition-colors">
                  Hubungi Toko via Chat
                </a>
              </div>
            `;
          }
        })
        .catch(() => {
          loading.classList.add('hidden');
          content.classList.remove('hidden');
          content.innerHTML = `
            <div class="w-full bg-red-50 border border-red-200 rounded-2xl p-5 flex flex-col items-center gap-2 text-center">
              <span class="material-symbols-outlined text-red-500 text-3xl">error</span>
              <p class="text-sm font-bold text-red-700">Gagal Memuat QRIS</p>
              <p class="text-xs text-red-600">Periksa koneksi internet Anda dan muat ulang halaman.</p>
            </div>
          `;
        });
    }

    /* ── Render seluruh halaman checkout ─────────────────────── */
    function renderCheckout() {
      const cartRaw = sessionStorage.getItem('pasirku_cart');
      const tokoRaw = sessionStorage.getItem('pasirku_toko');

      const cartItemsList = document.getElementById('cart-items-list');
      const paymentLines  = document.getElementById('payment-summary-lines');
      const ongkirSection = document.getElementById('ongkir-section');
      const grandTotalEl  = document.getElementById('grand-total');
      const emptyNotice   = document.getElementById('cart-empty-notice');
      const storeName     = document.getElementById('checkout-store-name');

      if (!cartRaw || !tokoRaw) {
        cartItemsList.innerHTML = '';
        emptyNotice.classList.remove('hidden');
        paymentLines.innerHTML = '<p class="text-white/40 text-sm text-center">Tidak ada item</p>';
        ongkirSection.innerHTML = '';
        grandTotalEl.textContent = formatRupiah(0);
        // Hide QRIS loading, show error
        document.getElementById('qris_loading').classList.add('hidden');
        const content = document.getElementById('qris_content');
        content.classList.remove('hidden');
        content.innerHTML = `<p class="text-sm text-on-surface-variant text-center py-4">Tidak ada toko dipilih.</p>`;
        return;
      }

      const cartItems = JSON.parse(cartRaw);
      const toko      = JSON.parse(tokoRaw);

      storeName.textContent = 'Toko: ' + toko.nama + ' · ' + toko.lokasi;
      document.getElementById('id_toko_input').value = toko.id;
      document.getElementById('items_input').value   = cartRaw;

      if (!cartItems || cartItems.length === 0) {
        cartItemsList.innerHTML = '';
        emptyNotice.classList.remove('hidden');
        paymentLines.innerHTML = '<p class="text-white/40 text-sm text-center">Tidak ada item</p>';
        ongkirSection.innerHTML = '';
        grandTotalEl.textContent = formatRupiah(0);
        return;
      }

      /* Render cart rows */
      cartItemsList.innerHTML = '';
      let subtotalPickUp=0, subtotalTruck=0, qtyPickUp=0, qtyTruck=0, subTotal=0;

      cartItems.forEach(item => {
        const lineTotal = item.harga * item.qty;
        subTotal += lineTotal;
        if (item.type === 'pickup') { subtotalPickUp += lineTotal; qtyPickUp += item.qty; }
        else                        { subtotalTruck  += lineTotal; qtyTruck  += item.qty; }

        const typeLabel = item.type === 'pickup'
          ? `<span class="inline-flex items-center gap-1 text-tertiary font-bold text-xs bg-tertiary/10 px-2 py-0.5 rounded-full"><span class="material-symbols-outlined text-[13px]">directions_car</span>Pick Up</span>`
          : `<span class="inline-flex items-center gap-1 text-primary font-bold text-xs bg-primary/10 px-2 py-0.5 rounded-full"><span class="material-symbols-outlined text-[13px]">local_shipping</span>Truk</span>`;

        const row = document.createElement('div');
        row.className = 'flex items-center justify-between bg-surface-container-low rounded-xl px-4 py-3 border border-outline-variant/20';
        row.innerHTML = `
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
              <span class="material-symbols-outlined text-[18px] text-primary">landscape</span>
            </div>
            <div>
              <p class="font-bold text-sm text-on-surface leading-tight">${item.namaPasir}</p>
              <div class="flex items-center gap-2 mt-0.5">${typeLabel} <span class="text-xs text-on-surface-variant">× ${item.qty}</span></div>
            </div>
          </div>
          <div class="text-right">
            <p class="font-black text-sm text-on-surface">${formatRupiah(lineTotal)}</p>
            <p class="text-[10px] text-on-surface-variant">${formatRupiah(item.harga)} / unit</p>
          </div>
        `;
        cartItemsList.appendChild(row);
      });

      /* Ongkir & Grand Total */
      const ongkirPickUpTotal = qtyPickUp > 0 ? toko.ongkirPickUp : 0;
      const ongkirTruckTotal  = qtyTruck  > 0 ? toko.ongkirTruck  : 0;
      const totalOngkir = ongkirPickUpTotal + ongkirTruckTotal;
      const grandTotal  = subTotal + totalOngkir;

      /* Payment summary lines */
      paymentLines.innerHTML = '';
      if (qtyPickUp > 0) { const r=document.createElement('div'); r.className='flex justify-between text-sm opacity-80 items-center'; r.innerHTML=`<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">directions_car</span>Pick Up (${qtyPickUp} unit)</span><span>${formatRupiah(subtotalPickUp)}</span>`; paymentLines.appendChild(r); }
      if (qtyTruck  > 0) { const r=document.createElement('div'); r.className='flex justify-between text-sm opacity-80 items-center'; r.innerHTML=`<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">local_shipping</span>Truk (${qtyTruck} unit)</span><span>${formatRupiah(subtotalTruck)}</span>`; paymentLines.appendChild(r); }
      const sr=document.createElement('div'); sr.className='flex justify-between text-sm opacity-60 border-t border-white/10 pt-3 mt-1'; sr.innerHTML=`<span>Subtotal Produk</span><span>${formatRupiah(subTotal)}</span>`; paymentLines.appendChild(sr);

      ongkirSection.innerHTML = '';
      if (ongkirPickUpTotal > 0) { const r=document.createElement('div'); r.className='flex justify-between text-sm opacity-80 items-center'; r.innerHTML=`<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">directions_car</span>Ongkir Pick Up</span><span>${formatRupiah(ongkirPickUpTotal)}</span>`; ongkirSection.appendChild(r); }
      if (ongkirTruckTotal  > 0) { const r=document.createElement('div'); r.className='flex justify-between text-sm opacity-80 items-center'; r.innerHTML=`<span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[14px]">local_shipping</span>Ongkir Truk</span><span>${formatRupiah(ongkirTruckTotal)}</span>`; ongkirSection.appendChild(r); }
      if (totalOngkir === 0) { const r=document.createElement('div'); r.className='flex justify-between text-sm opacity-50 items-center'; r.innerHTML=`<span>Ongkos Kirim</span><span>–</span>`; ongkirSection.appendChild(r); }

      grandTotalEl.textContent = formatRupiah(grandTotal);

      /* Load QRIS from API */
      loadQris(toko.id, toko.nama, grandTotal);
    }

    document.addEventListener('DOMContentLoaded', renderCheckout);
  </script>
  @endpush

</x-layout-user>

