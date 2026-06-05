<x-layout-store title="Active Orders">

  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary">Dashboard</a>
      <span class="material-symbols-outlined text-sm">chevron_right</span>
      <span class="text-primary font-semibold">Pelacakan Pesanan</span>
    </nav>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
      <div>
        <h1 class="font-headline text-3xl font-bold text-on-surface">Manajemen Pesanan</h1>
        <p class="text-on-surface-variant text-sm mt-1">Pantau dan kelola semua pesanan masuk dari pelanggan Anda.</p>
      </div>
      <div class="flex gap-3 shrink-0">
        <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-xl text-sm font-medium text-on-surface-variant hover:bg-surface-container-low transition-all">
          <span class="material-symbols-outlined text-lg">filter_list</span>Filter
        </button>
        <button class="flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-xl text-sm font-semibold hover:opacity-90 transition-all shadow-sm">
          <span class="material-symbols-outlined text-lg">download</span>Ekspor
        </button>
      </div>
    </div>
  </x-slot>

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Status Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center mb-3">
          <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">list_alt</span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $statuses['total'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">Semua Pesanan</p>
      </div>
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="w-11 h-11 bg-amber-500/10 rounded-xl flex items-center justify-center mb-3">
          <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">pending</span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $statuses['pending'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">Menunggu Konfirmasi</p>
      </div>
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="w-11 h-11 bg-tertiary/10 rounded-xl flex items-center justify-center mb-3">
          <span class="material-symbols-outlined text-tertiary" style="font-variation-settings:'FILL' 1">local_shipping</span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $statuses['dikirim'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">Dalam Pengiriman</p>
      </div>
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center mb-3">
          <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $statuses['selesai_hari_ini'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">Selesai Hari Ini</p>
      </div>
    </div>

    {{-- Orders Table --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
      {{-- Table Header with Search & Filter --}}
      <div class="p-5 border-b border-outline-variant/20 flex flex-col sm:flex-row gap-3 sm:items-center justify-between">
        <h2 class="font-headline font-bold text-lg text-on-surface">Daftar Pesanan</h2>
        <div class="flex gap-3 items-center flex-wrap">
          {{-- Status Filter Tabs --}}
          <div class="flex gap-1 bg-surface-container-low rounded-xl p-1">
            @foreach(['Semua','Baru','Proses','Kirim','Selesai'] as $tab)
            <a href="{{ route('ordertrackingStore', ['status' => $tab]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ request('status', 'Semua') === $tab ? 'bg-surface-container-lowest shadow-sm text-on-surface' : 'text-on-surface-variant hover:text-on-surface' }}">
              {{ $tab }}
            </a>
            @endforeach
          </div>
          {{-- Search --}}
          <form method="GET" action="{{ route('ordertrackingStore') }}" class="relative">
            <input type="hidden" name="status" value="{{ request('status', 'Semua') }}">
            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">
              <span class="material-symbols-outlined">search</span>
            </button>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pesanan..." class="pl-9 pr-4 py-2 text-sm border border-outline-variant rounded-xl bg-surface-container-low focus:ring-2 focus:ring-primary/20 focus:outline-none w-52 transition-all"/>
          </form>
        </div>
      </div>

      {{-- Table --}}
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
              <th class="px-5 py-3 text-left font-semibold">ID Pesanan</th>
              <th class="px-5 py-3 text-left font-semibold">Pelanggan</th>
              <th class="px-5 py-3 text-left font-semibold">Produk</th>
              <th class="px-5 py-3 text-left font-semibold">Total</th>
              <th class="px-5 py-3 text-left font-semibold">Status</th>
              <th class="px-5 py-3 text-left font-semibold">Tanggal</th>
              <th class="px-5 py-3 text-right font-semibold">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/15">
            @forelse($orders as $o)
            <tr class="hover:bg-surface-container-low/60 transition-colors">
              <td class="px-5 py-4 font-mono text-xs font-semibold text-on-surface-variant">#ORD-{{ str_pad($o->ID_Pesanan, 4, '0', STR_PAD_LEFT) }}</td>
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container font-bold text-sm flex items-center justify-center shrink-0">{{ substr($o->nama_pembeli ?? $o->Username, 0, 1) }}</div>
                  <span class="font-semibold text-on-surface">{{ $o->nama_pembeli ?? $o->Username }}</span>
                </div>
              </td>
              <td class="px-5 py-4 text-on-surface-variant">
                <p class="truncate max-w-[200px]" title="{{ $o->nama_produk }}">{{ $o->nama_produk }}</p>
                <p class="text-[10px] text-on-surface-variant">{{ $o->Lokasi_Pengantaran }}</p>
              </td>
              <td class="px-5 py-4">
                <div class="font-semibold text-primary">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</div>
                <div class="flex items-center gap-1.5 mt-1">
                  @php
                    $statusPembayaran = $o->Status_Pembayaran;
                    if ($statusPembayaran === 'unpaid' || $statusPembayaran === 'Belum Dikonfirmasi' || !$statusPembayaran) {
                        $statusPembayaranLabel = 'Pending';
                        $payBadgeColor = 'text-amber-600 bg-amber-50 border border-amber-200/50';
                    } elseif ($statusPembayaran === 'Lunas' || $statusPembayaran === 'paid') {
                        $statusPembayaranLabel = 'Lunas';
                        $payBadgeColor = 'text-green-600 bg-green-50 border border-green-200/50';
                    } elseif ($statusPembayaran === 'Dibatalkan') {
                        $statusPembayaranLabel = 'Dibatalkan';
                        $payBadgeColor = 'text-red-500 bg-red-50 border border-red-200/50';
                    } else {
                        $statusPembayaranLabel = ucfirst($statusPembayaran);
                        $payBadgeColor = 'text-outline bg-surface-container border border-outline-variant/30';
                    }
                  @endphp
                  <span class="inline-block text-[9px] font-black tracking-wider uppercase px-2 py-0.5 rounded-md {{ $payBadgeColor }}">
                    {{ $statusPembayaranLabel }}
                  </span>
                  @if($o->Bukti_Pembayaran)
                    <a href="{{ route('bukti.image', basename($o->Bukti_Pembayaran)) }}" target="_blank" class="inline-flex items-center gap-0.5 text-[10px] font-bold text-primary hover:underline hover:opacity-80 transition-all ml-1" title="Lihat Bukti Transfer">
                      <span class="material-symbols-outlined text-[12px]" style="font-variation-settings:'FILL' 1">receipt</span>Bukti
                    </a>
                  @endif
                </div>
              </td>
              <td class="px-5 py-4">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] uppercase font-black tracking-wider {{ $o->statusBadgeClass() }}">
                  <span class="material-symbols-outlined text-[12px]">{{ $o->statusIcon() }}</span>
                  {{ $o->statusLabel() }}
                </span>
              </td>
              <td class="px-5 py-4 text-xs text-on-surface-variant">{{ $o->created_at->format('d M Y, H:i') }}</td>
              <td class="px-5 py-4 text-right">
                <div class="flex flex-wrap gap-1 justify-end">
                  {{-- Tombol Detail --}}
                  <button onclick="openOrderDetail({{ $o->ID_Pesanan }})" class="px-2 py-1 text-[10px] font-bold bg-surface-container-high text-on-surface rounded hover:bg-surface-container transition-all inline-flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-[12px]">visibility</span>Detail
                  </button>
                  @if($o->Status_Pesanan === \App\Models\Pesanan::STATUS_PENDING)
                    <form method="POST" action="{{ route('ordertrackingStore.updateStatus', $o->ID_Pesanan) }}">
                      @csrf @method('PUT')
                      <input type="hidden" name="status" value="{{ \App\Models\Pesanan::STATUS_DIPROSES }}">
                      <button type="submit" class="px-2 py-1 text-[10px] font-bold bg-primary text-on-primary rounded hover:opacity-90">Terima</button>
                    </form>
                    <form method="POST" action="{{ route('ordertrackingStore.updateStatus', $o->ID_Pesanan) }}">
                      @csrf @method('PUT')
                      <input type="hidden" name="status" value="{{ \App\Models\Pesanan::STATUS_DIBATALKAN }}">
                      <input type="hidden" name="alasan_tolak" value="Stok habis">
                      <button type="submit" class="px-2 py-1 text-[10px] font-bold bg-red-100 text-red-600 rounded hover:bg-red-200">Tolak</button>
                    </form>
                  @elseif($o->Status_Pesanan === \App\Models\Pesanan::STATUS_DIPROSES)
                    <form method="POST" action="{{ route('ordertrackingStore.updateStatus', $o->ID_Pesanan) }}">
                      @csrf @method('PUT')
                      <input type="hidden" name="status" value="{{ \App\Models\Pesanan::STATUS_DIKIRIM }}">
                      <input type="hidden" name="info_pengiriman" value="Driver sedang menuju lokasi">
                      <button type="submit" class="px-2 py-1 text-[10px] font-bold bg-tertiary text-on-tertiary rounded hover:opacity-90">Kirim</button>
                    </form>
                  @elseif($o->Status_Pesanan === \App\Models\Pesanan::STATUS_DIKIRIM)
                    <span class="inline-flex items-center gap-1 px-2 py-1 text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/50 rounded" title="Pembeli akan mengkonfirmasi penerimaan pesanan">
                      <span class="material-symbols-outlined text-[12px]">hourglass_top</span>Menunggu Konfirmasi Pembeli
                    </span>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="px-5 py-8 text-center text-on-surface-variant">Belum ada pesanan yang sesuai.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="px-5 py-4 border-t border-outline-variant/20 flex items-center justify-between text-sm">
        {{ $orders->links() }}
      </div>
    </div>

  </div>

  {{-- ═══════════════════════════════════════════════════════════════════ --}}
  {{-- MODAL DETAIL PESANAN                                               --}}
  {{-- ═══════════════════════════════════════════════════════════════════ --}}
  <div id="orderDetailModal" class="fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div onclick="closeOrderDetail()" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
    {{-- Panel --}}
    <div class="absolute inset-y-0 right-0 w-full max-w-lg bg-surface-container-lowest shadow-2xl flex flex-col animate-slide-in-right">
      {{-- Header --}}
      <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/20">
        <div>
          <h3 class="font-headline font-bold text-lg text-on-surface" id="modal-order-code">Detail Pesanan</h3>
          <p class="text-xs text-on-surface-variant mt-0.5" id="modal-created-at"></p>
        </div>
        <button onclick="closeOrderDetail()" class="w-9 h-9 rounded-xl flex items-center justify-center hover:bg-surface-container-low transition-colors">
          <span class="material-symbols-outlined text-on-surface-variant">close</span>
        </button>
      </div>

      {{-- Body --}}
      <div class="flex-1 overflow-y-auto px-6 py-5 space-y-5" id="modal-body">
        {{-- Loading state --}}
        <div id="modal-loading" class="flex flex-col items-center justify-center py-16">
          <div class="w-8 h-8 border-3 border-primary/30 border-t-primary rounded-full animate-spin"></div>
          <p class="text-sm text-on-surface-variant mt-3">Memuat detail...</p>
        </div>

        {{-- Content (hidden until loaded) --}}
        <div id="modal-content" class="hidden space-y-5">

          {{-- Status Badges --}}
          <div class="flex gap-2 flex-wrap">
            <span id="modal-status-pesanan" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs uppercase font-black tracking-wider"></span>
            <span id="modal-status-pembayaran" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs uppercase font-black tracking-wider"></span>
          </div>

          {{-- Info Pembeli --}}
          <div class="bg-surface-container-low rounded-xl p-4 space-y-3">
            <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Informasi Pembeli</h4>
            <div class="grid grid-cols-2 gap-3 text-sm">
              <div>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-wide font-semibold">Nama</p>
                <p class="font-semibold text-on-surface" id="modal-buyer"></p>
              </div>
              <div>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-wide font-semibold">Tipe Pengiriman</p>
                <p class="font-semibold text-on-surface capitalize" id="modal-tipe"></p>
              </div>
              <div class="col-span-2">
                <p class="text-[10px] text-on-surface-variant uppercase tracking-wide font-semibold">Lokasi Pengantaran</p>
                <p class="font-semibold text-on-surface" id="modal-lokasi"></p>
              </div>
            </div>
          </div>

          {{-- Info Pengiriman --}}
          <div class="bg-surface-container-low rounded-xl p-4 space-y-3">
            <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Jadwal Pengiriman</h4>
            <div class="grid grid-cols-2 gap-3 text-sm">
              <div>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-wide font-semibold">Tanggal</p>
                <p class="font-semibold text-on-surface" id="modal-tanggal"></p>
              </div>
              <div>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-wide font-semibold">Estimasi Tiba</p>
                <p class="font-semibold text-on-surface" id="modal-jam"></p>
              </div>
            </div>
            <div id="modal-info-pengiriman-wrap" class="hidden">
              <p class="text-[10px] text-on-surface-variant uppercase tracking-wide font-semibold">Info Pengiriman</p>
              <p class="font-semibold text-on-surface text-sm" id="modal-info-pengiriman"></p>
            </div>
          </div>

          {{-- Produk --}}
          <div class="bg-surface-container-low rounded-xl p-4 space-y-3">
            <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Detail Produk</h4>
            <div id="modal-cart-items" class="space-y-2"></div>
          </div>

          {{-- Rincian Harga --}}
          <div class="bg-surface-container-low rounded-xl p-4 space-y-3">
            <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Rincian Pembayaran</h4>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-on-surface-variant">Total Harga</span>
                <span class="font-semibold text-on-surface" id="modal-total"></span>
              </div>
              <div class="flex justify-between items-center">
                <span class="text-red-500 flex items-center gap-1">
                  <span class="material-symbols-outlined text-sm">remove_circle</span>
                  Komisi Admin (1,05%)
                </span>
                <span class="font-semibold text-red-500" id="modal-komisi"></span>
              </div>
              <div class="border-t border-outline-variant/20 pt-2 flex justify-between">
                <span class="font-bold text-on-surface">Pendapatan Bersih</span>
                <span class="font-bold text-primary text-base" id="modal-bersih"></span>
              </div>
            </div>
          </div>

          {{-- Bukti Pembayaran --}}
          <div id="modal-bukti-wrap" class="hidden bg-surface-container-low rounded-xl p-4 space-y-3">
            <h4 class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Bukti Pembayaran</h4>
            <a id="modal-bukti-link" href="#" target="_blank" class="block">
              <img id="modal-bukti-img" src="" alt="Bukti Pembayaran" class="w-full max-h-64 object-contain rounded-lg border border-outline-variant/20" />
            </a>
          </div>

          {{-- Alasan Tolak --}}
          <div id="modal-tolak-wrap" class="hidden bg-red-50 rounded-xl p-4 space-y-2">
            <h4 class="text-xs font-bold text-red-600 uppercase tracking-wider flex items-center gap-1">
              <span class="material-symbols-outlined text-sm">cancel</span> Alasan Pembatalan
            </h4>
            <p class="text-sm text-red-700" id="modal-alasan-tolak"></p>
          </div>

        </div>
      </div>

      {{-- Footer --}}
      <div class="px-6 py-4 border-t border-outline-variant/20">
        <button onclick="closeOrderDetail()" class="w-full py-2.5 bg-surface-container-high text-on-surface font-semibold rounded-xl hover:bg-surface-container transition-colors text-sm">
          Tutup
        </button>
      </div>
    </div>
  </div>

  {{-- Slide-in Animation --}}
  <style>
    @keyframes slideInRight {
      from { transform: translateX(100%); opacity: 0; }
      to   { transform: translateX(0);    opacity: 1; }
    }
    .animate-slide-in-right {
      animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
  </style>

  {{-- Modal JavaScript --}}
  <script>
    function openOrderDetail(orderId) {
      const modal = document.getElementById('orderDetailModal');
      const loading = document.getElementById('modal-loading');
      const content = document.getElementById('modal-content');

      // Show modal with loading
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      loading.classList.remove('hidden');
      content.classList.add('hidden');

      // Fetch detail
      fetch(`/ordertrackingStore/${orderId}/detail`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => {
        if (!res.ok) throw new Error('Gagal memuat detail');
        return res.json();
      })
      .then(data => {
        // Header
        document.getElementById('modal-order-code').textContent = 'Detail Pesanan ' + data.order_code;
        document.getElementById('modal-created-at').textContent = 'Dibuat: ' + data.created_at;

        // Status badges
        const statusPesanan = document.getElementById('modal-status-pesanan');
        statusPesanan.textContent = data.status_pesanan;
        statusPesanan.className = 'inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs uppercase font-black tracking-wider ' + getStatusClass(data.status_pesanan);

        const statusBayar = document.getElementById('modal-status-pembayaran');
        statusBayar.textContent = data.status_pembayaran;
        statusBayar.className = 'inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs uppercase font-black tracking-wider ' + getPaymentClass(data.status_pembayaran);

        // Buyer info
        document.getElementById('modal-buyer').textContent = data.nama_pembeli;
        document.getElementById('modal-tipe').textContent = data.tipe_pengiriman === 'pickup' ? 'Pick Up' : 'Truk';
        document.getElementById('modal-lokasi').textContent = data.lokasi_pengantaran;

        // Schedule
        document.getElementById('modal-tanggal').textContent = data.tanggal_pengiriman;
        document.getElementById('modal-jam').textContent = data.jam_tiba;

        // Info pengiriman
        const infoPengirimanWrap = document.getElementById('modal-info-pengiriman-wrap');
        if (data.info_pengiriman) {
          infoPengirimanWrap.classList.remove('hidden');
          document.getElementById('modal-info-pengiriman').textContent = data.info_pengiriman;
        } else {
          infoPengirimanWrap.classList.add('hidden');
        }

        // Cart items
        const cartContainer = document.getElementById('modal-cart-items');
        if (data.cart_items && data.cart_items.length > 0) {
          let cartHtml = '';
          data.cart_items.forEach(item => {
            const name = item.namaPasir || item.nama_pasir || 'Produk';
            const qty = item.qty || 1;
            const type = item.type === 'pickup' ? 'Pick Up' : 'Truk';
            const price = item.price || item.harga || 0;
            const subtotal = price * qty;
            cartHtml += `
              <div class="flex items-center justify-between py-2 px-3 bg-surface-container-lowest rounded-lg">
                <div>
                  <p class="font-semibold text-on-surface text-sm">${name}</p>
                  <p class="text-[10px] text-on-surface-variant">${type} • ${qty} unit</p>
                </div>
                <span class="font-semibold text-on-surface text-sm">Rp ${subtotal.toLocaleString('id-ID')}</span>
              </div>
            `;
          });
          cartContainer.innerHTML = cartHtml;
        } else {
          cartContainer.innerHTML = `
            <div class="flex items-center justify-between py-2 px-3 bg-surface-container-lowest rounded-lg">
              <div>
                <p class="font-semibold text-on-surface text-sm">${data.nama_produk}</p>
                <p class="text-[10px] text-on-surface-variant">${data.unit} unit</p>
              </div>
              <span class="font-semibold text-on-surface text-sm">${data.total_harga_formatted}</span>
            </div>
          `;
        }

        // Pricing
        document.getElementById('modal-total').textContent = data.total_harga_formatted;
        document.getElementById('modal-komisi').textContent = '- ' + data.komisi_admin_formatted;
        document.getElementById('modal-bersih').textContent = data.pendapatan_bersih_formatted;

        // Bukti pembayaran
        const buktiWrap = document.getElementById('modal-bukti-wrap');
        if (data.bukti_pembayaran) {
          buktiWrap.classList.remove('hidden');
          document.getElementById('modal-bukti-img').src = data.bukti_pembayaran;
          document.getElementById('modal-bukti-link').href = data.bukti_pembayaran;
        } else {
          buktiWrap.classList.add('hidden');
        }

        // Alasan tolak
        const tolakWrap = document.getElementById('modal-tolak-wrap');
        if (data.alasan_tolak) {
          tolakWrap.classList.remove('hidden');
          document.getElementById('modal-alasan-tolak').textContent = data.alasan_tolak;
        } else {
          tolakWrap.classList.add('hidden');
        }

        // Show content
        loading.classList.add('hidden');
        content.classList.remove('hidden');
      })
      .catch(err => {
        loading.innerHTML = `
          <span class="material-symbols-outlined text-3xl text-error">error</span>
          <p class="text-sm text-error mt-2">Gagal memuat detail pesanan</p>
          <p class="text-xs text-on-surface-variant mt-1">${err.message}</p>
        `;
      });
    }

    function closeOrderDetail() {
      document.getElementById('orderDetailModal').classList.add('hidden');
      document.body.style.overflow = '';
    }

    // Close on Escape key
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') closeOrderDetail();
    });

    function getStatusClass(status) {
      const map = {
        'Menunggu':  'bg-amber-100 text-amber-700 border border-amber-200',
        'Diterima':  'bg-blue-100 text-blue-700 border border-blue-200',
        'Diproses':  'bg-purple-100 text-purple-700 border border-purple-200',
        'Dikirim':   'bg-tertiary/10 text-tertiary border border-tertiary/20',
        'Selesai':   'bg-green-100 text-green-700 border border-green-200',
        'Dibatalkan':'bg-red-100 text-red-600 border border-red-200',
      };
      return map[status] || 'bg-surface-container text-on-surface-variant border border-outline-variant';
    }

    function getPaymentClass(status) {
      const map = {
        'Lunas':              'bg-green-50 text-green-600 border border-green-200/50',
        'Belum Dikonfirmasi': 'bg-amber-50 text-amber-600 border border-amber-200/50',
        'Dibatalkan':         'bg-red-50 text-red-500 border border-red-200/50',
      };
      return map[status] || 'bg-surface-container text-on-surface-variant border border-outline-variant/30';
    }
  </script>

</x-layout-store>