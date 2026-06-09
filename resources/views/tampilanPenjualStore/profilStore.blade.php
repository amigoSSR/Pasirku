@push('head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
@endpush

<x-layout-store title="Store Profile">
  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary">Dashboard</a>
      <span class="material-symbols-outlined text-sm">chevron_right</span>
      <span class="text-primary font-semibold">Profil Toko</span>
    </nav>
  </x-slot>

  <div class="max-w-5xl mx-auto px-6 md:px-8 mt-4 space-y-4">
    @if(session('success'))
      <div class="flex items-center gap-3 p-4 bg-green-50 text-green-800 rounded-xl border border-green-200 text-sm font-semibold animate-fade-in">
        <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="flex items-center gap-3 p-4 bg-red-50 text-red-800 rounded-xl border border-red-200 text-sm font-semibold animate-fade-in">
        <span class="material-symbols-outlined text-red-600" style="font-variation-settings:'FILL' 1">error</span>
        {{ session('error') }}
      </div>
    @endif
    @if($errors->any())
      <div class="p-4 bg-red-50 text-red-800 rounded-xl border border-red-200 text-sm font-semibold animate-fade-in">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  <div class="h-40 md:h-52 w-full relative overflow-hidden" style="background: linear-gradient(135deg, #944a00 0%, #e67e22 100%);">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-10 w-48 h-48 bg-black/10 rounded-full blur-2xl translate-y-1/3"></div>
  </div>

  <div class="max-w-5xl mx-auto px-6 md:px-8 -mt-16 relative z-10 pb-24 md:pb-10">
    <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-6 md:p-8 mb-8 flex flex-col md:flex-row gap-6 md:items-end">
      <div class="relative shrink-0 -mt-16 md:-mt-20 group">
        <div class="w-28 h-28 md:h-36 md:w-36 rounded-2xl border-4 border-surface-container-lowest overflow-hidden shadow-md bg-white relative">
          @if($toko->Foto_Toko)
            <img alt="Store Avatar" class="w-full h-full object-cover" src="{{ asset('storage/' . $toko->Foto_Toko) }}" id="preview-foto" />
          @else
            <img alt="Store Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5PQtLotEWu5Gayn3BYAklIw_RIGZZ9W4Va4b6CgPo1Vc63rl0AsarywWh0O9JeqvGNBy29ZhR37zpxw7Q0D0wegVj9ndr7ki257XmzjvsTQy7_qy8VSbS_MHwpnPd9RerrDoWwWtRWGEmvoYFpJ01SL9PYZ2WPsMMI4oMTZ00pq-oQqnM6jidyCFcHRED5qU1xDteSLy8EbgbL9ZKOPqKvdE0WJ7tcwp7m8eEKUnZVhCh7I8yJyvHQBnB1Qi_SRypz1rveyUHZQ" id="preview-foto" />
          @endif
          
          {{-- Overlay Upload --}}
          <form action="{{ route('ProfilStore.updatePhoto') }}" method="POST" enctype="multipart/form-data" id="form-foto" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
            @csrf
            <label for="foto_toko" class="cursor-pointer flex flex-col items-center">
              <span class="material-symbols-outlined text-white text-3xl">add_a_photo</span>
              <span class="text-white text-[10px] font-bold uppercase mt-1">Ganti Foto</span>
            </label>
            <input type="file" name="foto_toko" id="foto_toko" class="hidden" onchange="document.getElementById('form-foto').submit()" accept="image/*" />
          </form>
        </div>
        <div class="absolute -bottom-2 -right-2 bg-green-500 text-white w-8 h-8 rounded-full border-4 border-surface-container-lowest flex items-center justify-center shadow-sm">
          <span class="material-symbols-outlined text-[16px]">check</span>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
          <span class="bg-primary-fixed/30 text-primary px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">Premium Seller</span>
          <span class="bg-surface-container-high text-on-surface-variant px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
            <span class="material-symbols-outlined text-[12px]">location_on</span> {{ $toko->kota ?? 'Jakarta' }}
          </span>
        </div>
        <h2 class="font-headline text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight">{{ $toko->Nama_Toko ?? 'Nama Toko Anda' }}</h2>
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

      {{-- Form Informasi Dasar Toko --}}
      <div class="md:col-span-2 lg:col-span-3 bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-sm border border-outline-variant/30">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-11 h-11 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">info</span>
          </div>
          <div>
            <h3 class="font-headline text-xl font-bold text-on-surface">Informasi Dasar Toko</h3>
            <p class="text-on-surface-variant text-sm mt-0.5">Kelola identitas utama toko Anda seperti nama, kontak, dan foto profil toko.</p>
          </div>
        </div>

        <form action="{{ route('ProfilStore.updateGeneralInfo') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          @csrf
          <div class="lg:col-span-2 space-y-4">
            <div class="flex flex-col gap-1.5">
              <label for="Nama_Toko" class="text-xs font-bold text-outline uppercase tracking-wider">Nama Toko</label>
              <input type="text" id="Nama_Toko" name="Nama_Toko" value="{{ old('Nama_Toko', $toko->Nama_Toko) }}" required
                class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                placeholder="Masukkan nama toko Anda" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label for="Nomer_Telepon_Toko" class="text-xs font-bold text-outline uppercase tracking-wider">No. WhatsApp / Telepon</label>
                <input type="tel" id="Nomer_Telepon_Toko" name="Nomer_Telepon_Toko" value="{{ old('Nomer_Telepon_Toko', $toko->Nomer_Telepon_Toko) }}" required
                  class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                  placeholder="Contoh: 08123456789" />
              </div>
              <div class="flex flex-col gap-1.5">
                <label for="Email_Toko" class="text-xs font-bold text-outline uppercase tracking-wider">Email Toko</label>
                <input type="email" id="Email_Toko" name="Email_Toko" value="{{ old('Email_Toko', $toko->Email_Toko) }}" required
                  class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                  placeholder="Contoh: toko@email.com" />
              </div>
            </div>

            <button type="submit"
              class="w-full md:w-auto bg-primary text-on-primary hover:bg-primary-container py-3.5 px-8 rounded-xl text-sm font-black transition-all shadow-md flex items-center justify-center gap-1.5 active:scale-95 duration-200">
              <span class="material-symbols-outlined text-[18px]">save</span>
              Simpan Perubahan
            </button>
          </div>

          {{-- Sidebar Edit Foto --}}
          <div class="flex flex-col items-center gap-4 p-6 bg-surface-container-low/40 rounded-2xl border border-outline-variant/20">
            <span class="text-xs font-bold text-outline uppercase tracking-wider self-start">Foto Profil Toko</span>
            <div class="w-32 h-32 rounded-2xl overflow-hidden border-2 border-primary/20 bg-white relative group">
              @if($toko->Foto_Toko)
                <img src="{{ asset('storage/' . $toko->Foto_Toko) }}" class="w-full h-full object-cover" alt="Preview Foto">
              @else
                <div class="w-full h-full flex items-center justify-center bg-primary/5">
                  <span class="material-symbols-outlined text-4xl text-primary/30">storefront</span>
                </div>
              @endif
              <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                 <span class="material-symbols-outlined text-white">photo_camera</span>
              </div>
            </div>
            <p class="text-[10px] text-center text-on-surface-variant leading-relaxed">Gunakan foto berkualitas tinggi agar toko Anda terlihat lebih profesional di mata pelanggan.</p>
            <button type="button" onclick="document.getElementById('foto_toko').click()"
              class="w-full bg-surface-container-high text-on-surface hover:bg-surface-container-highest py-2.5 rounded-xl text-xs font-bold transition-all border border-outline-variant/30 flex items-center justify-center gap-2">
              <span class="material-symbols-outlined text-sm">upload</span>
              Ganti Foto Toko
            </button>
          </div>
        </form>
      </div>

      {{-- Form Alamat & Lokasi Map Toko --}}
      <div class="md:col-span-2 lg:col-span-3 bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-sm border border-outline-variant/30">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-11 h-11 bg-primary/10 text-primary rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl" style="font-variation-settings:'FILL' 1">map</span>
          </div>
          <div>
            <h3 class="font-headline text-xl font-bold text-on-surface">Alamat & Lokasi Map Toko</h3>
            <p class="text-on-surface-variant text-sm mt-0.5">Tentukan alamat terstruktur dan pin lokasi toko Anda pada peta untuk mempermudah perhitungan ongkir dan checkout pelanggan.</p>
          </div>
        </div>

        <form action="{{ route('ProfilStore.updateAddress') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          @csrf
          
          {{-- Kolom Kiri: Form Input --}}
          <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label for="provinsi" class="text-xs font-bold text-outline uppercase tracking-wider">Provinsi</label>
                <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi', $toko->provinsi) }}" required
                  class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                  placeholder="Contoh: Sulawesi Selatan" />
              </div>
              <div class="flex flex-col gap-1.5">
                <label for="kota" class="text-xs font-bold text-outline uppercase tracking-wider">Kota / Kabupaten</label>
                <input type="text" id="kota" name="kota" value="{{ old('kota', $toko->kota) }}" required
                  class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                  placeholder="Contoh: Makassar" />
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex flex-col gap-1.5">
                <label for="kecamatan" class="text-xs font-bold text-outline uppercase tracking-wider">Kecamatan</label>
                <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $toko->kecamatan) }}" required
                  class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                  placeholder="Contoh: Tamalate" />
              </div>
              <div class="flex flex-col gap-1.5">
                <label for="kode_pos" class="text-xs font-bold text-outline uppercase tracking-wider">Kode Pos</label>
                <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $toko->kode_pos) }}" required
                  class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40"
                  placeholder="Contoh: 90224" />
              </div>
            </div>

            <div class="flex flex-col gap-1.5">
              <label for="detail_alamat" class="text-xs font-bold text-outline uppercase tracking-wider">Detail Alamat Lengkap</label>
              <textarea id="detail_alamat" name="detail_alamat" required rows="3"
                class="bg-surface-container-low border-0 border-b-2 border-transparent focus:border-primary focus:ring-0 rounded-xl px-4 py-3 text-sm text-on-surface transition-all placeholder-on-surface-variant/40 resize-none"
                placeholder="Contoh: Jl. Alauddin Raya No. 102, di samping Alfamart atau seberang masjid">{{ old('detail_alamat', $toko->detail_alamat) }}</textarea>
            </div>

            {{-- Koordinat Maps (Read-Only / Sync dengan Map) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-surface-container-low/55 p-4 rounded-xl border border-outline-variant/20">
              <div class="flex flex-col gap-1">
                <label for="latitude" class="text-[10px] font-black text-outline uppercase tracking-wider">Latitude (Lintang)</label>
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $toko->latitude) }}" required readonly
                  class="bg-transparent border-0 font-mono text-xs font-bold text-on-surface focus:ring-0 p-0" />
              </div>
              <div class="flex flex-col gap-1">
                <label for="longitude" class="text-[10px] font-black text-outline uppercase tracking-wider">Longitude (Bujur)</label>
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $toko->longitude) }}" required readonly
                  class="bg-transparent border-0 font-mono text-xs font-bold text-on-surface focus:ring-0 p-0" />
              </div>
            </div>

            <div class="flex gap-3">
              <button type="button" id="btn-lookup"
                class="flex-1 bg-secondary/10 hover:bg-secondary/20 text-secondary border border-secondary/20 py-3.5 px-4 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">search</span>
                Cari Alamat di Peta
              </button>
              <button type="submit"
                class="flex-1 bg-primary text-on-primary hover:bg-primary-container py-3.5 px-4 rounded-xl text-sm font-black transition-all shadow-md flex items-center justify-center gap-1.5 active:scale-95 duration-200">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Lokasi
              </button>
            </div>
          </div>

          {{-- Kolom Kanan: Peta Interaktif Leaflet --}}
          <div class="flex flex-col gap-2 h-full min-h-[300px]">
            <span class="text-xs font-bold text-outline uppercase tracking-wider">Tampilan Peta Interaktif</span>
            <div id="map" class="h-full min-h-[350px] w-full rounded-2xl border border-outline-variant/30 overflow-hidden shadow-inner relative z-0"></div>
            <p class="text-[11px] text-on-surface-variant flex items-center gap-1">
              <span class="material-symbols-outlined text-sm text-primary">info</span>
              Klik di peta atau geser (drag) penanda (marker) untuk menyesuaikan titik koordinat tepat toko Anda.
            </p>
          </div>
        </form>
      </div>

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

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Ambil koordinat awal atau default ke Jakarta / center
      let lat = {{ $toko->latitude ?? -6.2088 }};
      let lng = {{ $toko->longitude ?? 106.8456 }};
      
      const map = L.map('map').setView([lat, lng], 13);
      
      L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
      }).addTo(map);

      // Buat marker yang bisa digeser (draggable)
      const marker = L.marker([lat, lng], { draggable: true }).addTo(map);

      // Fungsi update input form koordinat
      function updateCoordinates(newLat, newLng) {
        document.getElementById('latitude').value = parseFloat(newLat).toFixed(8);
        document.getElementById('longitude').value = parseFloat(newLng).toFixed(8);
      }

      // Inisialisasi value form pertama kali jika masih kosong
      if(!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
        updateCoordinates(lat, lng);
      }

      // Event geser marker
      marker.on('dragend', function (e) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
      });

      // Event klik peta
      map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
      });

      // Geocoding / Lookup Address via Nominatim
      document.getElementById('btn-lookup').addEventListener('click', () => {
        const provinsi = document.getElementById('provinsi').value.trim();
        const kota = document.getElementById('kota').value.trim();
        const kecamatan = document.getElementById('kecamatan').value.trim();
        const detail = document.getElementById('detail_alamat').value.trim();
        
        const query = [detail, kecamatan, kota, provinsi].filter(Boolean).join(', ');
        if(!query) {
          alert('Silakan isi detail alamat terlebih dahulu!');
          return;
        }

        const btn = document.getElementById('btn-lookup');
        btn.disabled = true;
        btn.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">autorenew</span> Mencari...`;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
          .then(res => res.json())
          .then(data => {
            btn.disabled = false;
            btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">search</span> Cari Alamat di Peta`;

            if(data && data.length > 0) {
              const newLat = parseFloat(data[0].lat);
              const newLng = parseFloat(data[0].lon);
              
              map.setView([newLat, newLng], 15);
              marker.setLatLng([newLat, newLng]);
              updateCoordinates(newLat, newLng);
            } else {
              alert('Lokasi tidak ditemukan. Harap periksa kembali ejaan alamat Anda, atau Anda bisa langsung mengklik titik lokasi pada peta.');
            }
          })
          .catch(() => {
            btn.disabled = false;
            btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">search</span> Cari Alamat di Peta`;
            alert('Gagal menghubungi layanan peta. Coba lagi nanti.');
          });
      });
    });
  </script>
@endpush

</x-layout-store>