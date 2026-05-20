<x-layout-admin title="Profil Admin">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[900px] mx-auto space-y-8">

    {{-- Hero Card --}}
    <div class="relative overflow-hidden bg-primary text-on-primary rounded-2xl p-7 shadow-sm">
      <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
      <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
        {{-- Avatar --}}
        <div class="w-20 h-20 rounded-2xl bg-on-primary/20 flex items-center justify-center font-headline font-extrabold text-4xl uppercase text-on-primary shrink-0 shadow-lg">
          {{ strtoupper(substr(Auth::user()->Username ?? 'A', 0, 1)) }}
        </div>
        <div class="flex-1">
          <span class="text-xs font-black text-primary-fixed uppercase tracking-[0.2em] mb-1 block">Administrator</span>
          <h1 class="font-headline text-2xl md:text-3xl font-extrabold tracking-tight mb-1">
            {{ Auth::user()->Username ?? 'Admin' }}
          </h1>
          <p class="text-on-primary/70 text-sm">{{ Auth::user()->Email ?? '-' }}</p>
        </div>
        {{-- Stats --}}
        <div class="flex gap-4 shrink-0">
          <div class="text-center bg-on-primary/15 backdrop-blur-sm rounded-xl px-5 py-3">
            <p class="font-headline text-2xl font-extrabold">{{ \App\Models\Toko::count() }}</p>
            <p class="text-xs text-on-primary/70 uppercase tracking-wide font-semibold">Toko</p>
          </div>
          <div class="text-center bg-on-primary/15 backdrop-blur-sm rounded-xl px-5 py-3">
            <p class="font-headline text-2xl font-extrabold">{{ \App\Models\User::where('Role', 'user')->count() }}</p>
            <p class="text-xs text-on-primary/70 uppercase tracking-wide font-semibold">User</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 p-6 space-y-4">
      <h2 class="font-headline font-bold text-on-surface text-lg mb-4">Informasi Akun</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-surface-container-low rounded-xl p-4">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Username</p>
          <p class="font-semibold text-on-surface">{{ Auth::user()->Username ?? '-' }}</p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-4">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Email</p>
          <p class="font-semibold text-on-surface">{{ Auth::user()->Email ?? '-' }}</p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-4">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Nomor Telepon</p>
          <p class="font-semibold text-on-surface">{{ Auth::user()->Nomer_Telepon ?? '-' }}</p>
        </div>
        <div class="bg-surface-container-low rounded-xl p-4">
          <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wide mb-1">Role</p>
          <span class="inline-flex items-center gap-1.5 bg-primary/10 text-primary text-xs font-black uppercase px-3 py-1 rounded-full">
            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">shield_person</span>
            Administrator
          </span>
        </div>
      </div>
    </div>

    {{-- Admin's Store Card if registered --}}
    @php
      $tokoAdmin = \App\Models\Toko::where('ID_Akun', Auth::id())->first();
    @endphp
    @if($tokoAdmin)
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 p-6 space-y-4">
      <div class="flex items-center gap-3">
        <div class="w-11 h-11 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
          <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">storefront</span>
        </div>
        <div>
          <h2 class="font-headline font-bold text-on-surface text-lg">Kelola Alamat & Map Toko Anda</h2>
          <p class="text-on-surface-variant text-xs mt-0.5">Toko: <span class="font-bold text-primary">{{ $tokoAdmin->Nama_Toko }}</span></p>
        </div>
      </div>
      <p class="text-on-surface-variant text-sm leading-relaxed">
        Anda terdeteksi memiliki toko yang terdaftar di platform. Silakan gunakan tombol di bawah untuk mengatur koordinat bujur, lintang, alamat terstruktur, dan pin GPS pada peta interaktif.
      </p>
      <div class="flex flex-col md:flex-row gap-4 items-center bg-surface-container-low p-4 rounded-xl">
        <div class="grid grid-cols-2 gap-4 flex-1 text-xs">
          <div>
            <span class="font-semibold text-on-surface-variant uppercase tracking-wider block text-[10px] mb-0.5">Latitude (Lintang)</span>
            <span class="font-mono font-bold text-on-surface bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/30 inline-block">{{ $tokoAdmin->latitude ?? 'Belum diatur' }}</span>
          </div>
          <div>
            <span class="font-semibold text-on-surface-variant uppercase tracking-wider block text-[10px] mb-0.5">Longitude (Bujur)</span>
            <span class="font-mono font-bold text-on-surface bg-surface-container-lowest px-2 py-1 rounded border border-outline-variant/30 inline-block">{{ $tokoAdmin->longitude ?? 'Belum diatur' }}</span>
          </div>
        </div>
        <a href="{{ route('ProfilStore') }}" class="w-full md:w-auto bg-primary text-on-primary hover:bg-primary-container px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm text-center active:scale-95 duration-200">
          Kelola Alamat & Map
        </a>
      </div>
    </div>
    @endif

    {{-- Quick Nav Grid --}}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <a href="{{ route('MenuUtamaAdmin') }}"
        class="group relative overflow-hidden bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/20 hover:shadow-md hover:border-primary/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-8">
          <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-primary text-[24px]" style="font-variation-settings:'FILL' 1">dashboard</span>
          </div>
          <span class="material-symbols-outlined text-on-surface-variant/30 group-hover:text-primary/50 transition-colors">arrow_outward</span>
        </div>
        <h3 class="font-headline font-bold text-on-surface text-lg mb-1">Dashboard</h3>
        <p class="text-sm text-on-surface-variant">Lihat statistik dan overview platform.</p>
      </a>

      <a href="{{ route('ShopeRegistry') }}"
        class="group relative overflow-hidden bg-primary p-6 rounded-2xl shadow-sm hover:shadow-md hover:opacity-95 transition-all duration-300">
        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
        <div class="flex items-center justify-between mb-8 relative z-10">
          <div class="w-12 h-12 rounded-xl bg-on-primary/20 flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-on-primary text-[24px]" style="font-variation-settings:'FILL' 1">storefront</span>
          </div>
        </div>
        <h3 class="font-headline font-bold text-on-primary text-lg mb-1 relative z-10">Kelola Toko</h3>
        <p class="text-sm text-on-primary/70 relative z-10">Aktifkan atau nonaktifkan toko.</p>
      </a>

      <a href="{{ route('PesanAdmin') }}"
        class="group relative overflow-hidden bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/20 hover:shadow-md hover:border-primary/20 transition-all duration-300">
        <div class="flex items-center justify-between mb-8">
          <div class="w-12 h-12 rounded-xl bg-secondary-container flex items-center justify-center group-hover:scale-110 transition-transform">
            <span class="material-symbols-outlined text-secondary text-[24px]" style="font-variation-settings:'FILL' 1">forum</span>
          </div>
          <span class="material-symbols-outlined text-on-surface-variant/30 group-hover:text-primary/50 transition-colors">arrow_outward</span>
        </div>
        <h3 class="font-headline font-bold text-on-surface text-lg mb-1">Chat Support</h3>
        <p class="text-sm text-on-surface-variant">Balas pesan dari pengguna platform.</p>
      </a>

      {{-- Logout --}}
      <form method="POST" action="{{ route('profil.logout') }}" class="contents">
        @csrf
        <button type="submit"
          class="group text-left relative overflow-hidden bg-surface-container-lowest p-6 rounded-2xl shadow-sm border-2 border-error/10 hover:bg-error/5 hover:border-error/20 transition-all duration-300 cursor-pointer">
          <div class="flex items-center justify-between mb-8">
            <div class="w-12 h-12 rounded-xl bg-error/10 flex items-center justify-center group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined text-error text-[24px]">logout</span>
            </div>
          </div>
          <h3 class="font-headline font-bold text-on-surface text-lg mb-1">Logout</h3>
          <p class="text-sm text-on-surface-variant">Akhiri sesi administrator dengan aman.</p>
        </button>
      </form>

    </div>

  </div>

</x-layout-admin>