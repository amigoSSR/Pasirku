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
                    <form method="POST" action="{{ route('ordertrackingStore.updateStatus', $o->ID_Pesanan) }}">
                      @csrf @method('PUT')
                      <input type="hidden" name="status" value="{{ \App\Models\Pesanan::STATUS_SELESAI }}">
                      <button type="submit" class="px-2 py-1 text-[10px] font-bold bg-green-500 text-white rounded hover:opacity-90">Selesai</button>
                    </form>
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

</x-layout-store>