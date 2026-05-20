<x-layout-admin title="Manajemen Toko">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

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
        <p class="font-headline text-2xl font-extrabold text-on-surface mt-1">{{ $tokoList->count() }}</p>
      </div>
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Approved</p>
        <p class="font-headline text-2xl font-extrabold text-green-600 mt-1">{{ $tokoList->where('Status', 'approved')->count() }}</p>
      </div>
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Pending</p>
        <p class="font-headline text-2xl font-extrabold text-yellow-600 mt-1">{{ $tokoList->where('Status', 'pending')->count() }}</p>
      </div>
      <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/20 text-center">
        <p class="text-xs font-semibold text-on-surface-variant uppercase tracking-wide">Total Komisi</p>
        <p class="font-headline text-xl font-extrabold text-primary mt-1">
          Rp {{ number_format($tokoList->sum('Komisi_Admin'), 0, ',', '.') }}
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
          @endif
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
                  @endif
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
    </div>

  </div>

</x-layout-admin>