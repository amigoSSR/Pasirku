<x-layout-admin title="Pantau Toko (Query)">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="text-xs font-black text-primary uppercase tracking-[0.2em] flex items-center gap-1.5 mb-1">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">monitoring</span>
          Manajemen Platform
        </span>
        <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Query Toko</h1>
        <p class="text-sm text-on-surface-variant mt-1">Pantau performa dan riwayat transaksi mendalam pada tiap toko.</p>
      </div>
      <a href="{{ route('MenuUtamaAdmin') }}" class="text-sm font-bold text-on-surface-variant hover:text-primary flex items-center gap-1 transition-colors">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Dashboard
      </a>
    </div>

    {{-- Store Selector Section --}}
    <section class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 p-6 md:p-8">
      <div class="flex flex-col md:flex-row items-start md:items-end gap-6">
        
        {{-- Custom Searchable Dropdown (Alpine.js) --}}
        <div class="flex-1 w-full space-y-2" x-data="{
          open: false,
          search: '',
          stores: {{ json_encode($tokoList->map(fn($t) => [
            'id' => $t->ID_Toko,
            'name' => $t->Nama_Toko,
            'username' => $t->Username,
            'photo' => $t->Foto_Toko ? asset('storage/'.$t->Foto_Toko) : null
          ])) }},
          get filteredStores() {
            return this.stores.filter(s => 
              s.name.toLowerCase().includes(this.search.toLowerCase()) || 
              s.username.toLowerCase().includes(this.search.toLowerCase())
            );
          }
        }">
          <label class="text-xs font-bold text-on-surface-variant uppercase tracking-widest px-1">Cari & Pilih Toko untuk Dipantau</label>
          
          <div class="relative">
            {{-- Trigger Button --}}
            <button @click="open = !open" type="button" 
              class="w-full bg-surface-container-low border border-outline-variant/20 rounded-2xl pl-12 pr-10 py-4 text-left text-sm font-bold text-on-surface focus:ring-4 focus:ring-primary/10 transition-all flex items-center justify-between">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant" :class="open && 'text-primary'">storefront</span>
              <span x-text="'{{ $selectedToko ? $selectedToko->Nama_Toko : '-- Pilih Toko --' }}'"></span>
              <span class="material-symbols-outlined text-on-surface-variant transition-transform" :class="open && 'rotate-180'">expand_more</span>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open" @click.away="open = false" x-cloak
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 translate-y-2 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              class="absolute top-full left-0 right-0 z-[100] mt-2 bg-surface-container-lowest border border-outline-variant/30 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[400px]">
              
              {{-- Search Box inside dropdown --}}
              <div class="p-3 bg-surface-container-low/50 border-b border-outline-variant/20">
                <div class="relative">
                  <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                  <input type="text" x-model="search" @click.stop 
                    placeholder="Ketik nama atau username toko..."
                    class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-xl pl-10 pr-4 py-2 text-xs focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" />
                </div>
              </div>

              {{-- List of stores --}}
              <div class="overflow-y-auto">
                <template x-for="t in filteredStores" :key="t.id">
                  <div @click="window.location.href = '{{ route('admin.queryToko') }}?toko_id=' + t.id"
                    class="px-4 py-3 hover:bg-primary/5 cursor-pointer border-b border-outline-variant/10 flex items-center gap-4 transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-primary/5 border border-primary/10 overflow-hidden flex items-center justify-center shrink-0">
                      <template x-if="t.photo">
                        <img :src="t.photo" class="w-full h-full object-cover" />
                      </template>
                      <template x-if="!t.photo">
                        <span class="material-symbols-outlined text-primary/40 text-[20px]">storefront</span>
                      </template>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="font-bold text-on-surface text-sm leading-tight" x-text="t.name"></p>
                      <p class="text-[10px] text-on-surface-variant mt-0.5" x-text="'@' + t.username"></p>
                    </div>
                    <span class="material-symbols-outlined text-primary opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                  </div>
                </template>
                <div x-show="filteredStores.length === 0" class="p-10 text-center text-on-surface-variant text-xs font-medium">
                  Toko tidak ditemukan...
                </div>
              </div>
            </div>
          </div>
        </div>

        @if($selectedToko)
          <div onclick='window.dispatchEvent(new CustomEvent("open-store-edit-modal", { detail: { toko: @json($selectedToko) } }))'
            class="w-full md:w-auto flex items-center gap-4 bg-primary/5 p-2 pr-6 rounded-2xl border border-primary/10 animate-fadeUp cursor-pointer hover:bg-primary/10 transition-all group/card">
            <div class="w-14 h-14 rounded-xl overflow-hidden bg-primary/10 flex items-center justify-center shrink-0 group-hover/card:scale-105 transition-transform">
              @if($selectedToko->Foto_Toko)
                <img src="{{ asset('storage/' . $selectedToko->Foto_Toko) }}" class="w-full h-full object-cover" alt="Foto Toko">
              @else
                <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings:'FILL' 1">storefront</span>
              @endif
            </div>
            <div>
              <p class="text-[10px] font-black text-primary uppercase tracking-widest flex items-center gap-1">
                Toko Terpilih 
                <span class="material-symbols-outlined text-[12px] opacity-0 group-hover/card:opacity-100 transition-opacity">edit_location</span>
              </p>
              <p class="text-base font-bold text-on-surface leading-tight group-hover/card:text-primary transition-colors">{{ $selectedToko->Nama_Toko }}</p>
              <p class="text-[10px] text-on-surface-variant font-medium mt-0.5">{{ $selectedToko->Email_Toko }} • {{ $selectedToko->Nomer_Telepon_Toko }}</p>
            </div>
          </div>
        @endif
      </div>
    </section>

    @if($selectedToko)
      {{-- Stats Grid --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30 shadow-sm flex items-center gap-5 group hover:border-primary/30 transition-all">
          <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">receipt_long</span>
          </div>
          <div>
            <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Total Transaksi</p>
            <p class="text-2xl font-headline font-black text-on-surface">{{ number_format($stats['total_orders']) }}</p>
          </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30 shadow-sm flex items-center gap-5 group hover:border-green-600/30 transition-all">
          <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">payments</span>
          </div>
          <div>
            <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Total Perputaran</p>
            <p class="text-2xl font-headline font-black text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
          </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30 shadow-sm flex items-center gap-5 group hover:border-amber-600/30 transition-all">
          <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">inventory_2</span>
          </div>
          <div>
            <p class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest">Volume Terjual (Selesai)</p>
            <p class="text-2xl font-headline font-black text-amber-600">{{ number_format($stats['total_units']) }} m³</p>
          </div>
        </div>
      </div>

      {{-- Order History Table --}}
      <div class="bg-surface-container-lowest rounded-3xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="px-8 py-6 border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-low/30">
          <div>
            <h2 class="font-headline font-bold text-on-surface text-lg">Riwayat Pesanan</h2>
            <p class="text-xs text-on-surface-variant">Daftar semua pesanan yang masuk ke toko ini.</p>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="bg-surface-container-low/50 border-b border-outline-variant/20">
                <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-on-surface-variant">ID & Tanggal</th>
                <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-on-surface-variant">Pembeli</th>
                <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-on-surface-variant">Produk</th>
                <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-on-surface-variant text-right">Total Harga</th>
                <th class="px-8 py-4 text-xs font-black uppercase tracking-widest text-on-surface-variant text-center">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
              @forelse($orders as $order)
                <tr class="hover:bg-primary/5 transition-colors">
                  <td class="px-8 py-5">
                    <p class="font-bold text-on-surface">#{{ $order->ID_Pesanan }}</p>
                    <p class="text-[10px] text-on-surface-variant font-medium mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                  </td>
                  <td class="px-8 py-5">
                    <p class="font-bold text-on-surface">{{ $order->nama_pembeli ?? $order->Username }}</p>
                    <p class="text-[10px] text-on-surface-variant font-medium">{{ $order->Nomer_Telepon }}</p>
                  </td>
                  <td class="px-8 py-5">
                    <p class="font-bold text-on-surface text-xs">{{ $order->nama_produk }}</p>
                    <p class="text-[10px] text-on-surface-variant font-medium mt-0.5">{{ $order->Unit }} m³ • {{ ucfirst($order->tipe_pengiriman) }}</p>
                  </td>
                  <td class="px-8 py-5 text-right font-black text-on-surface">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                  </td>
                  <td class="px-8 py-5">
                    <div class="flex justify-center">
                      @php
                        $statusClasses = [
                          'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                          'Belum Diterima Toko' => 'bg-amber-50 text-amber-700 border-amber-200',
                          'Diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                          'Dikirim' => 'bg-purple-50 text-purple-700 border-purple-200',
                          'Dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                        ];
                        $class = $statusClasses[$order->Status_Pesanan] ?? 'bg-surface-container-highest text-on-surface-variant border-outline-variant';
                      @endphp
                      <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $class }}">
                        {{ $order->Status_Pesanan }}
                      </span>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-8 py-20 text-center">
                    <div class="flex flex-col items-center">
                      <span class="material-symbols-outlined text-5xl text-outline/30 mb-3">receipt_long</span>
                      <p class="text-on-surface-variant font-bold">Belum ada pesanan terdaftar di toko ini.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if($orders->hasPages())
          <div class="px-8 py-6 bg-surface-container-low/20 border-t border-outline-variant/10">
            {{ $orders->appends(['toko_id' => $selectedToko->ID_Toko])->links() }}
          </div>
        @endif
      </div>
    @else
      <div class="bg-surface-container-lowest p-20 rounded-3xl border-2 border-dashed border-outline-variant/50 text-center flex flex-col items-center justify-center">
        <div class="w-24 h-24 bg-surface-container rounded-full flex items-center justify-center mb-6">
          <span class="material-symbols-outlined text-5xl text-outline/50">storefront</span>
        </div>
        <h3 class="font-headline text-2xl font-black text-on-surface mb-2">Pilih Toko untuk Dipantau</h3>
        <p class="text-on-surface-variant max-w-sm text-sm">Gunakan menu dropdown di atas untuk memilih toko yang ingin Anda lihat riwayat transaksinya.</p>
      </div>
    @endif

  </div>

</x-layout-admin>