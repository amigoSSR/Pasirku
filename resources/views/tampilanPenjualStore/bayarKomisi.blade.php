<x-layout-store title="Bayar Komisi">

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1200px] mx-auto space-y-8" x-data="bayarKomisiPage()">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="text-xs font-black text-primary uppercase tracking-[0.2em] flex items-center gap-1.5 mb-1">
          <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">payments</span>
          Keuangan
        </span>
        <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Pembayaran Komisi</h1>
        <p class="text-sm text-on-surface-variant mt-1">Selesaikan pembayaran komisi Anda untuk memperpanjang masa aktif toko.</p>
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

    {{-- Top Info Row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      {{-- Masa Aktif Info --}}
      <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/20 relative overflow-hidden">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-xl bg-tertiary/10 text-tertiary flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">event_available</span>
          </div>
          <div>
            <h2 class="font-headline font-bold text-on-surface">Masa Aktif Toko</h2>
          </div>
        </div>
        
        <div class="bg-surface-container-low rounded-xl p-4">
          @if(is_null($toko->aktif_sampai))
            <p class="text-sm text-on-surface-variant">Masa aktif belum berjalan. Akan dimulai saat Anda mendapatkan pendapatan pertama.</p>
          @else
            @php
              $sisa = $toko->sisaHariAktif();
              $isExpired = $toko->isExpired();
              $isExpiringSoon = $toko->isExpiringSoon();
            @endphp
            <div class="flex justify-between items-center">
              <div>
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wide">Aktif Sampai</p>
                <p class="font-semibold text-on-surface mt-0.5">{{ \Carbon\Carbon::parse($toko->aktif_sampai)->format('d M Y') }}</p>
              </div>
              <div class="text-right">
                <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wide">Sisa Waktu</p>
                @if($isExpired)
                  <p class="font-bold text-error mt-0.5">Sudah Berakhir</p>
                @else
                  <p class="font-bold {{ $isExpiringSoon ? 'text-error' : 'text-green-600' }} mt-0.5">{{ $sisa }} hari</p>
                @endif
              </div>
            </div>
            @if($isExpired)
              <div class="mt-3 text-xs text-error bg-error/10 p-2 rounded-lg font-medium">Toko Anda dinonaktifkan sementara. Lunasi komisi untuk mengaktifkan kembali.</div>
            @elseif($isExpiringSoon)
              <div class="mt-3 text-xs text-error bg-error/10 p-2 rounded-lg font-medium">Masa aktif akan segera habis. Segera bayar komisi!</div>
            @endif
          @endif
        </div>
        <p class="text-[10px] text-on-surface-variant mt-4 leading-relaxed">
          *Setiap kali pembayaran komisi Anda disetujui, masa aktif toko akan otomatis diperpanjang 1 bulan.
        </p>
      </div>

      {{-- Total Komisi Info --}}
      <div class="bg-primary text-on-primary rounded-2xl p-6 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-on-primary/10 blur-3xl pointer-events-none"></div>
        <div class="flex items-center gap-3 mb-4 relative z-10">
          <div class="w-10 h-10 rounded-xl bg-on-primary/20 text-on-primary flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">account_balance_wallet</span>
          </div>
          <div>
            <h2 class="font-headline font-bold">Tagihan Komisi</h2>
          </div>
        </div>
        
        <div class="relative z-10">
          <p class="text-sm text-on-primary/70 mb-1">Total yang harus dibayar:</p>
          <h3 class="font-headline text-4xl font-extrabold tracking-tight">
            Rp {{ number_format($toko->Komisi_Admin, 0, ',', '.') }}
          </h3>
          @if($toko->Komisi_Admin == 0)
            <div class="mt-4 bg-on-primary/20 text-on-primary text-xs px-3 py-2 rounded-lg inline-flex items-center gap-1.5 font-medium">
              <span class="material-symbols-outlined text-[16px]">check_circle</span>
              Anda tidak memiliki tagihan saat ini.
            </div>
          @endif
        </div>
      </div>

    </div>

    {{-- Payment Section --}}
    @if($toko->Komisi_Admin > 0)
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
      <div class="px-6 py-5 border-b border-outline-variant/20">
        <h2 class="font-headline font-bold text-on-surface text-lg">Lakukan Pembayaran</h2>
      </div>
      
      <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Scan QRIS --}}
        <div class="space-y-4">
          <p class="text-sm font-semibold text-on-surface">1. Scan QRIS Admin</p>
          <p class="text-xs text-on-surface-variant">Silakan scan kode QRIS berikut menggunakan aplikasi m-banking atau e-wallet Anda.</p>
          
          <div class="bg-surface-container-low border border-outline-variant/30 rounded-2xl p-4 flex flex-col items-center justify-center min-h-[300px]">
            @if($qrisAdmin)
              <img src="{{ Storage::url($qrisAdmin) }}" alt="QRIS Admin" 
                   class="max-w-[250px] w-full rounded-xl shadow-sm border border-outline-variant/20 cursor-pointer hover:scale-105 transition-transform"
                   @click="previewImg('{{ Storage::url($qrisAdmin) }}')">
              <p class="text-[10px] text-on-surface-variant mt-3 text-center">Klik gambar untuk memperbesar</p>
            @else
              <div class="text-center space-y-2">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 block">qr_code_scanner</span>
                <p class="text-sm text-on-surface-variant">Admin belum mengunggah QRIS pembayaran.</p>
                <p class="text-xs text-error font-medium">Harap hubungi Admin.</p>
              </div>
            @endif
          </div>
        </div>

        {{-- Upload Bukti --}}
        <div class="space-y-4">
          <p class="text-sm font-semibold text-on-surface">2. Upload Bukti Pembayaran</p>
          
          @if($pendingPayment)
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-center space-y-3">
              <span class="material-symbols-outlined text-yellow-600 text-3xl block">hourglass_top</span>
              <div>
                <p class="font-bold text-yellow-800">Menunggu Konfirmasi Admin</p>
                <p class="text-xs text-yellow-700 mt-1">Anda sudah mengupload bukti pembayaran pada {{ $pendingPayment->created_at->format('d M Y, H:i') }}. Harap tunggu admin memverifikasi.</p>
              </div>
            </div>
          @elseif(!$qrisAdmin)
            <div class="bg-surface-container-low border border-outline-variant/30 rounded-2xl p-8 text-center space-y-3 flex flex-col justify-center items-center min-h-[300px]">
              <span class="material-symbols-outlined text-on-surface-variant/40 text-4xl block">block</span>
              <p class="text-sm font-medium text-on-surface-variant">Formulir dinonaktifkan</p>
              <p class="text-xs text-on-surface-variant">Anda baru bisa mengunggah bukti setelah Admin menyediakan QRIS pembayaran.</p>
            </div>
          @else
            <form action="{{ route('bayarKomisi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
              @csrf
              <div x-data="{ fileName: '', previewUrl: '' }">
                <label class="block mb-2 text-xs font-bold text-on-surface-variant uppercase tracking-wider">File Bukti Transfer</label>
                
                <div class="relative group">
                  <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required accept="image/png, image/jpeg, image/jpg, image/webp"
                         class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                         @change="if($event.target.files.length > 0) { fileName = $event.target.files[0].name; const reader = new FileReader(); reader.onload = (e) => previewUrl = e.target.result; reader.readAsDataURL($event.target.files[0]); } else { fileName = ''; previewUrl = ''; }">
                  
                  <div class="w-full border-2 border-dashed border-outline-variant/40 rounded-2xl p-8 flex flex-col items-center justify-center text-center bg-surface-container-low group-hover:bg-surface-container-high transition-colors"
                       :class="previewUrl ? 'border-primary/50' : ''">
                    
                    <div x-show="!previewUrl">
                      <span class="material-symbols-outlined text-4xl text-on-surface-variant/50 mb-2 block">cloud_upload</span>
                      <p class="text-sm font-medium text-on-surface mb-1">Klik atau tarik file ke sini</p>
                      <p class="text-[10px] text-on-surface-variant">PNG, JPG, WEBP (Max. 5MB)</p>
                    </div>

                    <div x-show="previewUrl" style="display: none;" class="flex flex-col items-center">
                      <img :src="previewUrl" class="h-32 object-contain rounded-lg shadow-sm border border-outline-variant/20 mb-3">
                      <p class="text-xs font-semibold text-primary truncate max-w-[200px]" x-text="fileName"></p>
                      <p class="text-[10px] text-on-surface-variant mt-1">Klik untuk mengganti file</p>
                    </div>

                  </div>
                </div>
                @error('bukti_pembayaran')
                  <p class="text-error text-xs mt-1.5">{{ $message }}</p>
                @enderror
              </div>

              <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/20 text-xs text-on-surface-variant leading-relaxed">
                Pastikan nominal yang Anda transfer sama persis dengan Tagihan Komisi: <strong class="text-on-surface">Rp {{ number_format($toko->Komisi_Admin, 0, ',', '.') }}</strong>
              </div>

              <button type="submit" class="w-full bg-primary text-on-primary hover:bg-primary-container disabled:opacity-50 disabled:cursor-not-allowed px-6 py-3 rounded-xl text-sm font-bold transition-all shadow-sm active:scale-[0.98] duration-200 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">upload</span>
                Upload & Kirim Pembayaran
              </button>
            </form>
          @endif

        </div>
      </div>
    </div>
    @endif

    {{-- History Section --}}
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
      <div class="px-6 py-5 border-b border-outline-variant/20">
        <h2 class="font-headline font-bold text-on-surface">Riwayat Pembayaran Komisi</h2>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead>
            <tr class="border-b border-outline-variant/20 bg-surface-container-low/50">
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Tanggal</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Nominal</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Status</th>
              <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Dikonfirmasi Pada</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-outline-variant/10">
            @forelse($riwayat as $item)
            <tr class="hover:bg-surface-container-low/40 transition-colors">
              <td class="px-6 py-4 text-xs">{{ $item->created_at->format('d M Y, H:i') }}</td>
              <td class="px-6 py-4 font-bold text-on-surface">Rp {{ number_format($item->jumlah_komisi, 0, ',', '.') }}</td>
              <td class="px-6 py-4">
                @if($item->status === 'pending')
                  <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                    Pending
                  </span>
                @elseif($item->status === 'confirmed')
                  <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                    Confirmed
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-black uppercase px-2.5 py-1 rounded-full">
                    Rejected
                  </span>
                @endif
              </td>
              <td class="px-6 py-4 text-xs text-on-surface-variant">
                {{ $item->confirmed_at ? $item->confirmed_at->format('d M Y, H:i') : '-' }}
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant text-sm">
                Belum ada riwayat pembayaran komisi.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Modal Preview QRIS --}}
    <div x-show="imgModalOpen" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm transition-opacity duration-300"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         @click="imgModalOpen = false">
      
      <div class="relative max-w-2xl w-full" @click.stop>
        <button @click="imgModalOpen = false" class="absolute -top-12 right-0 text-white hover:text-primary transition-colors bg-white/10 w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-md">
          <span class="material-symbols-outlined">close</span>
        </button>
        <img :src="currentImgSrc" class="w-full h-auto rounded-2xl shadow-2xl border border-white/20">
      </div>
    </div>

  </div>

  @push('scripts')
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('bayarKomisiPage', () => ({
        imgModalOpen: false,
        currentImgSrc: '',
        
        previewImg(src) {
          this.currentImgSrc = src;
          this.imgModalOpen = true;
        }
      }));
    });
  </script>
  @endpush

</x-layout-store>
