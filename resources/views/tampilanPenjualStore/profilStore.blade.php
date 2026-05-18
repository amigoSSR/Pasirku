<x-layout-store title="Store Profile">
  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary">Dashboard</a>
      <span class="material-symbols-outlined text-sm">chevron_right</span>
      <span class="text-primary font-semibold">Profil Toko</span>
    </nav>
  </x-slot>

  <div class="h-40 md:h-52 w-full relative overflow-hidden" style="background: linear-gradient(135deg, #944a00 0%, #e67e22 100%);">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-10 w-48 h-48 bg-black/10 rounded-full blur-2xl translate-y-1/3"></div>
  </div>

  <div class="max-w-5xl mx-auto px-6 md:px-8 -mt-16 relative z-10 pb-24 md:pb-10">
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8 mb-8 flex flex-col md:flex-row gap-6 md:items-end">
      <div class="relative shrink-0 -mt-16 md:-mt-20">
        <div class="w-28 h-28 md:h-36 md:w-36 rounded-2xl border-4 border-surface-container-lowest overflow-hidden shadow-md bg-white">
          <img alt="Store Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5PQtLotEWu5Gayn3BYAklIw_RIGZZ9W4Va4b6CgPo1Vc63rl0AsarywWh0O9JeqvGNBy29ZhR37zpxw7Q0D0wegVj9ndr7ki257XmzjvsTQy7_qy8VSbS_MHwpnPd9RerrDoWwWtRWGEmvoYFpJ01SL9PYZ2WPsMMI4oMTZ00pq-oQqnM6jidyCFcHRED5qU1xDteSLy8EbgbL9ZKOPqKvdE0WJ7tcwp7m8eEKUnZVhCh7I8yJyvHQBnB1Qi_SRypz1rveyUHZQ" />
        </div>
        <div class="absolute -bottom-2 -right-2 bg-green-500 text-white w-8 h-8 rounded-full border-4 border-surface-container-lowest flex items-center justify-center shadow-sm">
          <span class="material-symbols-outlined text-[16px]">check</span>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
          <span class="bg-primary-fixed/30 text-primary px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Premium Seller</span>
          <span class="bg-surface-container-high text-on-surface-variant px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
            <span class="material-symbols-outlined text-[12px]">location_on</span> Jakarta
          </span>
        </div>
        <h2 class="font-headline text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight">{{ Auth::user()->Username ?? 'Nama Toko Anda' }}</h2>
        <p class="text-on-surface-variant text-sm mt-1">Bergabung sejak Okt 2024 • Menjual berbagai macam pasir dan batu agregat.</p>
      </div>
      <div class="flex gap-4 shrink-0">
        <div class="bg-surface-container-low px-4 py-3 rounded-xl border border-outline-variant/30 text-center">
          <p class="text-[11px] text-on-surface-variant font-bold uppercase tracking-wide mb-1">Total Pesanan</p>
          <p class="text-xl font-headline font-extrabold text-primary">124</p>
        </div>
        <div class="bg-surface-container-low px-4 py-3 rounded-xl border border-outline-variant/30 text-center">
          <p class="text-[11px] text-on-surface-variant font-bold uppercase tracking-wide mb-1">Rating</p>
          <p class="text-xl font-headline font-extrabold text-on-surface flex items-center gap-1">
            <span class="material-symbols-outlined text-amber-500 text-lg" style="font-variation-settings:'FILL' 1">star</span>4.9
          </p>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <a href="#" class="group relative bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30 hover:border-primary/40 hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
        <div class="absolute top-0 right-0 w-28 h-28 bg-primary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
        <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform relative z-10">
          <span class="material-symbols-outlined text-2xl">inventory_2</span>
        </div>
        <h3 class="font-headline text-xl font-bold text-on-surface mb-2 relative z-10">Update Isi Toko</h3>
        <p class="text-on-surface-variant text-sm leading-relaxed mb-6 relative z-10">Kelola katalog produk, perbarui harga pasir, batu, dan agregat lainnya.</p>
        <div class="flex items-center text-primary text-sm font-semibold mt-auto relative z-10">
          Kelola Katalog <span class="material-symbols-outlined text-sm ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </div>
      </a>

      <a href="{{ route('PesanStore') }}" class="group relative bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30 hover:border-secondary/40 hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
        <div class="absolute top-0 right-0 w-28 h-28 bg-secondary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
        <div class="flex justify-between items-start mb-4 relative z-10">
          <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">forum</span>
          </div>
          <span class="bg-error text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3 Baru</span>
        </div>
        <h3 class="font-headline text-xl font-bold text-on-surface mb-2 relative z-10">Chat & Pesan</h3>
        <p class="text-on-surface-variant text-sm leading-relaxed mb-6 relative z-10">Lihat riwayat negosiasi dan pertanyaan aktif dari pelanggan Anda.</p>
        <div class="flex items-center text-secondary text-sm font-semibold mt-auto relative z-10">
          Buka Kotak Masuk <span class="material-symbols-outlined text-sm ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </div>
      </a>

      <a href="{{ route('MonitoringPelangganStore') }}" class="group relative bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30 hover:border-tertiary/40 hover:shadow-md hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">
        <div class="absolute top-0 right-0 w-28 h-28 bg-tertiary/5 rounded-bl-full -z-0 group-hover:scale-110 transition-transform"></div>
        <div class="w-12 h-12 bg-tertiary/10 text-tertiary rounded-xl flex items-center justify-center mb-4 group-hover:rotate-12 transition-transform duration-300 relative z-10">
          <span class="material-symbols-outlined text-2xl">group</span>
        </div>
        <h3 class="font-headline text-xl font-bold text-on-surface mb-2 relative z-10">Monitoring Pelanggan</h3>
        <p class="text-on-surface-variant text-sm leading-relaxed mb-6 relative z-10">Pantau aktivitas dan data pelanggan toko Anda secara detail.</p>
        <div class="flex items-center text-tertiary text-sm font-semibold mt-auto relative z-10">
          Lihat Pelanggan <span class="material-symbols-outlined text-sm ml-1 group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </div>
      </a>

      <div class="md:col-span-2 lg:col-span-3">
        <form method="POST" action="{{ route('profil.logout') }}">
          @csrf
          <button type="submit" class="w-full bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-error/20 hover:bg-error/5 hover:border-error/40 flex items-center justify-between group transition-all">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-error/10 text-error rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">logout</span>
              </div>
              <div class="text-left">
                <h3 class="font-headline text-lg font-bold text-error">Keluar Aplikasi</h3>
                <p class="text-on-surface-variant text-sm">Akhiri sesi Anda dengan aman dan log out dari akun toko.</p>
              </div>
            </div>
            <div class="w-10 h-10 rounded-full bg-error/10 flex items-center justify-center text-error opacity-0 group-hover:opacity-100 group-hover:translate-x-2 transition-all duration-300">
              <span class="material-symbols-outlined">arrow_forward</span>
            </div>
          </button>
        </form>
      </div>
    </div>
  </div>

</x-layout-store>