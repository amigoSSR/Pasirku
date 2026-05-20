<x-layout-admin title="Dashboard Admin">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="text-xs font-black text-primary uppercase tracking-[0.2em] flex items-center gap-1.5 mb-1">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">shield_person</span>
          Administrator
        </span>
        <h1 class="font-headline text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight">
          Selamat Datang, {{ Auth::user()->Username ?? 'Admin' }} 👋
        </h1>
        <p class="text-sm text-on-surface-variant mt-1">Pantau seluruh aktivitas platform PasirKu dari sini.</p>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('ShopeRegistry') }}"
          class="bg-primary text-on-primary px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:opacity-90 transition-all hover:shadow-md">
          <span class="material-symbols-outlined text-[18px]">storefront</span>
          Kelola Toko
        </a>
      </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

      {{-- Total Toko --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/20">
        <div class="flex items-center justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings:'FILL' 1">storefront</span>
          </div>
          <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
            {{ $stats['toko_aktif'] }} approved
          </span>
        </div>
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Toko</p>
        <h3 class="font-headline text-3xl font-extrabold text-on-surface mt-1">{{ $stats['total_toko'] }}</h3>
        <p class="text-xs text-on-surface-variant mt-1.5 flex gap-2">
          <span class="text-yellow-600 font-bold">{{ $stats['toko_pending'] }} pending</span>
          <span class="text-red-500 font-bold">{{ $stats['toko_rejected'] }} rejected</span>
        </p>
      </div>

      {{-- Total User --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/20">
        <div class="flex items-center justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-tertiary/10 flex items-center justify-center">
            <span class="material-symbols-outlined text-tertiary text-[20px]" style="font-variation-settings:'FILL' 1">group</span>
          </div>
        </div>
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Pengguna</p>
        <h3 class="font-headline text-3xl font-extrabold text-on-surface mt-1">{{ $stats['total_users'] }}</h3>
        <p class="text-xs text-on-surface-variant mt-1.5">User terdaftar</p>
      </div>

      {{-- Total Pendapatan --}}
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/20">
        <div class="flex items-center justify-between mb-3">
          <div class="w-10 h-10 rounded-xl bg-secondary-container flex items-center justify-center">
            <span class="material-symbols-outlined text-secondary text-[20px]" style="font-variation-settings:'FILL' 1">payments</span>
          </div>
        </div>
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Pendapatan</p>
        <h3 class="font-headline text-2xl font-extrabold text-on-surface mt-1">
          Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}
        </h3>
        <p class="text-xs text-on-surface-variant mt-1.5">Dari semua toko</p>
      </div>

      {{-- Komisi Admin --}}
      <div class="stat-card bg-primary rounded-2xl p-5 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
        <div class="flex items-center justify-between mb-3 relative z-10">
          <div class="w-10 h-10 rounded-xl bg-on-primary/20 flex items-center justify-center">
            <span class="material-symbols-outlined text-on-primary text-[20px]" style="font-variation-settings:'FILL' 1">account_balance</span>
          </div>
        </div>
        <p class="text-xs font-semibold text-on-primary/70 uppercase tracking-wide relative z-10">Komisi Admin</p>
        <h3 class="font-headline text-2xl font-extrabold text-on-primary mt-1 relative z-10">
          Rp {{ number_format($stats['total_komisi'], 0, ',', '.') }}
        </h3>
        <p class="text-xs text-on-primary/60 mt-1.5 relative z-10">{{ $stats['total_pembelian'] }} total pembelian</p>
      </div>

    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Recent Toko Table --}}
      <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
        <div class="px-6 py-5 border-b border-outline-variant/20 flex items-center justify-between">
          <div>
            <h2 class="font-headline font-bold text-on-surface text-lg">Toko Terbaru</h2>
            <p class="text-xs text-on-surface-variant mt-0.5">5 toko yang paling baru bergabung</p>
          </div>
          <a href="{{ route('ShopeRegistry') }}"
            class="text-primary text-xs font-bold flex items-center gap-1 hover:underline">
            Lihat semua
            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
          </a>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead>
              <tr class="border-b border-outline-variant/20 bg-surface-container-low/50">
                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Toko</th>
                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Lokasi</th>
                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pendapatan</th>
                <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
              @forelse($recentToko as $toko)
              <tr class="hover:bg-surface-container-low/50 transition-colors">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary font-bold text-xs flex items-center justify-center uppercase shrink-0">
                      {{ strtoupper(substr($toko->Nama_Toko, 0, 2)) }}
                    </div>
                    <div>
                      <p class="font-semibold text-on-surface text-sm">{{ $toko->Nama_Toko }}</p>
                      <p class="text-xs text-on-surface-variant">{{ $toko->Username }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 text-on-surface-variant text-xs">{{ Str::limit($toko->Lokasi_Toko, 25) }}</td>
                <td class="px-6 py-4 font-semibold text-on-surface text-sm">
                  Rp {{ number_format($toko->Pendapatan_Toko ?? 0, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                  @if($toko->Status === 'approved')
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                      <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Approved
                    </span>
                  @elseif($toko->Status === 'pending')
                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                      <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
                    </span>
                  @elseif($toko->Status === 'rejected')
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                      <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Rejected
                    </span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="px-6 py-10 text-center text-on-surface-variant text-sm">Belum ada data toko.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Quick Actions --}}
      <div class="space-y-4">

        {{-- Status Toko Summary --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 p-6">
          <h3 class="font-headline font-bold text-on-surface mb-5">Status Platform</h3>
          <div class="space-y-4">
            <div>
              <div class="flex justify-between text-xs font-bold mb-1.5">
                <span class="text-on-surface-variant uppercase tracking-wide">Toko Aktif</span>
                <span class="text-green-600">{{ $stats['total_toko'] > 0 ? round(($stats['toko_aktif'] / $stats['total_toko']) * 100) : 0 }}%</span>
              </div>
              <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full transition-all"
                  style="width: {{ $stats['total_toko'] > 0 ? round(($stats['toko_aktif'] / $stats['total_toko']) * 100) : 0 }}%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-xs font-bold mb-1.5">
                <span class="text-on-surface-variant uppercase tracking-wide">Komisi Admin</span>
                <span class="text-primary">{{ $stats['total_pendapatan'] > 0 ? round(($stats['total_komisi'] / $stats['total_pendapatan']) * 100) : 0 }}%</span>
              </div>
              <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full transition-all"
                  style="width: {{ $stats['total_pendapatan'] > 0 ? min(100, round(($stats['total_komisi'] / $stats['total_pendapatan']) * 100)) : 0 }}%"></div>
              </div>
            </div>
          </div>
        </div>

        {{-- Quick Nav Cards --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 p-6 space-y-3">
          <h3 class="font-headline font-bold text-on-surface mb-4">Aksi Cepat</h3>

          <a href="{{ route('ShopeRegistry') }}"
            class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">
            <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
              <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">storefront</span>
            </div>
            <div class="flex-1">
              <p class="text-sm font-semibold text-on-surface">Kelola Toko</p>
              <p class="text-xs text-on-surface-variant">Aktifkan / nonaktifkan toko</p>
            </div>
            <span class="material-symbols-outlined text-on-surface-variant text-[16px] group-hover:text-primary transition-colors">arrow_forward_ios</span>
          </a>

          <a href="{{ route('Pesan') }}"
            class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">
            <div class="w-9 h-9 rounded-xl bg-secondary-container flex items-center justify-center">
              <span class="material-symbols-outlined text-secondary text-[18px]" style="font-variation-settings:'FILL' 1">forum</span>
            </div>
            <div class="flex-1">
              <p class="text-sm font-semibold text-on-surface">Chat Support</p>
              <p class="text-xs text-on-surface-variant">Balas pesan dari pengguna</p>
            </div>
            <span class="material-symbols-outlined text-on-surface-variant text-[16px] group-hover:text-primary transition-colors">arrow_forward_ios</span>
          </a>

          <a href="{{ route('ProfilAdmin') }}"
            class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">
            <div class="w-9 h-9 rounded-xl bg-tertiary/10 flex items-center justify-center">
              <span class="material-symbols-outlined text-tertiary text-[18px]" style="font-variation-settings:'FILL' 1">manage_accounts</span>
            </div>
            <div class="flex-1">
              <p class="text-sm font-semibold text-on-surface">Profil Admin</p>
              <p class="text-xs text-on-surface-variant">Pengaturan akun</p>
            </div>
            <span class="material-symbols-outlined text-on-surface-variant text-[16px] group-hover:text-primary transition-colors">arrow_forward_ios</span>
          </a>

        </div>
      </div>
    </div>

  </div>

</x-layout-admin>