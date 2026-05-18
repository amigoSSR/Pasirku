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
      @php
      $stats = [
        ['icon'=>'payments','color_bg'=>'bg-primary/10','color_text'=>'text-primary','label'=>'Total Pendapatan','value'=>'Rp 420jt','trend'=>'+8%','up'=>true],
        ['icon'=>'receipt_long','color_bg'=>'bg-secondary/10','color_text'=>'text-secondary','label'=>'Total Pesanan','value'=>'1.284','trend'=>'+12%','up'=>true],
        ['icon'=>'layers','color_bg'=>'bg-tertiary/10','color_text'=>'text-tertiary','label'=>'Pasir Terjual','value'=>'8.4k m³','trend'=>'-2%','up'=>false],
        ['icon'=>'storefront','color_bg'=>'bg-amber-500/10','color_text'=>'text-amber-600','label'=>'Produk Aktif','value'=>'47','trend'=>'Stabil','up'=>true],
      ];
      @endphp
      @foreach($stats as $s)
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 {{ $s['color_bg'] }} rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined {{ $s['color_text'] }}" style="font-variation-settings:'FILL' 1">{{ $s['icon'] }}</span>
          </div>
          <span class="text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5 {{ $s['up'] ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }}">
            <span class="material-symbols-outlined text-xs">{{ $s['up'] ? 'trending_up' : 'trending_down' }}</span>{{ $s['trend'] }}
          </span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $s['value'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">{{ $s['label'] }}</p>
      </div>
      @endforeach
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Sales Chart Card --}}
      <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h2 class="font-headline font-bold text-xl text-on-surface">Performa Penjualan</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">7 hari terakhir</p>
          </div>
          <div class="flex gap-2">
            <button class="px-3 py-1.5 text-xs font-semibold bg-primary text-on-primary rounded-lg">7H</button>
            <button class="px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">30H</button>
            <button class="px-3 py-1.5 text-xs font-semibold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">3B</button>
          </div>
        </div>

        {{-- Simple Bar Chart (CSS) --}}
        <div class="h-40 flex items-end gap-3 mt-4">
          @php $bars = [60,75,45,90,65,80,100]; $days=['Sen','Sel','Rab','Kam','Jum','Sab','Min']; @endphp
          @foreach($bars as $i => $h)
          <div class="flex-1 flex flex-col items-center gap-2 group">
            <div class="w-full rounded-t-lg transition-all duration-300 group-hover:opacity-80 cursor-pointer relative" 
                 style="height: {{ $h }}%; background: {{ $i === 6 ? '#944a00' : '#ffdcc5' }};"
                 title="{{ $h }}k m³">
            </div>
            <span class="text-[10px] font-bold text-on-surface-variant">{{ $days[$i] }}</span>
          </div>
          @endforeach
        </div>
        <div class="flex items-center gap-4 mt-4">
          <span class="flex items-center gap-1.5 text-xs text-on-surface-variant"><span class="w-3 h-3 rounded-full bg-primary inline-block"></span>Hari ini</span>
          <span class="flex items-center gap-1.5 text-xs text-on-surface-variant"><span class="w-3 h-3 rounded-full bg-primary-fixed inline-block"></span>Periode lalu</span>
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
            <a href="{{ $a['href'] }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface text-sm font-semibold hover:bg-surface-container-low transition-colors text-left">
              <span class="w-8 h-8 {{ $a['color'] }} rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">{{ $a['icon'] }}</span>
              </span>
              {{ $a['label'] }}
            </a>
            @endforeach
          </div>
        </div>

        {{-- Recent Orders Mini --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5">
          <div class="flex justify-between items-center mb-4">
            <h3 class="font-headline font-bold text-base text-on-surface">Pesanan Baru</h3>
            <a href="{{ route('ordertrackingStore') }}" class="text-primary text-xs font-semibold hover:underline">Lihat Semua</a>
          </div>
          <div class="space-y-3">
            @foreach(['Budi S.','Siti R.','Ahmad F.'] as $i => $name)
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-sm shrink-0">{{ substr($name, 0, 1) }}</div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-on-surface truncate">{{ $name }}</p>
                <p class="text-xs text-on-surface-variant">Pasir Cor • {{ $i + 1 }} jam lalu</p>
              </div>
              <span class="text-xs font-bold px-2 py-1 rounded-lg bg-amber-50 text-amber-700 shrink-0">Baru</span>
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>

    {{-- Bottom Grid: Top Products + Store Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      {{-- Top Products --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <h2 class="font-headline font-bold text-xl text-on-surface mb-5">Produk Terlaris</h2>
        <div class="space-y-4">
          @php
          $products = [
            ['name'=>'Pasir Cor Premium','sold'=>'1.2k m³','pct'=>85,'color'=>'bg-primary'],
            ['name'=>'Batu Split 1-2','sold'=>'980 m³','pct'=>68,'color'=>'bg-secondary'],
            ['name'=>'Pasir Halus Putih','sold'=>'720 m³','pct'=>52,'color'=>'bg-tertiary'],
            ['name'=>'Batu Kali Besar','sold'=>'340 m³','pct'=>28,'color'=>'bg-amber-500'],
          ];
          @endphp
          @foreach($products as $idx => $p)
          <div class="flex items-center gap-4">
            <span class="text-xs font-bold text-on-surface-variant w-4 shrink-0">{{ $idx + 1 }}</span>
            <div class="flex-1 min-w-0">
              <div class="flex justify-between items-center mb-1.5">
                <span class="text-sm font-semibold text-on-surface truncate">{{ $p['name'] }}</span>
                <span class="text-xs font-bold text-on-surface-variant shrink-0 ml-2">{{ $p['sold'] }}</span>
              </div>
              <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
                <div class="{{ $p['color'] }} h-full rounded-full transition-all duration-700" style="width: {{ $p['pct'] }}%"></div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Store Health --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <h2 class="font-headline font-bold text-xl text-on-surface mb-5">Kesehatan Toko</h2>
        <div class="space-y-4">
          @php
          $metrics = [
            ['label'=>'Rating Toko','value'=>'4.9/5','icon'=>'star','color'=>'text-amber-500','bg'=>'bg-amber-50'],
            ['label'=>'Tingkat Respon','value'=>'98%','icon'=>'reply','color'=>'text-green-600','bg'=>'bg-green-50'],
            ['label'=>'Pesanan Selesai','value'=>'96%','icon'=>'check_circle','color'=>'text-tertiary','bg'=>'bg-tertiary/10'],
            ['label'=>'Komplain','value'=>'2 kasus','icon'=>'report','color'=>'text-error','bg'=>'bg-error-container'],
          ];
          @endphp
          @foreach($metrics as $m)
          <div class="flex items-center justify-between p-3 rounded-xl {{ $m['bg'] }} border border-transparent">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined {{ $m['color'] }}" style="font-variation-settings:'FILL' 1">{{ $m['icon'] }}</span>
              <span class="text-sm font-semibold text-on-surface">{{ $m['label'] }}</span>
            </div>
            <span class="text-sm font-bold {{ $m['color'] }}">{{ $m['value'] }}</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>

</x-layout-store>