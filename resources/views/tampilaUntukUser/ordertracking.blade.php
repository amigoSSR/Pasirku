<x-layout-user title="Lacak Pesanan">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-6">

    {{-- Page Header --}}
    <div>
      <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-1">
        <a href="{{ route('MenuUtama') }}" class="hover:text-primary transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="font-semibold text-primary">Pesanan Saya</span>
      </nav>
      <h1 class="font-headline text-2xl font-bold text-on-surface">Pesanan Saya</h1>
      <p class="text-sm text-on-surface-variant mt-1">Pantau status pesanan dan pengiriman material Anda.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-green-50 text-green-800 rounded-xl border border-green-200 text-sm font-semibold">
      <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
      {{ session('success') }}
    </div>
    @endif

    {{-- Orders List --}}
    <div class="space-y-4">
      @forelse($orders as $o)
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5 lg:p-6 flex flex-col md:flex-row gap-6">
          
          {{-- Store Info & Products --}}
          <div class="flex-1 space-y-4">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center uppercase">
                  <span class="material-symbols-outlined">storefront</span>
                </div>
                <div>
                  <h3 class="font-bold text-on-surface">{{ $o->Nama_Toko }}</h3>
                  <p class="text-xs text-on-surface-variant">{{ $o->created_at->format('d M Y, H:i') }} • #ORD-{{ str_pad($o->ID_Pesanan, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
              </div>
              <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-[11px] uppercase font-black tracking-wider {{ $o->statusBadgeClass() }}">
                <span class="material-symbols-outlined text-[14px]">{{ $o->statusIcon() }}</span>
                {{ $o->statusLabel() }}
              </span>
            </div>

            <div class="bg-surface-container-low rounded-xl p-4 flex flex-col gap-2">
              <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Produk</p>
                <p class="text-sm font-semibold text-on-surface">{{ $o->nama_produk }}</p>
              </div>
              @if($o->Status_Pesanan === \App\Models\Pesanan::STATUS_DIBATALKAN && $o->alasan_tolak)
                <div class="bg-red-50 text-red-700 p-2 rounded text-xs">
                  <strong>Alasan Penolakan:</strong> {{ $o->alasan_tolak }}
                </div>
              @endif
              @if($o->Status_Pesanan === \App\Models\Pesanan::STATUS_DIKIRIM && $o->info_pengiriman)
                <div class="bg-tertiary/10 text-tertiary p-2 rounded text-xs flex items-center gap-2">
                  <span class="material-symbols-outlined text-[16px]">info</span>
                  <span>{{ $o->info_pengiriman }}</span>
                </div>
              @endif
            </div>
          </div>

          {{-- Order Details & Actions --}}
          <div class="md:w-[300px] shrink-0 border-t md:border-t-0 md:border-l border-outline-variant/30 pt-4 md:pt-0 md:pl-6 flex flex-col justify-between">
            <div class="space-y-3">
              <div class="flex justify-between items-center text-sm">
                <span class="text-on-surface-variant">Penerima</span>
                <span class="font-semibold text-on-surface">{{ $o->nama_pembeli ?? $o->Username }}</span>
              </div>
              <div class="flex justify-between items-center text-sm">
                <span class="text-on-surface-variant">Metode Kirim</span>
                <span class="font-semibold text-on-surface capitalize">{{ str_replace(',', ' & ', $o->tipe_pengiriman) }}</span>
              </div>
              <div class="flex justify-between items-center pt-3 border-t border-outline-variant/30">
                <span class="font-bold text-on-surface">Total Belanja</span>
                <span class="font-black text-primary text-lg">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</span>
              </div>
            </div>

            <div class="mt-6 flex flex-col gap-2">
              <a href="{{ route('Pesan') }}" class="w-full text-center bg-surface-container-low border border-outline-variant/50 text-on-surface px-4 py-2 rounded-xl text-sm font-bold hover:bg-surface-container transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">chat</span> Chat Toko
              </a>
              @if($o->Status_Pesanan === \App\Models\Pesanan::STATUS_PENDING)
                <p class="text-center text-[10px] text-on-surface-variant mt-1 italic">Menunggu konfirmasi penjual</p>
              @endif
            </div>
          </div>

        </div>
      @empty
        <div class="text-center py-20 bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm">
          <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4 block">receipt_long</span>
          <h3 class="font-headline font-bold text-lg text-on-surface">Belum ada pesanan</h3>
          <p class="text-on-surface-variant text-sm mt-1">Anda belum melakukan pembelian material apapun.</p>
          <a href="{{ route('MenuUtama') }}" class="inline-block mt-6 bg-primary text-on-primary px-6 py-2.5 rounded-full font-bold text-sm hover:opacity-90 transition-opacity">
            Mulai Belanja
          </a>
        </div>
      @endforelse
    </div>

  </div>

</x-layout-user>
