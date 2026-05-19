<x-layout-user title="Profil Saya">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Page Header --}}
    <div>
      <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-1">
        <a href="{{ route('MenuUtama') }}" class="hover:text-primary transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="font-semibold text-primary">Profil</span>
      </nav>
      <h1 class="font-headline text-2xl font-bold text-on-surface">Profil Saya</h1>
    </div>

    {{-- Profile Hero Card --}}
    <div class="bg-primary text-on-primary rounded-2xl p-7 relative overflow-hidden shadow-sm">
      <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
        {{-- Avatar --}}
        <div class="w-20 h-20 rounded-2xl bg-on-primary/20 flex items-center justify-center text-4xl font-headline font-black shrink-0">
          {{ strtoupper(substr(Auth::user()->Username ?? 'U', 0, 1)) }}
        </div>
        <div class="flex-1">
          <span class="text-xs font-bold text-primary-fixed uppercase tracking-widest mb-1 block">Customer Portal</span>
          <h2 class="font-headline text-3xl font-bold tracking-tight">{{ Auth::user()->Username ?? 'Pengguna' }}</h2>
          <p class="text-primary-fixed text-sm mt-1">{{ Auth::user()->Email ?? '' }}</p>
        </div>
        {{-- Stats --}}
        <div class="flex gap-4">
          <div class="bg-on-primary/15 backdrop-blur-md px-5 py-3 rounded-xl text-center">
            <p class="text-xl font-headline font-black">124</p>
            <p class="text-xs text-primary-fixed font-bold uppercase tracking-wider">Orders</p>
          </div>
          <div class="bg-on-primary/15 backdrop-blur-md px-5 py-3 rounded-xl text-center">
            <p class="text-xl font-headline font-black">9.8</p>
            <p class="text-xs text-primary-fixed font-bold uppercase tracking-wider">Trust</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Menu Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

      {{-- Chat History --}}
      <a class="stat-card group relative overflow-hidden bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30 shadow-sm hover:border-primary/30 transition-all" href="{{ route('Pesan') }}">
        <div class="flex justify-between items-start mb-10">
          <div class="w-11 h-11 bg-tertiary/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl text-tertiary" style="font-variation-settings:'FILL' 1">forum</span>
          </div>
          <span class="material-symbols-outlined text-on-surface-variant/30 group-hover:text-primary/50 transition-colors">arrow_outward</span>
        </div>
        <h3 class="font-headline text-lg font-bold text-on-surface mb-1">Chat</h3>
        <p class="text-on-surface-variant text-sm leading-relaxed">Lihat riwayat negosiasi dan pertanyaan aktif dengan penjual.</p>
      </a>

      {{-- Lacak Pesanan --}}
      <a class="stat-card group relative overflow-hidden bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30 shadow-sm hover:border-primary/30 transition-all" href="{{ route('ordertracking') }}">
        <div class="flex justify-between items-start mb-10">
          <div class="w-11 h-11 bg-secondary/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl text-secondary" style="font-variation-settings:'FILL' 1">local_shipping</span>
          </div>
          <span class="material-symbols-outlined text-on-surface-variant/30 group-hover:text-primary/50 transition-colors">arrow_outward</span>
        </div>
        <h3 class="font-headline text-lg font-bold text-on-surface mb-1">Lacak Pesanan</h3>
        <p class="text-on-surface-variant text-sm leading-relaxed">Pantau status pengiriman material Anda secara realtime.</p>
      </a>

      {{-- Daftar sebagai Penjual --}}
      <a class="stat-card group relative overflow-hidden bg-primary text-on-primary p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all" href="{{ route('daftarPenjual') }}">
        <div class="absolute top-0 right-0 w-28 h-28 bg-on-primary/10 rounded-full -mr-14 -mt-14 blur-2xl"></div>
        <div class="relative flex justify-between items-start mb-10">
          <div class="w-11 h-11 bg-on-primary/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">add_business</span>
          </div>
        </div>
        <h3 class="font-headline text-lg font-bold mb-1">Daftar sebagai Penjual</h3>
        <p class="text-primary-fixed text-sm leading-relaxed">Jangkau lebih banyak pembeli. Daftarkan toko Anda hari ini.</p>
      </a>

      {{-- Logout (Full Width) --}}
      <div class="md:col-span-3">
        <form method="POST" action="{{ route('profil.logout') }}">
          @csrf
          <button type="submit" class="w-full flex items-center justify-between bg-surface-container-lowest border border-error/20 p-5 rounded-2xl group hover:bg-error/5 transition-colors shadow-sm">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-error/10 text-error rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]">logout</span>
              </div>
              <div class="text-left">
                <span class="font-headline font-bold text-on-surface block text-sm">Logout</span>
                <span class="text-xs text-on-surface-variant">Akhiri sesi Anda dengan aman</span>
              </div>
            </div>
            <span class="material-symbols-outlined text-error opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
          </button>
        </form>
      </div>

    </div>

  </div>

</x-layout-user>
