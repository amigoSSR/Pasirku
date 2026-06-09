<x-layout-admin title="Konfirmasi Komisi">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="text-xs font-black text-primary uppercase tracking-[0.2em] flex items-center gap-1.5 mb-1">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">payments</span>
          Manajemen Platform
        </span>
        <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Konfirmasi Komisi</h1>
        <p class="text-sm text-on-surface-variant mt-1">Kelola dan konfirmasi pembayaran komisi dari toko.</p>
      </div>
      <a href="{{ route('MenuUtamaAdmin') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span> Kembali ke Dashboard
      </a>
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

    {{-- Table --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
      <div class="px-6 py-5 border-b border-outline-variant/20">
        <h2 class="font-headline font-bold text-on-surface">Daftar Pembayaran Komisi</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-outline-variant/20 bg-surface-container-low/50">
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Tanggal</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Toko</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Jumlah Komisi</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Bukti</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/10">
            @forelse($payments as $payment)
            <tr class="hover:bg-surface-container-low/40 transition-colors">
              <td class="px-6 py-4 text-xs">{{ $payment->created_at->format('d M Y, H:i') }}</td>
              <td class="px-6 py-4">
                <p class="font-bold text-on-surface">{{ $payment->toko->Nama_Toko ?? '-' }}</p>
                <p class="text-[10px] text-on-surface-variant">Masa Aktif: {{ $payment->toko->aktif_sampai ? \Carbon\Carbon::parse($payment->toko->aktif_sampai)->format('d M Y') : 'Belum aktif' }}</p>
              </td>
              <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($payment->jumlah_komisi, 0, ',', '.') }}</td>
              <td class="px-6 py-4">
                <a href="{{ Storage::url($payment->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-surface-container border border-outline-variant/30 hover:bg-surface-container-high transition-colors" title="Lihat Bukti">
                  <span class="material-symbols-outlined text-[20px] text-on-surface-variant">receipt_long</span>
                </a>
              </td>
              <td class="px-6 py-4">
                @if($payment->status === 'pending')
                  <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                    Pending
                  </span>
                @elseif($payment->status === 'confirmed')
                  <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                    Confirmed
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                    Rejected
                  </span>
                @endif
              </td>
              <td class="px-6 py-4 text-right">
                @if($payment->status === 'pending')
                  <div class="flex items-center justify-end gap-2">
                    <form action="{{ route('admin.komisi.confirm', $payment->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran ini? Komisi toko akan direset dan masa aktif diperpanjang.')">
                      @csrf @method('PUT')
                      <button type="submit" class="bg-green-50 text-green-600 border border-green-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-100 transition-colors">Terima</button>
                    </form>
                    <form action="{{ route('admin.komisi.reject', $payment->id) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini?')">
                      @csrf @method('PUT')
                      <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition-colors">Tolak</button>
                    </form>
                  </div>
                @else
                  <span class="text-xs text-on-surface-variant italic">Diproses pada {{ $payment->updated_at->format('d M Y') }}</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant text-sm">
                Tidak ada data pembayaran komisi.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      @if($payments->hasPages())
      <div class="px-6 py-4 border-t border-outline-variant/20 bg-surface-container-low/30">
        {{ $payments->links() }}
      </div>
      @endif
    </div>

  </div>

</x-layout-admin>
