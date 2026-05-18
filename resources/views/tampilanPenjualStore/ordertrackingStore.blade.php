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
      @php
      $statuses = [
        ['label'=>'Semua Pesanan','value'=>'284','icon'=>'list_alt','color_bg'=>'bg-primary/10','color_text'=>'text-primary'],
        ['label'=>'Menunggu Konfirmasi','value'=>'12','icon'=>'pending','color_bg'=>'bg-amber-500/10','color_text'=>'text-amber-600'],
        ['label'=>'Dalam Pengiriman','value'=>'57','icon'=>'local_shipping','color_bg'=>'bg-tertiary/10','color_text'=>'text-tertiary'],
        ['label'=>'Selesai Hari Ini','value'=>'8','icon'=>'check_circle','color_bg'=>'bg-green-100','color_text'=>'text-green-600'],
      ];
      @endphp
      @foreach($statuses as $s)
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="w-11 h-11 {{ $s['color_bg'] }} rounded-xl flex items-center justify-center mb-3">
          <span class="material-symbols-outlined {{ $s['color_text'] }}" style="font-variation-settings:'FILL' 1">{{ $s['icon'] }}</span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $s['value'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">{{ $s['label'] }}</p>
      </div>
      @endforeach
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
            <button class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $tab === 'Semua' ? 'bg-surface-container-lowest shadow-sm text-on-surface' : 'text-on-surface-variant hover:text-on-surface' }}">
              {{ $tab }}
            </button>
            @endforeach
          </div>
          {{-- Search --}}
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
            <input type="text" placeholder="Cari pesanan..." class="pl-9 pr-4 py-2 text-sm border border-outline-variant rounded-xl bg-surface-container-low focus:ring-2 focus:ring-primary/20 focus:outline-none w-52 transition-all"/>
          </div>
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
            @php
            $orders = [
              ['id'=>'#ORD-1042','customer'=>'Budi Santoso','product'=>'Pasir Cor 5m³','total'=>'Rp 350.000','status'=>'Baru','date'=>'14 Mei 2025','status_color'=>'bg-amber-50 text-amber-700'],
              ['id'=>'#ORD-1041','customer'=>'Siti Rahayu','product'=>'Batu Split 3m³','total'=>'Rp 270.000','status'=>'Pengiriman','date'=>'14 Mei 2025','status_color'=>'bg-blue-50 text-blue-700'],
              ['id'=>'#ORD-1040','customer'=>'Dewi Lestari','product'=>'Pasir Halus 2m³','total'=>'Rp 180.000','status'=>'Selesai','date'=>'13 Mei 2025','status_color'=>'bg-green-50 text-green-700'],
              ['id'=>'#ORD-1039','customer'=>'Ahmad Fauzi','product'=>'Batu Kali 4m³','total'=>'Rp 420.000','status'=>'Dibatalkan','date'=>'13 Mei 2025','status_color'=>'bg-red-50 text-red-600'],
              ['id'=>'#ORD-1038','customer'=>'Rizky Pratama','product'=>'Pasir Cor 8m³','total'=>'Rp 560.000','status'=>'Proses','date'=>'12 Mei 2025','status_color'=>'bg-purple-50 text-purple-700'],
            ];
            @endphp
            @foreach($orders as $o)
            <tr class="hover:bg-surface-container-low/60 transition-colors cursor-pointer">
              <td class="px-5 py-4 font-mono text-xs font-semibold text-on-surface-variant">{{ $o['id'] }}</td>
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container font-bold text-sm flex items-center justify-center shrink-0">{{ substr($o['customer'], 0, 1) }}</div>
                  <span class="font-semibold text-on-surface">{{ $o['customer'] }}</span>
                </div>
              </td>
              <td class="px-5 py-4 text-on-surface-variant">{{ $o['product'] }}</td>
              <td class="px-5 py-4 font-semibold text-primary">{{ $o['total'] }}</td>
              <td class="px-5 py-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $o['status_color'] }}">{{ $o['status'] }}</span>
              </td>
              <td class="px-5 py-4 text-xs text-on-surface-variant">{{ $o['date'] }}</td>
              <td class="px-5 py-4 text-right">
                <div class="flex gap-1 justify-end">
                  <button class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-lg transition-colors" title="Lihat Detail">
                    <span class="material-symbols-outlined text-lg">open_in_new</span>
                  </button>
                  <button class="p-1.5 text-on-surface-variant hover:text-secondary hover:bg-secondary/10 rounded-lg transition-colors" title="Update Status">
                    <span class="material-symbols-outlined text-lg">edit</span>
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="px-5 py-4 border-t border-outline-variant/20 flex items-center justify-between text-sm">
        <span class="text-on-surface-variant">Menampilkan 1–5 dari 284 pesanan</span>
        <div class="flex gap-1">
          <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant disabled:opacity-40" disabled>
            <span class="material-symbols-outlined text-sm">chevron_left</span>
          </button>
          <button class="px-3 py-1.5 rounded-lg bg-primary text-on-primary font-semibold">1</button>
          <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">2</button>
          <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">3</button>
          <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
          </button>
        </div>
      </div>
    </div>

  </div>

</x-layout-store>