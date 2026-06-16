@forelse ($tokoList as $toko)
<div
  class="shop-card stat-card bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-outline-variant/30 cursor-pointer group hover:border-primary/30"
  data-shop-name="{{ strtolower($toko->Nama_Toko) }}"
  data-lat="{{ $toko->latitude }}"
  data-lng="{{ $toko->longitude }}">
  <div class="flex justify-between items-start mb-4">
    <div class="w-20 h-20 rounded-2xl bg-primary/10 flex items-center justify-center overflow-hidden shadow-sm border border-outline-variant/20">
      @if($toko->Foto_Toko)
        <img src="{{ asset('storage/' . $toko->Foto_Toko) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="{{ $toko->Nama_Toko }}">
      @else
        <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings:'FILL' 1">storefront</span>
      @endif
    </div>
    <div class="flex flex-col items-end gap-2">
        <span class="text-xs font-bold bg-green-50 text-green-600 px-3 py-1 rounded-full flex items-center gap-1">
          <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse inline-block"></span>
          Buka
        </span>
        @if(isset($toko->distance))
        <span class="text-[11px] font-bold bg-primary/10 text-primary px-3 py-1 rounded-full flex items-center gap-1">
          <span class="material-symbols-outlined text-[14px]">distance</span>
          {{ number_format($toko->distance, 1) }} km
        </span>
        @endif
    </div>
  </div>
  <h3 class="text-base font-headline font-bold text-on-surface mb-2 group-hover:text-primary transition-colors">
    {{ $toko->Nama_Toko }}
  </h3>
  
  {{-- Rating --}}
  <div class="flex items-center gap-1 mb-3">
    @php $rating = $toko->averageRating(); @endphp
    <div class="flex items-center text-yellow-500">
        @for($i = 1; $i <= 5; $i++)
            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' {{ $i <= $rating ? 1 : 0 }}">star</span>
        @endfor
    </div>
    <span class="text-xs font-bold text-on-surface-variant">{{ number_format($rating, 1) }}</span>
  </div>

  <div class="flex flex-col gap-1.5 text-sm text-on-surface-variant mb-4">
    <div class="flex items-start gap-1.5">
      <span class="material-symbols-outlined text-[16px] text-outline mt-0.5">location_on</span>
      <span class="line-clamp-2">{{ $toko->detail_alamat ?: $toko->Lokasi_Toko }}</span>
    </div>
  </div>
  
  <div class="flex gap-2 border-t border-outline-variant/30 pt-4 mt-1">
    <a href="{{ route('MarketPlace', $toko->ID_Toko) }}"
      class="flex-1 bg-primary text-on-primary py-2.5 rounded-xl font-bold text-xs hover:bg-primary-container transition-all flex items-center justify-center gap-2 shadow-sm">
      <span>Lihat Toko</span>
      <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
    </a>
    <a href="{{ route('chat.admin', ['toko_id' => $toko->ID_Toko]) }}"
      class="bg-surface-container-high text-on-surface-variant p-2.5 rounded-xl hover:bg-surface-container-highest transition-all flex items-center justify-center shadow-sm">
      <span class="material-symbols-outlined text-[20px]">chat</span>
    </a>
  </div>
</div>
@empty
<div class="col-span-full text-center py-16">
  <span class="material-symbols-outlined text-5xl text-outline mb-3 block">search_off</span>
  <p class="text-on-surface-variant font-semibold">Toko tidak ditemukan di area ini</p>
  <p class="text-outline text-sm mt-1">Coba perluas radius pencarian Anda</p>
</div>
@endforelse

@if($tokoList->hasPages())
<div class="col-span-full mt-4">
    {{ $tokoList->appends(request()->all())->links() }}
</div>
@endif
