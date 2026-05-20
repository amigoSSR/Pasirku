<x-layout-store title="Dashboard Toko">

  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <span class="font-semibold text-primary">Dashboard</span>
    </nav>
    <div>
      <h1 class="font-headline text-3xl font-bold text-on-surface">Selamat datang, {{ Auth::user()->Username ?? 'Penjual' }} 👋</h1>
      <p class="text-on-surface-variant text-sm mt-1">Berikut ringkasan aktivitas toko Anda hari ini.</p>
    </div>
  </x-slot>

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
      {{-- Revenue Card --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 bg-primary/10 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">payments</span>
          </div>
        </div>
        <p id="stat-revenue" class="text-2xl font-headline font-bold text-on-surface">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium font-sans">Total Pendapatan</p>
      </div>

      {{-- Total Orders Card --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 bg-secondary/10 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-secondary" style="font-variation-settings:'FILL' 1">receipt_long</span>
          </div>
        </div>
        <p id="stat-orders" class="text-2xl font-headline font-bold text-on-surface">{{ number_format($totalPesanan, 0, ',', '.') }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium font-sans">Total Pesanan</p>
      </div>

      {{-- Volume Card --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 bg-tertiary/10 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-tertiary" style="font-variation-settings:'FILL' 1">layers</span>
          </div>
        </div>
        <p id="stat-volume" class="text-2xl font-headline font-bold text-on-surface">{{ number_format($pasirTerjual, 0, ',', '.') }} m³</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium font-sans">Pasir Terjual</p>
      </div>

      {{-- Active Products Card --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 bg-amber-500/10 rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">storefront</span>
          </div>
        </div>
        <p id="stat-products" class="text-2xl font-headline font-bold text-on-surface">{{ number_format($produkAktif, 0, ',', '.') }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium font-sans">Produk Aktif</p>
      </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Sales Chart Card --}}
      <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Performa Penjualan</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">Pendapatan harian (7 hari terakhir)</p>
          </div>
        </div>

        {{-- Simple Bar Chart (CSS) --}}
        <div class="h-40 flex items-end gap-3 mt-4">
          @php
          $maxVal = max($chartValues) ?: 1;
          @endphp
          @foreach($chartValues as $i => $val)
          @php
          $pct = ($val / $maxVal) * 100;
          $pct = $pct > 0 ? max($pct, 8) : 0;
          $dayLabel = $chartLabels[$i];
          @endphp
          <div class="flex-1 flex flex-col items-center gap-2 group">
            <div class="w-full rounded-t-lg transition-all duration-300 group-hover:opacity-80 cursor-pointer relative" 
                 style="height: {{ $pct }}%; background: {{ $i === 6 ? '#944a00' : '#ffdcc5' }};"
                 title="Rp {{ number_format($val, 0, ',', '.') }}">
            </div>
            <span class="text-[10px] font-bold text-on-surface-variant font-sans">{{ $dayLabel }}</span>
          </div>
          @endforeach
        </div>
        <div class="flex items-center gap-4 mt-4">
          <span class="flex items-center gap-1.5 text-xs text-on-surface-variant font-medium"><span class="w-3 h-3 rounded-full bg-[#944a00] inline-block"></span>Hari ini</span>
          <span class="flex items-center gap-1.5 text-xs text-on-surface-variant font-medium"><span class="w-3 h-3 rounded-full bg-[#ffdcc5] inline-block"></span>Hari sebelumnya</span>
        </div>
      </div>

      {{-- Quick Actions + Recent Activity --}}
      <div class="space-y-5">
        {{-- Quick Actions --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5">
          <h3 class="font-headline font-bold text-base text-on-surface mb-4">Aksi Cepat</h3>
          <div class="space-y-2">
            @php
            $actions = [
              ['icon'=>'add_box','label'=>'Tambah Produk Baru','color'=>'text-primary bg-primary/10','href'=>route('tambahProduk')],
              ['icon'=>'local_shipping','label'=>'Kelola Pesanan','color'=>'text-secondary bg-secondary/10','href'=>route('ordertrackingStore')],
              ['icon'=>'group','label'=>'Monitoring Pelanggan','color'=>'text-tertiary bg-tertiary/10','href'=>route('MonitoringPelangganStore')],
              ['icon'=>'forum','label'=>'Buka Pesan Masuk','color'=>'text-amber-600 bg-amber-500/10','href'=>route('PesanStore')],
            ];
            @endphp
            @foreach($actions as $a)
            <a href="{{ $a['href'] }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface text-sm font-semibold hover:bg-surface-container-low transition-colors text-left font-sans">
              <span class="w-8 h-8 {{ $a['color'] }} rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">{{ $a['icon'] }}</span>
              </span>
              {{ $a['label'] }}
              @if($a['icon'] === 'forum' && $unreadChatCount > 0)
                <span class="ml-auto bg-error text-on-error text-2xs font-bold w-5 h-5 rounded-full flex items-center justify-center shrink-0">
                  {{ $unreadChatCount }}
                </span>
              @endif
            </a>
            @endforeach
          </div>
        </div>

        {{-- Recent Orders Mini --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5">
          <div class="flex justify-between items-center mb-4">
            <h3 class="font-headline font-bold text-base text-on-surface">Pesanan Baru</h3>
            <a href="{{ route('ordertrackingStore') }}" class="text-primary text-xs font-semibold hover:underline font-sans">Lihat Semua</a>
          </div>
          <div id="recent-orders-list" class="space-y-3">
            @forelse($recentOrders as $order)
            @php
            $buyerName = $order->nama_pembeli ?: $order->Username;
            @endphp
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-sm shrink-0">
                {{ substr($buyerName, 0, 1) }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-on-surface truncate font-sans">{{ $buyerName }}</p>
                <p class="text-xs text-on-surface-variant font-sans">{{ $order->nama_produk ?? 'Pasir' }} • {{ $order->created_at->diffForHumans() }}</p>
              </div>
              <span class="text-xs font-bold px-2 py-1 rounded-lg {{ $order->Status_Pesanan === 'Belum Diterima Toko' ? 'bg-amber-50 text-amber-700' : 'bg-surface-container-high text-on-surface-variant' }} shrink-0 font-sans">
                {{ $order->Status_Pesanan === 'Belum Diterima Toko' ? 'Baru' : $order->statusLabel() }}
              </span>
            </div>
            @empty
            <div class="text-center py-6 text-on-surface-variant text-xs font-medium font-sans">
              Belum ada pesanan masuk.
            </div>
            @endforelse
          </div>
        </div>
      </div>

    </div>

    {{-- Bottom Grid: Top Products + Store Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      {{-- Top Products --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <h2 class="font-headline font-bold text-xl text-on-surface mb-5">Produk Terlaris</h2>
        <div id="top-products-list" class="space-y-4">
          @php
          $topMax = $topProducts->first()->total_sold ?? 1;
          $colors = ['bg-primary', 'bg-secondary', 'bg-tertiary', 'bg-amber-500'];
          @endphp
          @forelse($topProducts as $idx => $p)
          @php
          $pct = ($p->total_sold / $topMax) * 100;
          $color = $colors[$idx % 4];
          @endphp
          <div class="flex items-center gap-4">
            <span class="text-xs font-bold text-on-surface-variant w-4 shrink-0 font-sans">{{ $idx + 1 }}</span>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-center mb-1.5">
                <span class="text-sm font-semibold text-on-surface truncate font-sans">{{ $p->nama_produk }}</span>
                <span class="text-xs font-bold text-on-surface-variant shrink-0 ml-2 font-sans">{{ $p->total_sold }} m³</span>
              </div>
              <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
                <div class="{{ $color }} h-full rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
              </div>
            </div>
          </div>
          @empty
          <div class="text-center py-10 text-on-surface-variant text-xs font-medium font-sans">
            Belum ada data penjualan produk.
          </div>
          @endforelse
        </div>
      </div>

      {{-- Store Health --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <h2 class="font-headline font-bold text-xl text-on-surface mb-5">Kesehatan Toko</h2>
        <div class="space-y-4">
          {{-- Rating --}}
          <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50 border border-transparent">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-amber-500" style="font-variation-settings:'FILL' 1">star</span>
              <span class="text-sm font-semibold text-on-surface font-sans">Rating Toko</span>
            </div>
            <span class="text-sm font-bold text-amber-500 font-sans">4.9/5</span>
          </div>

          {{-- Tingkat Respon --}}
          <div class="flex items-center justify-between p-3 rounded-xl bg-green-50 border border-transparent">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">reply</span>
              <span class="text-sm font-semibold text-on-surface font-sans">Tingkat Respon</span>
            </div>
            <span class="text-sm font-bold text-green-600 font-sans">98%</span>
          </div>

          {{-- Pesanan Selesai --}}
          <div class="flex items-center justify-between p-3 rounded-xl bg-tertiary/10 border border-transparent">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-tertiary" style="font-variation-settings:'FILL' 1">check_circle</span>
              <span class="text-sm font-semibold text-on-surface font-sans">Pesanan Selesai</span>
            </div>
            <span id="health-completed-pct" class="text-sm font-bold text-tertiary font-sans">{{ $completionRate }}%</span>
          </div>

          {{-- Komplain --}}
          <div class="flex items-center justify-between p-3 rounded-xl bg-error-container border border-transparent">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-error" style="font-variation-settings:'FILL' 1">report</span>
              <span class="text-sm font-semibold text-on-surface font-sans">Komplain / Dibatalkan</span>
            </div>
            <span id="health-complaints" class="text-sm font-bold text-error font-sans">{{ $complaintsCount }} kasus</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- AJAX Polling Script --}}
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const revenueEl = document.getElementById('stat-revenue');
      const ordersEl = document.getElementById('stat-orders');
      const volumeEl = document.getElementById('stat-volume');
      const productsEl = document.getElementById('stat-products');
      const recentOrdersEl = document.getElementById('recent-orders-list');
      const topProductsEl = document.getElementById('top-products-list');

      function fetchDashboardStats() {
          fetch("{{ route('store.dashboard.stats') }}", {
              headers: {
                  'X-Requested-With': 'XMLHttpRequest'
              }
          })
          .then(response => {
              if (!response.ok) throw new Error('Network response was not ok');
              return response.json();
          })
          .then(data => {
              // Update stats cards
              if (revenueEl) revenueEl.textContent = data.total_pendapatan;
              if (ordersEl) ordersEl.textContent = data.total_pesanan;
              if (volumeEl) volumeEl.textContent = data.pasir_terjual;
              if (productsEl) productsEl.textContent = data.produk_aktif;

              // Update recent orders
              if (recentOrdersEl && data.recent_orders) {
                  if (data.recent_orders.length === 0) {
                      recentOrdersEl.innerHTML = `
                          <div class="text-center py-6 text-on-surface-variant text-xs font-medium font-sans">
                              Belum ada pesanan masuk.
                          </div>
                      `;
                  } else {
                      let html = '';
                      data.recent_orders.forEach(order => {
                          const firstChar = order.buyer.charAt(0);
                          const isNew = order.status_class === 'Baru';
                          const badgeClass = isNew 
                              ? 'bg-amber-50 text-amber-700' 
                              : 'bg-surface-container-high text-on-surface-variant';
                          
                          html += `
                              <div class="flex items-center gap-3">
                                  <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-sm shrink-0 font-sans">
                                      ${firstChar}
                                  </div>
                                  <div class="flex-1 min-w-0">
                                      <p class="text-sm font-semibold text-on-surface truncate font-sans">${order.buyer}</p>
                                      <p class="text-xs text-on-surface-variant font-sans">${order.product} • ${order.time}</p>
                                  </div>
                                  <span class="text-xs font-bold px-2 py-1 rounded-lg ${badgeClass} shrink-0 font-sans">
                                      ${order.status}
                                  </span>
                              </div>
                          `;
                      });
                      recentOrdersEl.innerHTML = html;
                  }
              }

              // Update top products
              if (topProductsEl && data.top_products) {
                  if (data.top_products.length === 0) {
                      topProductsEl.innerHTML = `
                          <div class="text-center py-10 text-on-surface-variant text-xs font-medium font-sans">
                              Belum ada data penjualan produk.
                          </div>
                      `;
                  } else {
                      const topMax = data.top_products[0].total_sold || 1;
                      const colors = ['bg-primary', 'bg-secondary', 'bg-tertiary', 'bg-amber-500'];
                      let html = '';
                      data.top_products.forEach((p, idx) => {
                          const pct = (p.total_sold / topMax) * 100;
                          const color = colors[idx % 4];
                          html += `
                              <div class="flex items-center gap-4">
                                  <span class="text-xs font-bold text-on-surface-variant w-4 shrink-0 font-sans">${idx + 1}</span>
                                  <div class="flex-1 min-w-0">
                                      <div class="flex justify-between items-center mb-1.5">
                                          <span class="text-sm font-semibold text-on-surface truncate font-sans">${p.nama_produk}</span>
                                          <span class="text-xs font-bold text-on-surface-variant shrink-0 ml-2 font-sans">${p.total_sold} m³</span>
                                      </div>
                                      <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
                                          <div class="${color} h-full rounded-full transition-all duration-700" style="width: ${pct}%"></div>
                                      </div>
                                  </div>
                              </div>
                          `;
                      });
                      topProductsEl.innerHTML = html;
                  }
              }
          })
          .catch(err => console.error('Error fetching realtime stats:', err));
      }

      // Poll every 30 seconds
      setInterval(fetchDashboardStats, 30000);
  });
  </script>

</x-layout-store>