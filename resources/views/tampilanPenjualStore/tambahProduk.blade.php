<x-layout-store title="Tambah Produk">

  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary transition-colors">Dashboard</a>
      <span class="material-symbols-outlined text-xs">chevron_right</span>
      <span class="font-semibold text-primary">Tambah Produk</span>
    </nav>
    <div>
      <h1 class="font-headline text-3xl font-bold text-on-surface">Tambah Produk Baru</h1>
      <p class="text-on-surface-variant text-sm mt-1">Lengkapi informasi produk pasir Anda.</p>
    </div>
  </x-slot>

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-4xl mx-auto">

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div id="alert-success"
         class="flex items-center gap-3 px-5 py-4 mb-6 rounded-2xl bg-green-50 border border-green-200 text-green-700 shadow-sm animate-fadeUp">
      <span class="material-symbols-outlined text-xl" style="font-variation-settings:'FILL' 1">check_circle</span>
      <span class="font-semibold text-sm">{{ session('success') }}</span>
      <button onclick="document.getElementById('alert-success').remove()"
              class="ml-auto text-green-500 hover:text-green-700 transition-colors">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>
    </div>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if($errors->any())
    <div id="alert-error"
         class="flex items-start gap-3 px-5 py-4 mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-700 shadow-sm animate-fadeUp">
      <span class="material-symbols-outlined text-xl shrink-0 mt-0.5" style="font-variation-settings:'FILL' 1">error</span>
      <div class="flex-1">
        <p class="font-semibold text-sm mb-1">Terdapat kesalahan, mohon periksa kembali:</p>
        <ul class="list-disc list-inside text-xs space-y-0.5">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
      <button onclick="document.getElementById('alert-error').remove()"
              class="text-red-400 hover:text-red-600 transition-colors shrink-0">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>
    </div>
    @endif

    {{-- Form Card --}}
    <form action="{{ route('tambahProduk.store') }}" method="POST" enctype="multipart/form-data"
          class="space-y-6">
      @csrf

      {{-- ===== INFORMASI DASAR ===== --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-9 h-9 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">info</span>
          </div>
          <div>
            <h2 class="font-headline font-bold text-base text-on-surface">Informasi Dasar</h2>
            <p class="text-xs text-on-surface-variant">Nama, kategori, dan deskripsi produk</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

          {{-- Nama Pasir --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Nama_Pasir">
              Nama Pasir <span class="text-error">*</span>
            </label>
            <input id="Nama_Pasir" name="Nama_Pasir" type="text"
                   value="{{ old('Nama_Pasir') }}"
                   placeholder="Contoh: Pasir Cor Premium, Pasir Halus Putih..."
                   class="w-full px-4 py-3 rounded-xl border text-sm
                          {{ $errors->has('Nama_Pasir') ? 'border-error bg-error-container/20 text-on-surface' : 'border-outline-variant bg-surface-container-low text-on-surface' }}
                          focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all placeholder:text-on-surface-variant/50">
            @error('Nama_Pasir')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

          {{-- Kategori --}}
          <div>
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Kategori">
              Kategori <span class="text-error">*</span>
            </label>
            <div class="relative">
              <select id="Kategori" name="Kategori"
                      class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border text-sm
                             {{ $errors->has('Kategori') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                             text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all cursor-pointer">
                <option value="">— Pilih Kategori —</option>
                @foreach(['Pasir Cor','Pasir Halus','Pasir Urug','Pasir Bata','Batu Split','Batu Kali','Kerikil','Lainnya'] as $kat)
                  <option value="{{ $kat }}" {{ old('Kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
              </select>
              <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
            </div>
            @error('Kategori')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

          {{-- Satuan --}}
          <div>
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Satuan">
              Satuan <span class="text-error">*</span>
            </label>
            <div class="relative">
              <select id="Satuan" name="Satuan"
                      class="w-full appearance-none px-4 py-3 pr-10 rounded-xl border text-sm
                             {{ $errors->has('Satuan') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                             text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all cursor-pointer">
                <option value="">— Pilih Satuan —</option>
                @foreach(['m³','ton','kg','ritase','unit'] as $sat)
                  <option value="{{ $sat }}" {{ old('Satuan', 'm³') === $sat ? 'selected' : '' }}>{{ $sat }}</option>
                @endforeach
              </select>
              <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
            </div>
            @error('Satuan')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

          {{-- Deskripsi --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Deskripsi">
              Deskripsi Produk
            </label>
            <textarea id="Deskripsi" name="Deskripsi" rows="4"
                      placeholder="Jelaskan karakteristik, kegunaan, atau keunggulan pasir ini..."
                      class="w-full px-4 py-3 rounded-xl border text-sm resize-none
                             {{ $errors->has('Deskripsi') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                             text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all placeholder:text-on-surface-variant/50">{{ old('Deskripsi') }}</textarea>
            <p class="mt-1 text-xs text-on-surface-variant">Maks. 1000 karakter.</p>
            @error('Deskripsi')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

        </div>
      </div>

      {{-- ===== HARGA & STOK ===== --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-9 h-9 bg-secondary/10 rounded-xl flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-secondary text-[18px]" style="font-variation-settings:'FILL' 1">payments</span>
          </div>
          <div>
            <h2 class="font-headline font-bold text-base text-on-surface">Harga & Stok</h2>
            <p class="text-xs text-on-surface-variant">Atur harga dan ketersediaan stok</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

          {{-- Harga Pick Up --}}
          <div>
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Harga_PickUp">
              Harga Pick Up (Rp) <span class="text-error">*</span>
            </label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-semibold text-sm">Rp</span>
              <input id="Harga_PickUp" name="Harga_PickUp" type="number" min="0"
                     value="{{ old('Harga_PickUp') }}"
                     placeholder="0"
                     class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm
                            {{ $errors->has('Harga_PickUp') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                            text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
            </div>
            @error('Harga_PickUp')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

          {{-- Harga Truck --}}
          <div>
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Harga_Truck">
              Harga Truck (Rp) <span class="text-error">*</span>
            </label>
            <div class="relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-semibold text-sm">Rp</span>
              <input id="Harga_Truck" name="Harga_Truck" type="number" min="0"
                     value="{{ old('Harga_Truck') }}"
                     placeholder="0"
                     class="w-full pl-10 pr-4 py-3 rounded-xl border text-sm
                            {{ $errors->has('Harga_Truck') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                            text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
            </div>
            @error('Harga_Truck')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

          {{-- Stok Pick Up --}}
          <div>
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Stock_PickUp">
              Stok Pick Up <span class="text-error">*</span>
            </label>
            <input id="Stock_PickUp" name="Stock_PickUp" type="number" min="0"
                   value="{{ old('Stock_PickUp', 0) }}"
                   class="w-full px-4 py-3 rounded-xl border text-sm
                          {{ $errors->has('Stock_PickUp') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                          text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
            @error('Stock_PickUp')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

          {{-- Stok Truck --}}
          <div>
            <label class="block text-sm font-semibold text-on-surface mb-1.5" for="Stock_Truck">
              Stok Truck <span class="text-error">*</span>
            </label>
            <input id="Stock_Truck" name="Stock_Truck" type="number" min="0"
                   value="{{ old('Stock_Truck', 0) }}"
                   class="w-full px-4 py-3 rounded-xl border text-sm
                          {{ $errors->has('Stock_Truck') ? 'border-error bg-error-container/20' : 'border-outline-variant bg-surface-container-low' }}
                          text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
            @error('Stock_Truck')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

        </div>
      </div>

      {{-- ===== GAMBAR ===== --}}
      <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-9 h-9 bg-tertiary/10 rounded-xl flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-tertiary text-[18px]" style="font-variation-settings:'FILL' 1">photo_camera</span>
          </div>
          <div>
            <h2 class="font-headline font-bold text-base text-on-surface">Gambar Produk</h2>
            <p class="text-xs text-on-surface-variant">Foto produk pasir Anda</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          {{-- Upload Gambar --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-on-surface mb-1.5">
              Foto Produk
            </label>
            {{-- Drop Zone --}}
            <div id="dropzone"
                 class="relative border-2 border-dashed border-outline-variant rounded-2xl p-6 text-center transition-all duration-200 hover:border-primary/60 hover:bg-primary/5 cursor-pointer group">
              <input id="Gambar" name="Gambar" type="file" accept="image/*"
                     class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                     onchange="previewGambar(event)">

              {{-- Placeholder State --}}
              <div id="preview-placeholder">
                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-primary/20 transition-colors">
                  <span class="material-symbols-outlined text-primary text-3xl">image</span>
                </div>
                <p class="text-sm font-semibold text-on-surface">Klik atau seret gambar ke sini</p>
                <p class="text-xs text-on-surface-variant mt-1">JPG, PNG, WEBP · Maks. 2 MB</p>
              </div>

              {{-- Preview State --}}
              <div id="preview-image-wrapper" class="hidden">
                <img id="preview-image" src="" alt="Preview" class="max-h-48 mx-auto rounded-xl object-cover shadow-md mb-3">
                <p id="preview-filename" class="text-xs text-on-surface-variant font-medium"></p>
                <button type="button" onclick="resetGambar()"
                        class="mt-2 text-xs text-error hover:underline font-semibold">
                  Hapus Gambar
                </button>
              </div>
            </div>

            @error('Gambar')
              <p class="mt-1.5 text-xs text-error flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">error</span>{{ $message }}
              </p>
            @enderror
          </div>

        </div>
      </div>

      {{-- ===== ACTION BUTTONS ===== --}}
      <div class="flex flex-col sm:flex-row gap-3 justify-end">
        <a href="{{ route('MenuUtamaStore') }}"
           class="flex items-center justify-center gap-2 px-6 py-3 rounded-xl border border-outline-variant text-on-surface-variant text-sm font-semibold hover:bg-surface-container-low transition-all">
          <span class="material-symbols-outlined text-[18px]">arrow_back</span>
          Batal
        </a>
        <button type="submit"
                class="flex items-center justify-center gap-2 px-8 py-3 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-md shadow-primary/20 active:scale-[0.98]">
          <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">add_box</span>
          Simpan Produk
        </button>
      </div>

    </form>
  </div>

  @push('scripts')
  <script>
    function previewGambar(event) {
      const file = event.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('preview-placeholder').classList.add('hidden');
        const wrapper = document.getElementById('preview-image-wrapper');
        wrapper.classList.remove('hidden');
        document.getElementById('preview-image').src = e.target.result;
        document.getElementById('preview-filename').textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
      };
      reader.readAsDataURL(file);
    }

    function resetGambar() {
      document.getElementById('Gambar').value = '';
      document.getElementById('preview-placeholder').classList.remove('hidden');
      document.getElementById('preview-image-wrapper').classList.add('hidden');
      document.getElementById('preview-image').src = '';
      document.getElementById('preview-filename').textContent = '';
    }

    // Auto-dismiss success alert
    setTimeout(() => {
      const el = document.getElementById('alert-success');
      if (el) el.style.transition = 'opacity 0.5s', el.style.opacity = '0', setTimeout(() => el.remove(), 500);
    }, 4000);
  </script>
  @endpush

</x-layout-store>
