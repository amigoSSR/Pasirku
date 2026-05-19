<x-layout-user title="Daftar Penjual">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto">

    {{-- Page Header --}}
    <div class="mb-8">
      <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
        <a href="{{ route('MenuUtama') }}" class="hover:text-primary transition-colors">Home</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a href="{{ route('Profil') }}" class="hover:text-primary transition-colors">Profil</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="font-semibold text-primary">Daftar Penjual</span>
      </nav>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

      {{-- Left: Brand Messaging --}}
      <div class="space-y-6 py-4">
        <div class="space-y-3">
          <span class="text-xs font-bold text-primary uppercase tracking-[0.2em] flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">storefront</span>
            Industrial Portal
          </span>
          <h1 class="font-headline text-4xl md:text-5xl font-extrabold text-on-surface leading-tight tracking-tight">
            Bangun <span class="text-primary">Toko Digital</span> Anda
          </h1>
          <p class="text-on-surface-variant text-base leading-relaxed max-w-md">
            Bergabunglah dengan marketplace pasir paling efisien di kawasan ini. Hubungkan inventaris Anda dengan pembeli industri terverifikasi.
          </p>
        </div>

        {{-- Feature Cards --}}
        <div class="grid grid-cols-1 gap-4">
          @php
            $features = [
              ['icon'=>'trending_up','title'=>'Jangkauan Luas','desc'=>'Akses ribuan pembeli aktif yang mencari material konstruksi berkualitas.','color'=>'bg-primary/10 text-primary'],
              ['icon'=>'shield','title'=>'Terverifikasi','desc'=>'Platform aman dengan sistem verifikasi bisnis yang terpercaya.','color'=>'bg-secondary/10 text-secondary'],
              ['icon'=>'bolt','title'=>'Manajemen Mudah','desc'=>'Dashboard intuitif untuk kelola produk, stok, dan pesanan.','color'=>'bg-tertiary/10 text-tertiary'],
            ];
          @endphp
          @foreach($features as $f)
          <div class="flex items-start gap-4 p-4 bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm">
            <div class="w-10 h-10 {{ $f['color'] }} rounded-xl flex items-center justify-center shrink-0">
              <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">{{ $f['icon'] }}</span>
            </div>
            <div>
              <h4 class="font-headline font-bold text-on-surface text-sm">{{ $f['title'] }}</h4>
              <p class="text-on-surface-variant text-xs mt-0.5 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Right: Registration Form --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-7 relative overflow-hidden">
        {{-- Decorative --}}
        <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 rounded-full bg-primary/5 blur-2xl pointer-events-none"></div>

        {{-- Form Header --}}
        <div class="flex items-start justify-between mb-7 relative">
          <div>
            <h2 class="font-headline text-2xl font-bold text-on-surface">Pendaftaran Penjual</h2>
            <p class="text-on-surface-variant text-sm mt-1">Lengkapi data untuk memverifikasi entitas bisnis Anda.</p>
          </div>
          <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shrink-0 ml-3">
            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">verified</span>
            VERIFIED
          </span>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
          <div class="mb-5 p-4 rounded-xl bg-error/10 border border-error/20 text-sm text-error">
            <div class="flex items-center gap-2 font-bold mb-2">
              <span class="material-symbols-outlined text-[16px]">error</span>
              Terdapat kesalahan:
            </div>
            <ul class="list-disc pl-5 space-y-0.5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('daftarPenjual.store') }}" method="POST" class="space-y-5">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nama Toko</label>
              <div class="relative group">
                <input name="Nama_Toko" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm text-on-surface placeholder:text-outline/50 focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" placeholder="Masukkan nama bisnis" type="text" required value="{{ old('Nama_Toko') }}" />
              </div>
            </div>
            <div class="space-y-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Username</label>
              <div class="relative group">
                <input name="Username" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm text-on-surface placeholder:text-outline/50 focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" placeholder="Username akun Anda" type="text" required value="{{ old('Username') }}" />
              </div>
            </div>
          </div>

          <div class="space-y-1.5">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Lokasi Toko</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">location_on</span>
              <input name="Lokasi_Toko" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl pl-10 pr-4 py-2.5 text-sm text-on-surface placeholder:text-outline/50 focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" placeholder="Alamat lengkap operasional" type="text" required value="{{ old('Lokasi_Toko') }}" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email Toko</label>
              <input name="Email_Toko" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm text-on-surface placeholder:text-outline/50 focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" placeholder="official@business.com" type="email" required value="{{ old('Email_Toko') }}" />
            </div>
            <div class="space-y-1.5">
              <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">No HP Toko</label>
              <input name="Nomer_Telepon_Toko" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-2.5 text-sm text-on-surface placeholder:text-outline/50 focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" placeholder="+62 812 XXXX" type="tel" required value="{{ old('Nomer_Telepon_Toko') }}" />
            </div>
          </div>

          {{-- Agreement --}}
          <div class="flex items-start gap-3 p-4 bg-surface-container-low rounded-xl border border-outline-variant/20">
            <input class="mt-0.5 w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary/20" id="terms" type="checkbox" required />
            <label class="text-xs text-on-surface-variant leading-relaxed" for="terms">
              Saya setuju dengan <span class="text-primary font-semibold">Syarat dan Ketentuan PasirKu</span> serta menyetujui verifikasi lapangan berkala.
            </label>
          </div>

          {{-- Submit --}}
          <button class="w-full bg-primary text-on-primary font-headline font-bold py-3.5 rounded-xl shadow-sm hover:bg-primary-container transition-all duration-200 flex items-center justify-center gap-2.5 group active:scale-[0.98]" type="submit">
            <span>DAFTARKAN SEKARANG</span>
            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
          </button>

        </form>
      </div>

    </div>
  </div>

</x-layout-user>