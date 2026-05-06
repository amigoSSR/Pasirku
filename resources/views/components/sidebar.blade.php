{{--
  Shared Sidebar Component
  Digunakan di semua halaman utama agar posisi dan tampilan sidebar konsisten.
  Highlight menu otomatis berdasarkan route aktif.
--}}
<aside class="hidden md:flex flex-col h-full w-64 bg-slate-100 py-8 border-r-0 fixed left-0 top-[60px] bottom-0 z-40">
  <div class="px-6 pb-8">
    <h2 class="text-sm font-bold text-blue-900 uppercase tracking-widest opacity-50">
      Industrial Hub
    </h2>
    <div class="flex items-center mt-2 gap-2">
      <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1">verified</span>
      <span class="text-xs font-semibold text-slate-500 uppercase tracking-tighter">Verified Seller</span>
    </div>
  </div>

  <nav class="flex-1 space-y-1">

    {{-- Menu Utama --}}
    @php $isMenuUtama = request()->routeIs('MenuUtama'); @endphp
    <a href="{{ route('MenuUtama') }}"
      class="flex items-center gap-4 px-6 py-4 transition-colors
        {{ $isMenuUtama
          ? 'text-blue-900 font-bold border-r-4 border-blue-900 bg-white/50'
          : 'text-slate-500 hover:text-blue-800 hover:bg-slate-200' }}">
      <span class="material-symbols-outlined" @if($isMenuUtama) style="font-variation-settings: 'FILL' 1" @endif>storefront</span>
      <span>Menu Utama</span>
    </a>

    {{-- Active Orders --}}
    @php $isOrderTracking = request()->routeIs('ordertracking'); @endphp
    <a href="{{ route('ordertracking') }}"
      class="flex items-center gap-4 px-6 py-4 transition-colors
        {{ $isOrderTracking
          ? 'text-blue-900 font-bold border-r-4 border-blue-900 bg-white/50'
          : 'text-slate-500 hover:text-blue-800 hover:bg-slate-200' }}">
      <span class="material-symbols-outlined" @if($isOrderTracking) style="font-variation-settings: 'FILL' 1" @endif>local_shipping</span>
      <span>Active Orders</span>
    </a>

    {{-- Messages --}}
    @php $isPesan = request()->routeIs('Pesan'); @endphp
    <a href="{{ route('Pesan') }}"
      class="flex items-center gap-4 px-6 py-4 transition-colors
        {{ $isPesan
          ? 'text-blue-900 font-bold border-r-4 border-blue-900 bg-white/50'
          : 'text-slate-500 hover:text-blue-800 hover:bg-slate-200' }}">
      <span class="material-symbols-outlined" @if($isPesan) style="font-variation-settings: 'FILL' 1" @endif>forum</span>
      <span>Messages</span>
    </a>

    {{-- Profile --}}
    @php $isProfil = request()->routeIs('Profil'); @endphp
    <a href="{{ route('Profil') }}"
      class="flex items-center gap-4 px-6 py-4 transition-colors
        {{ $isProfil
          ? 'text-blue-900 font-bold border-r-4 border-blue-900 bg-white/50'
          : 'text-slate-500 hover:text-blue-800 hover:bg-slate-200' }}">
      <span class="material-symbols-outlined" @if($isProfil) style="font-variation-settings: 'FILL' 1" @endif>person</span>
      <span>Profile</span>
    </a>

  </nav>

  <div class="px-6 mt-auto mb-16">
    {{-- Slot bawah kosong, bisa diisi tombol kelak --}}
  </div>
</aside>
