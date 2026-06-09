<x-layout-store title="Pembayaran QRIS">
  
  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary">Dashboard</a>
      <span class="material-symbols-outlined text-sm">chevron_right</span>
      <span class="text-primary font-semibold">Pembayaran QRIS</span>
    </nav>
  </x-slot>

  <div class="max-w-4xl mx-auto px-6 md:px-8 pb-24 md:pb-10">
    
    <div class="mb-8">
      <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight mb-2">Pembayaran QRIS</h1>
      <p class="text-on-surface-variant text-sm max-w-2xl">
        Unggah gambar kode QRIS toko Anda di sini. Gambar ini akan ditampilkan kepada pembeli pada halaman keranjang saat mereka memilih toko Anda untuk mempercepat proses pembayaran.
      </p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 text-green-800 rounded-xl border border-green-200 text-sm font-semibold">
      <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
      {{ session('success') }}
    </div>
    @endif
    
    @if($errors->any())
    <div class="mb-6 flex items-start gap-3 p-4 bg-red-50 text-red-800 rounded-xl border border-red-200 text-sm font-semibold">
      <span class="material-symbols-outlined text-red-600" style="font-variation-settings:'FILL' 1">error</span>
      <ul class="list-disc ml-4">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      
      {{-- Upload Form --}}
      <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30 flex flex-col justify-between">
        <form method="POST" action="{{ route('qrisStore.update') }}" enctype="multipart/form-data" class="flex-1 flex flex-col h-full">
          @csrf
          @method('PUT')
          <div>
            <h2 class="font-headline text-lg font-bold text-on-surface mb-1">Unggah QRIS</h2>
            <p class="text-xs text-on-surface-variant mb-6">Pilih gambar kode QRIS dari komputer Anda. (Max: 5MB, Format: JPG, PNG, WEBP)</p>

            <div class="relative w-full aspect-square md:aspect-[4/3] rounded-xl border-2 border-dashed border-outline-variant/50 flex flex-col items-center justify-center bg-surface-container-low hover:bg-surface-container hover:border-primary/50 transition-all group overflow-hidden cursor-pointer" onclick="document.getElementById('qris_input').click()">
              
              <div id="upload_placeholder" class="text-center p-4">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                  <span class="material-symbols-outlined text-3xl">upload_file</span>
                </div>
                <p class="font-bold text-sm text-on-surface">Klik untuk memilih gambar</p>
                <p class="text-xs text-on-surface-variant mt-1">Atau tarik dan lepas file di sini</p>
              </div>

              <img id="image_preview" class="hidden absolute inset-0 w-full h-full object-contain bg-white" src="" alt="Preview">
              <input type="file" name="qris_image" id="qris_input" class="hidden" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(event)">
            </div>
          </div>

          <div class="mt-6">
            <button type="submit" class="w-full bg-primary text-on-primary font-bold text-sm py-3 rounded-xl hover:opacity-90 transition-opacity shadow-sm flex justify-center items-center gap-2">
              <span class="material-symbols-outlined text-[20px]">save</span> Simpan QRIS
            </button>
          </div>
        </form>
      </div>

      {{-- Current QRIS Display --}}
      <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30">
        <h2 class="font-headline text-lg font-bold text-on-surface mb-1">QRIS Aktif Saat Ini</h2>
        <p class="text-xs text-on-surface-variant mb-6">Gambar ini yang akan dilihat oleh pelanggan pada halaman checkout mereka.</p>

        @if($toko->Gambar_QRIS)
          <div class="border-2 border-outline-variant/20 rounded-2xl overflow-hidden bg-white aspect-square md:aspect-[4/3] flex items-center justify-center p-4 mb-6 relative group">
            <img src="{{ asset('storage/' . $toko->Gambar_QRIS) }}" alt="QRIS {{ $toko->Nama_Toko }}" class="w-full h-full object-contain">
            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
              <a href="{{ asset('storage/' . $toko->Gambar_QRIS) }}" target="_blank" class="bg-white text-on-surface px-4 py-2 rounded-full font-bold text-xs shadow-md">Lihat Penuh</a>
            </div>
          </div>
          
          <form method="POST" action="{{ route('qrisStore.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar QRIS ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full bg-error/10 text-error font-bold text-sm py-3 rounded-xl border border-error/20 hover:bg-error/20 transition-colors flex justify-center items-center gap-2">
              <span class="material-symbols-outlined text-[20px]">delete</span> Hapus QRIS
            </button>
          </form>
        @else
          <div class="aspect-square md:aspect-[4/3] rounded-2xl border-2 border-dashed border-outline-variant/30 flex flex-col items-center justify-center bg-surface-container-low mb-6">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/40 mb-3">qr_code_scanner</span>
            <p class="font-bold text-on-surface-variant text-sm">QRIS Belum Tersedia</p>
            <p class="text-xs text-on-surface-variant/70 mt-1 px-4 text-center">Anda belum mengunggah gambar QRIS. Silakan unggah pada form di samping.</p>
          </div>
        @endif
      </div>

    </div>
  </div>

  @push('scripts')
  <script>
    function previewImage(event) {
      const input = event.target;
      if (input.files && input.files[0]) {
        if (input.files[0].size > 5 * 1024 * 1024) {
          alert('Ukuran gambar melebihi batas maksimal 5 MB.');
          input.value = '';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          const preview = document.getElementById('image_preview');
          const placeholder = document.getElementById('upload_placeholder');
          
          preview.src = e.target.result;
          preview.classList.remove('hidden');
          placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
  @endpush
</x-layout-store>
