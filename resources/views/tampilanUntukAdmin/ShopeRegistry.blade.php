<x-layout-admin title="Manajemen Toko">
  
  @push('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  @endpush

  <div x-data="shopeRegistryPage()" class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="text-xs font-black text-primary uppercase tracking-[0.2em] flex items-center gap-1.5 mb-1">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">storefront</span>
          Manajemen Platform
        </span>
        <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Daftar Toko</h1>
        <p class="text-sm text-on-surface-variant mt-1">Kelola status aktif dan data seluruh toko yang terdaftar.</p>
      </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-green-50 text-green-800 rounded-xl border border-green-200 text-sm font-semibold">
      <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
      {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 p-4 bg-red-50 text-red-800 rounded-xl border border-red-200 text-sm font-semibold">
      <span class="material-symbols-outlined text-red-600" style="font-variation-settings:'FILL' 1">error</span>
      {{ session('error') }}
    </div>
    @endif

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Toko</p>
        <p class="font-headline text-2xl font-extrabold text-on-surface mt-1">{{ $stats['total'] }}</p>
      </div>
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Approved</p>
        <p class="font-headline text-2xl font-extrabold text-green-600 mt-1">{{ $stats['approved'] }}</p>
      </div>
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Pending</p>
        <p class="font-headline text-2xl font-extrabold text-yellow-600 mt-1">{{ $stats['pending'] }}</p>
      </div>
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Komisi</p>
        <p class="font-headline text-xl font-extrabold text-primary mt-1">
          Rp {{ number_format($stats['komisi'], 0, ',', '.') }}
        </p>
      </div>
    </div>

    {{-- Table --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
      <div class="px-6 py-5 border-b border-outline-variant/20 flex items-center justify-between">
        <div>
          <h2 class="font-headline font-bold text-on-surface">Semua Toko Terdaftar</h2>
          <p class="text-xs text-on-surface-variant mt-0.5">Klik toggle untuk mengaktifkan atau menonaktifkan toko</p>
        </div>
      </div>

      {{-- Mobile Cards (sm only) --}}
      <div class="md:hidden divide-y divide-outline-variant/20">
        @forelse($tokoList as $toko)
        <div class="p-5 space-y-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center text-sm uppercase shrink-0">
              {{ strtoupper(substr($toko->Nama_Toko, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
              <p class="font-bold text-on-surface truncate">{{ $toko->Nama_Toko }}</p>
              <p class="text-xs text-on-surface-variant">{{ $toko->Username }}</p>
            </div>
            @if($toko->Status === 'approved')
              <span class="shrink-0 inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Approved
              </span>
            @elseif($toko->Status === 'pending')
              <span class="shrink-0 inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
              </span>
            @elseif($toko->Status === 'rejected')
              <span class="shrink-0 inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Rejected
              </span>
            @elseif($toko->Status === 'expired')
              <span class="shrink-0 inline-flex items-center gap-1 bg-orange-100 text-orange-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Expired
              </span>
            @endif
          </div>
          <div class="grid grid-cols-2 gap-2 text-xs text-on-surface-variant">
            <div><span class="font-semibold text-on-surface">Lokasi:</span> {{ $toko->Lokasi_Toko }}</div>
            <div><span class="font-semibold text-on-surface">Telepon:</span> {{ $toko->Nomer_Telepon_Toko }}</div>
            <div><span class="font-semibold text-on-surface">Pendapatan:</span> Rp {{ number_format($toko->Pendapatan_Toko ?? 0, 0, ',', '.') }}</div>
            <div><span class="font-semibold text-on-surface">Komisi:</span> Rp {{ number_format($toko->Komisi_Admin ?? 0, 0, ',', '.') }}</div>
          </div>
          @if($toko->Status === 'pending')
            <div class="flex gap-2">
              <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=approved" method="POST" class="flex-1"
                onsubmit="return confirm('Setujui pendaftaran toko {{ $toko->Nama_Toko }}?')">
                @csrf @method('PUT')
                <button type="submit" class="w-full text-xs bg-green-50 text-green-600 border border-green-200 py-2 rounded-xl hover:bg-green-100 transition-colors font-bold">
                  Setujui
                </button>
              </form>
              <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=rejected" method="POST" class="flex-1"
                onsubmit="return confirm('Tolak pendaftaran toko {{ $toko->Nama_Toko }}?')">
                @csrf @method('PUT')
                <button type="submit" class="w-full text-xs bg-red-50 text-red-600 border border-red-200 py-2 rounded-xl hover:bg-red-100 transition-colors font-bold">
                  Tolak
                </button>
              </form>
            </div>
          @elseif($toko->Status === 'approved')
            <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=rejected" method="POST"
              onsubmit="return confirm('Nonaktifkan toko {{ $toko->Nama_Toko }}?')">
              @csrf @method('PUT')
              <button type="submit" class="w-full text-sm bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-xl hover:bg-red-100 transition-colors font-bold">
                Nonaktifkan Toko
              </button>
            </form>
          @elseif($toko->Status === 'rejected')
            <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=approved" method="POST"
              onsubmit="return confirm('Aktifkan toko {{ $toko->Nama_Toko }}?')">
              @csrf @method('PUT')
              <button type="submit" class="w-full text-sm bg-green-50 text-green-600 border border-green-200 px-4 py-2 rounded-xl hover:bg-green-100 transition-colors font-bold">
                Aktifkan Toko
              </button>
            </form>
          @elseif($toko->Status === 'expired')
            <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=approved" method="POST"
              onsubmit="return confirm('Aktifkan kembali toko {{ $toko->Nama_Toko }} yang sudah expired?')">
              @csrf @method('PUT')
              <button type="submit" class="w-full text-sm bg-green-50 text-green-600 border border-green-200 px-4 py-2 rounded-xl hover:bg-green-100 transition-colors font-bold">
                Aktifkan Kembali (Expired)
              </button>
            </form>
          @endif
          <div class="pt-2 border-t border-outline-variant/10">
            <button type="button" @click="openModal({{ json_encode($toko) }})"
              class="w-full text-xs bg-secondary/10 text-secondary border border-secondary/20 py-2 rounded-xl hover:bg-secondary/20 transition-colors font-bold flex items-center justify-center gap-1.5">
              <span class="material-symbols-outlined text-[16px]">edit_location</span>
              Edit Lokasi Toko
            </button>
          </div>
        </div>
        @empty
        <div class="p-10 text-center text-on-surface-variant text-sm">Belum ada data toko.</div>
        @endforelse
      </div>

      {{-- Desktop Table --}}
      <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-outline-variant/20 bg-surface-container-low/50">
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Toko</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Kontak</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Lokasi</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pendapatan</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Pembelian</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Komisi</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-center">Status & Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/10">
            @forelse($tokoList as $toko)
            <tr class="hover:bg-surface-container-low/40 transition-colors">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary font-bold text-xs flex items-center justify-center uppercase shrink-0">
                    {{ strtoupper(substr($toko->Nama_Toko, 0, 2)) }}
                  </div>
                  <div>
                    <p class="font-semibold text-on-surface">{{ $toko->Nama_Toko }}</p>
                    <p class="text-xs text-on-surface-variant">{{ $toko->Username }}</p>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <p class="text-xs text-on-surface">{{ $toko->Email_Toko }}</p>
                <p class="text-xs text-on-surface-variant">{{ $toko->Nomer_Telepon_Toko }}</p>
              </td>
              <td class="px-6 py-4 text-xs text-on-surface-variant max-w-[150px] truncate">{{ $toko->Lokasi_Toko ?? '-' }}</td>
              <td class="px-6 py-4 font-semibold text-on-surface text-sm">Rp {{ number_format($toko->Pendapatan_Toko ?? 0, 0, ',', '.') }}</td>
              <td class="px-6 py-4 text-on-surface-variant text-sm">{{ number_format($toko->Total_Pembelian ?? 0, 0, ',', '.') }}</td>
              <td class="px-6 py-4 font-semibold text-primary text-sm">Rp {{ number_format($toko->Komisi_Admin ?? 0, 0, ',', '.') }}</td>
              <td class="px-6 py-4">
                <div class="flex flex-col items-center gap-2">
                  @if($toko->Status === 'approved')
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                      <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Approved
                    </span>
                    <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=rejected" method="POST"
                      onsubmit="return confirm('Nonaktifkan toko {{ $toko->Nama_Toko }}?')">
                      @csrf @method('PUT')
                      <button type="submit" class="text-[11px] bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-100 transition-colors font-bold">
                        Nonaktifkan
                      </button>
                    </form>
                  @elseif($toko->Status === 'pending')
                    <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full mb-1">
                      <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Pending
                    </span>
                    <div class="flex gap-1.5">
                      <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=approved" method="POST"
                        onsubmit="return confirm('Setujui pendaftaran toko {{ $toko->Nama_Toko }}?')">
                        @csrf @method('PUT')
                        <button type="submit" class="text-[11px] bg-green-50 text-green-600 border border-green-200 px-2 py-1 rounded-lg hover:bg-green-100 transition-colors font-bold">
                          Setujui
                        </button>
                      </form>
                      <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=rejected" method="POST"
                        onsubmit="return confirm('Tolak pendaftaran toko {{ $toko->Nama_Toko }}?')">
                        @csrf @method('PUT')
                        <button type="submit" class="text-[11px] bg-red-50 text-red-600 border border-red-200 px-2 py-1 rounded-lg hover:bg-red-100 transition-colors font-bold">
                          Tolak
                        </button>
                      </form>
                    </div>
                  @elseif($toko->Status === 'rejected')
                    <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                      <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Rejected
                    </span>
                    <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=approved" method="POST"
                      onsubmit="return confirm('Aktifkan kembali toko {{ $toko->Nama_Toko }}?')">
                      @csrf @method('PUT')
                      <button type="submit" class="text-[11px] bg-green-50 text-green-600 border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-100 transition-colors font-bold">
                        Aktifkan
                      </button>
                    </form>
                  @elseif($toko->Status === 'expired')
                    <span class="inline-flex items-center gap-1 bg-orange-100 text-orange-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                      <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> Expired
                    </span>
                    <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}?status=approved" method="POST"
                      onsubmit="return confirm('Aktifkan kembali toko {{ $toko->Nama_Toko }} yang sudah expired?')">
                      @csrf @method('PUT')
                      <button type="submit" class="text-[11px] bg-green-50 text-green-600 border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-100 transition-colors font-bold mt-1">
                        Aktifkan
                      </button>
                    </form>
                  @endif
                  <button type="button" @click="openModal({{ json_encode($toko) }})"
                    class="text-[11px] bg-secondary/10 text-secondary border border-secondary/20 px-3 py-1.5 rounded-lg hover:bg-secondary/20 transition-colors font-bold flex items-center gap-1 mt-1">
                    <span class="material-symbols-outlined text-[14px]">edit_location</span>
                    Edit Lokasi
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="px-6 py-12 text-center">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 block mb-2">storefront</span>
                <p class="text-sm text-on-surface-variant">Belum ada toko yang terdaftar.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="px-6 py-4 border-t border-outline-variant/20 bg-surface-container-low/30">
        {{ $tokoList->links() }}
      </div>
    </div>

  </div>

  <!-- Modal Edit Lokasi (Alpine.js) -->
  <div x-show="open" 
       class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-black/60 backdrop-blur-md transition-opacity duration-300"
       x-transition:enter="ease-out duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="ease-in duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       x-cloak>
    
    <div class="relative w-full max-w-4xl bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]"
         @click.away="open = false"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 border-b border-outline-variant/20 flex items-center justify-between bg-surface-container-low/50">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
            <span class="material-symbols-outlined text-[22px]">edit_location</span>
          </div>
          <div>
            <h3 class="font-headline font-bold text-on-surface text-lg">Edit Alamat & Koordinat Toko</h3>
            <p class="text-xs text-on-surface-variant">Toko: <span class="font-bold text-primary" x-text="store.Nama_Toko"></span></p>
          </div>
        </div>
        <button @click="open = false" class="w-9 h-9 rounded-xl hover:bg-surface-container-high text-on-surface-variant flex items-center justify-center transition-colors">
          <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
      </div>

      <!-- Modal Body (Scrollable) -->
      <div class="flex-1 overflow-y-auto p-6 space-y-6">
        
        <!-- Form Fields Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          
          <!-- Left side: Detailed Inputs -->
          <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Provinsi</label>
                <input type="text" x-model="form.provinsi" required
                  class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" />
              </div>
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kota / Kabupaten</label>
                <input type="text" x-model="form.kota" required
                  class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" />
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kecamatan</label>
                <input type="text" x-model="form.kecamatan" required
                  class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" />
              </div>
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kode Pos</label>
                <input type="text" x-model="form.kode_pos" required
                  class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" />
              </div>
            </div>

            <div class="space-y-1">
              <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Detail Alamat Lengkap</label>
              <textarea x-model="form.detail_alamat" rows="2" required
                class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Koordinat Read-only -->
            <div class="grid grid-cols-2 gap-4 bg-surface-container-low/70 p-4 rounded-xl border border-outline-variant/20">
              <div class="flex flex-col">
                <span class="text-[9px] font-black text-outline uppercase tracking-wider mb-0.5">Latitude (Lintang)</span>
                <span class="font-mono text-xs font-bold text-on-surface" x-text="form.latitude"></span>
              </div>
              <div class="flex flex-col">
                <span class="text-[9px] font-black text-outline uppercase tracking-wider mb-0.5">Longitude (Bujur)</span>
                <span class="font-mono text-xs font-bold text-on-surface" x-text="form.longitude"></span>
              </div>
            </div>

            <!-- Search Address Nominatim -->
            <button type="button" @click="searchAddress()" :disabled="loadingSearch"
              class="w-full bg-secondary/10 hover:bg-secondary/20 disabled:opacity-50 text-secondary border border-secondary/20 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5">
              <span class="material-symbols-outlined text-[18px]" :class="loadingSearch && 'animate-spin'" x-text="loadingSearch ? 'autorenew' : 'search'">search</span>
              <span x-text="loadingSearch ? 'Mencari Alamat...' : 'Cari & Sesuaikan Peta'"></span>
            </button>
          </div>

          <!-- Right side: Map container -->
          <div class="flex flex-col h-full min-h-[300px] md:min-h-full">
            <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider mb-1">Pin Point Lokasi Peta</label>
            <div class="flex-1 w-full rounded-2xl border border-outline-variant/30 overflow-hidden relative" style="min-height: 250px;">
              <div id="admin-edit-map" class="absolute inset-0 z-0"></div>
            </div>
            <p class="text-[10px] text-on-surface-variant mt-2 flex items-center gap-1 leading-normal">
              <span class="material-symbols-outlined text-sm text-primary">info</span>
              Seret penanda di peta atau klik lokasi baru untuk memperbarui koordinat GPS.
            </p>
          </div>

        </div>

      </div>

      <!-- Modal Footer -->
      <div class="px-6 py-4 border-t border-outline-variant/20 flex items-center justify-end gap-3 bg-surface-container-low/50">
        <button type="button" @click="open = false"
          class="px-5 py-2.5 rounded-xl border border-outline-variant text-on-surface-variant hover:bg-surface-container-high text-xs font-bold transition-all">
          Batal
        </button>
        <button type="button" @click="submitForm()" :disabled="submitting"
          class="px-5 py-2.5 rounded-xl bg-primary text-on-primary hover:bg-primary-container disabled:opacity-50 text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm">
          <span class="material-symbols-outlined text-[16px]" x-show="!submitting">save</span>
          <span class="material-symbols-outlined text-[16px] animate-spin" x-show="submitting">autorenew</span>
          <span x-text="submitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
        </button>
      </div>

    </div>

  </div>

  @push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('shopeRegistryPage', () => ({
        open: false,
        store: {},
        loadingSearch: false,
        submitting: false,
        map: null,
        marker: null,
        form: {
          provinsi: '',
          kota: '',
          kecamatan: '',
          detail_alamat: '',
          kode_pos: '',
          latitude: '',
          longitude: ''
        },

        openModal(toko) {
          this.store = toko;
          this.form.provinsi = toko.provinsi || '';
          this.form.kota = toko.kota || '';
          this.form.kecamatan = toko.kecamatan || '';
          this.form.detail_alamat = toko.detail_alamat || '';
          this.form.kode_pos = toko.kode_pos || '';
          this.form.latitude = toko.latitude || -5.147665;
          this.form.longitude = toko.longitude || 119.432731;
          
          this.open = true;

          this.$nextTick(() => {
            this.initMap();
          });
        },

        initMap() {
          if (this.map) {
            this.map.remove();
            this.map = null;
          }

          const lat = parseFloat(this.form.latitude);
          const lng = parseFloat(this.form.longitude);

          this.map = L.map('admin-edit-map').setView([lat, lng], 13);

          L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
          }).addTo(this.map);

          this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

          const updateCoords = (newLat, newLng) => {
            this.form.latitude = parseFloat(newLat).toFixed(8);
            this.form.longitude = parseFloat(newLng).toFixed(8);
          };

          this.marker.on('dragend', (e) => {
            const pos = e.target.getLatLng();
            updateCoords(pos.lat, pos.lng);
          });

          this.map.on('click', (e) => {
            this.marker.setLatLng(e.latlng);
            updateCoords(e.latlng.lat, e.latlng.lng);
          });
        },

        searchAddress() {
          const parts = [
            this.form.detail_alamat,
            this.form.kecamatan ? 'Kec. ' + this.form.kecamatan : '',
            this.form.kota,
            this.form.provinsi,
            this.form.kode_pos
          ].filter(Boolean).join(', ');

          if (!parts) {
            alert('Silakan isi alamat lengkap terlebih dahulu!');
            return;
          }

          this.loadingSearch = true;
          fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(parts)}&limit=1`)
            .then(res => res.json())
            .then(data => {
              this.loadingSearch = false;
              if (data && data.length > 0) {
                const newLat = parseFloat(data[0].lat);
                const newLng = parseFloat(data[0].lon);

                this.map.setView([newLat, newLng], 15);
                this.marker.setLatLng([newLat, newLng]);
                this.form.latitude = newLat.toFixed(8);
                this.form.longitude = newLng.toFixed(8);
              } else {
                alert('Lokasi tidak ditemukan pada peta. Silakan klik peta secara manual.');
              }
            })
            .catch(() => {
              this.loadingSearch = false;
              alert('Gagal mencari alamat. Periksa koneksi internet Anda.');
            });
        },

        submitForm() {
          this.submitting = true;
          const url = `/admin/shope-registry/${this.store.ID_Toko}/update-location`;

          fetch(url, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(this.form)
          })
          .then(res => res.json())
          .then(data => {
            this.submitting = false;
            if (data.success) {
              alert(data.message);
              this.open = false;
              window.location.reload();
            } else {
              alert('Gagal memperbarui lokasi: ' + (data.error || 'Terjadi kesalahan'));
            }
          })
          .catch(err => {
            this.submitting = false;
            alert('Terjadi kesalahan koneksi.');
          });
        }
      }));
    });
  </script>
  @endpush

</x-layout-admin>