<x-layout-user title="Dashboard">

  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <span class="font-semibold text-primary">Dashboard</span>
    </nav>
    <div>
      <h1 class="font-headline text-3xl font-bold text-on-surface">Selamat datang, {{ Auth::user()->Username ?? 'Pelanggan' }} 👋</h1>
      <p class="text-on-surface-variant text-sm mt-1">Temukan material konstruksi terbaik di dekat Anda.</p>
    </div>
  </x-slot>

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
      @php
        $stats = [
          ['icon'=>'shopping_cart','color_bg'=>'bg-primary/10','color_text'=>'text-primary','label'=>'Total Pesanan','value'=>'12','trend'=>'+2','up'=>true],
          ['icon'=>'local_shipping','color_bg'=>'bg-secondary/10','color_text'=>'text-secondary','label'=>'Dalam Pengiriman','value'=>'3','trend'=>'Aktif','up'=>true],
          ['icon'=>'check_circle','color_bg'=>'bg-tertiary/10','color_text'=>'text-tertiary','label'=>'Selesai','value'=>'8','trend'=>'+1','up'=>true],
          ['icon'=>'storefront','color_bg'=>'bg-amber-500/10','color_text'=>'text-amber-600','label'=>'Toko Favorit','value'=>'5','trend'=>'Stabil','up'=>true],
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

      {{-- Quick Actions --}}
      <div class="space-y-5">
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5">
          <h3 class="font-headline font-bold text-base text-on-surface mb-4">Aksi Cepat</h3>
          <div class="space-y-2">
            @php
              $actions = [
                ['icon'=>'storefront','label'=>'Cari Toko Pasir','color'=>'text-primary bg-primary/10','href'=>route('MenuUtama')],
                ['icon'=>'local_shipping','label'=>'Lacak Pesanan','color'=>'text-secondary bg-secondary/10','href'=>route('ordertracking')],
                ['icon'=>'forum','label'=>'Buka Pesan','color'=>'text-tertiary bg-tertiary/10','href'=>route('Pesan')],
                ['icon'=>'person','label'=>'Profil Saya','color'=>'text-amber-600 bg-amber-500/10','href'=>route('Profil')],
              ];
            @endphp
            @foreach($actions as $a)
            <a href="{{ $a['href'] }}" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface text-sm font-semibold hover:bg-surface-container-low transition-colors">
              <span class="w-8 h-8 {{ $a['color'] }} rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">{{ $a['icon'] }}</span>
              </span>
              {{ $a['label'] }}
            </a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Recent Orders --}}
      <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <div class="flex items-center justify-between mb-5">
          <h3 class="font-headline font-bold text-lg text-on-surface">Pesanan Terbaru</h3>
          <a href="{{ route('ordertracking') }}" class="text-primary text-xs font-semibold hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-3">
          @foreach(['Pasir Cor Premium','Batu Split 1-2','Pasir Halus Putih'] as $i => $item)
          <div class="flex items-center justify-between p-4 bg-surface-container-low rounded-xl border border-outline-variant/20">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[20px] text-primary" style="font-variation-settings:'FILL' 1">landscape</span>
              </div>
              <div>
                <p class="text-sm font-bold text-on-surface">{{ $item }}</p>
                <p class="text-xs text-on-surface-variant">{{ $i + 1 }} hari lalu · Pick Up</p>
              </div>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full
              {{ $i === 0 ? 'bg-tertiary/10 text-tertiary' : ($i === 1 ? 'bg-primary/10 text-primary' : 'bg-green-50 text-green-600') }}">
              {{ $i === 0 ? 'Dikirim' : ($i === 1 ? 'Diproses' : 'Selesai') }}
            </span>
          </div>
          @endforeach
        </div>
      </div>

    </div>

  </div>

</x-layout-user>
