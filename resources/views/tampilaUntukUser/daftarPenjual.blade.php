<x-layout-user title="Daftar Penjual">

  @push('leaflet-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  @endpush

  @push('leaflet-js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  @endpush

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
        <form action="{{ route('daftarPenjual.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
          @csrf

          <div class="space-y-1.5">
            <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Foto Toko</label>
            <div class="flex items-center gap-4 p-4 bg-surface-container-low rounded-xl border border-outline-variant/20">
              <div id="foto-preview-container" class="w-16 h-16 rounded-lg bg-surface-container flex items-center justify-center overflow-hidden border border-outline-variant/30">
                <span class="material-symbols-outlined text-outline">add_a_photo</span>
              </div>
              <div class="flex-1">
                <input type="file" name="foto_toko" id="foto_toko" class="hidden" accept="image/*" onchange="previewFoto(this)" />
                <label for="foto_toko" class="bg-primary/10 text-primary px-4 py-2 rounded-lg text-xs font-bold cursor-pointer hover:bg-primary/20 transition-colors inline-block">
                  Pilih Foto
                </label>
                <p class="text-[10px] text-on-surface-variant mt-1.5">Maksimal 2MB (JPG, PNG)</p>
              </div>
            </div>
          </div>

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
            <div class="relative group">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] group-focus-within:text-primary transition-colors">location_on</span>
              <input id="Lokasi_Toko" name="Lokasi_Toko" autocomplete="off"
                class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl pl-10 pr-12 py-3 text-sm text-on-surface placeholder:text-outline/50 focus:ring-2 focus:ring-primary/20 focus:border-primary/30 outline-none transition-all" 
                placeholder="Alamat lengkap operasional" type="text" required value="{{ old('Lokasi_Toko') }}" />
              <button type="button" id="btn-locate-me" class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors" title="Gunakan Lokasi Saat Ini">
                <span class="material-symbols-outlined text-[20px]">my_location</span>
              </button>
            </div>
            <div id="search-suggestions" class="hidden absolute left-0 right-0 z-[100] mt-1 bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-xl overflow-hidden"></div>
          </div>

          {{-- Koordinat Maps (Read-Only / Sync dengan Map) --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-surface-container-low/55 p-4 rounded-xl border border-outline-variant/20">
            <div class="flex flex-col gap-1.5">
              <label for="latitude" class="text-[10px] font-black text-outline uppercase tracking-wider">Latitude (Lintang)</label>
              <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" required readonly
                class="bg-transparent border-0 font-mono text-xs font-bold text-on-surface focus:ring-0 p-0" />
            </div>
            <div class="flex flex-col gap-1.5">
              <label for="longitude" class="text-[10px] font-black text-outline uppercase tracking-wider">Longitude (Bujur)</label>
              <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" required readonly
                class="bg-transparent border-0 font-mono text-xs font-bold text-on-surface focus:ring-0 p-0" />
            </div>
          </div>

          {{-- Map & Lookup --}}
          <div class="space-y-3">
            <button type="button" id="btn-lookup"
              class="w-full bg-primary text-on-primary hover:bg-primary-container py-3 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 shadow-sm active:scale-[0.98]">
              <span class="material-symbols-outlined text-[18px]">search</span>
              Cari & Plot di Peta
            </button>
            <div id="map" class="h-64 w-full rounded-2xl border border-outline-variant/30 overflow-hidden shadow-inner relative z-0"></div>
            <p class="text-[10px] text-on-surface-variant flex items-center gap-1 leading-normal">
              <span class="material-symbols-outlined text-sm text-primary">info</span>
              Klik di peta atau geser (drag) penanda (marker) untuk menyesuaikan titik lokasi tepat toko Anda.
            </p>
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

@push('scripts')
<script>
  function previewFoto(input) {
    const container = document.getElementById('foto-preview-container');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Koordinat default (Makassar)
    let defaultLat = -5.147665;
    let defaultLng = 119.432731;

    // Ambil old value jika valid
    let initialLat = {{ old('latitude') ? old('latitude') : 'null' }};
    let initialLng = {{ old('longitude') ? old('longitude') : 'null' }};

    let lat = initialLat || defaultLat;
    let lng = initialLng || defaultLng;

    const map = L.map('map').setView([lat, lng], 13);

    L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
      maxZoom: 20,
      subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    // Buat marker draggable
    const marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    function updateCoordinates(newLat, newLng) {
      document.getElementById('latitude').value = parseFloat(newLat).toFixed(8);
      document.getElementById('longitude').value = parseFloat(newLng).toFixed(8);
    }

    function reverseGeocode(latitude, longitude) {
      fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&addressdetails=1`)
        .then(res => res.json())
        .then(data => {
          if (data && data.display_name) {
            document.getElementById('Lokasi_Toko').value = data.display_name;
          }
        })
        .catch(err => console.error('Reverse Geocode Error:', err));
    }

    // Set nilai awal jika kosong
    if (!document.getElementById('latitude').value || !document.getElementById('longitude').value) {
      updateCoordinates(lat, lng);
    }

    // Event drag marker
    marker.on('dragend', function (e) {
      const position = marker.getLatLng();
      updateCoordinates(position.lat, position.lng);
      reverseGeocode(position.lat, position.lng);
    });

    // Event klik map
    map.on('click', function (e) {
      marker.setLatLng(e.latlng);
      updateCoordinates(e.latlng.lat, e.latlng.lng);
      reverseGeocode(e.latlng.lat, e.latlng.lng);
    });

    const btnLookup = document.getElementById('btn-lookup');
    const suggestionsCont = document.getElementById('search-suggestions');
    const inputLokasi = document.getElementById('Lokasi_Toko');

    function selectLocation(lat, lon, displayName) {
      const la = parseFloat(lat), lo = parseFloat(lon);
      map.setView([la, lo], 15);
      marker.setLatLng([la, lo]);
      updateCoordinates(la, lo);
      inputLokasi.value = displayName;
      suggestionsCont.classList.add('hidden');
    }

    // Geocoding / Lookup Address via Nominatim
    btnLookup.addEventListener('click', () => {
      const query = inputLokasi.value.trim();
      if (!query) {
        alert('Silakan isi alamat lokasi toko terlebih dahulu!');
        return;
      }

      btnLookup.disabled = true;
      btnLookup.innerHTML = `<span class="material-symbols-outlined text-[18px] animate-spin">autorenew</span> Mencari...`;

      fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&countrycodes=id&addressdetails=1`)
        .then(res => res.json())
        .then(data => {
          btnLookup.disabled = false;
          btnLookup.innerHTML = `<span class="material-symbols-outlined text-[18px]">search</span> Cari & Plot di Peta`;

          if (data && data.length > 0) {
            suggestionsCont.innerHTML = '';
            data.forEach(item => {
              const div = document.createElement('div');
              div.className = 'px-4 py-3 hover:bg-surface-container-low cursor-pointer border-b border-outline-variant/10 text-sm flex items-start gap-3 transition-colors';
              div.innerHTML = `
                <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">location_on</span>
                <div class="flex-1 min-w-0">
                  <p class="font-bold text-on-surface leading-tight truncate">${item.display_name.split(',')[0]}</p>
                  <p class="text-[10px] text-on-surface-variant mt-0.5 line-clamp-2">${item.display_name}</p>
                </div>
              `;
              div.onclick = () => selectLocation(item.lat, item.lon, item.display_name);
              suggestionsCont.appendChild(div);
            });
            suggestionsCont.classList.remove('hidden');
            
            if (data.length === 1) {
              selectLocation(data[0].lat, data[0].lon, data[0].display_name);
            }
          } else {
            alert('Lokasi tidak ditemukan pada peta. Anda dapat mengklik lokasi secara manual pada peta.');
          }
        })
        .catch(() => {
          btnLookup.disabled = false;
          btnLookup.innerHTML = `<span class="material-symbols-outlined text-[18px]">search</span> Cari & Plot di Peta`;
          alert('Gagal menghubungi layanan peta. Coba lagi nanti.');
        });
    });

    // Locate Me
    const btnLocate = document.getElementById('btn-locate-me');
    btnLocate.addEventListener('click', () => {
      if (!navigator.geolocation) return alert('Browser Anda tidak mendukung geolokasi.');
      
      const icon = btnLocate.querySelector('.material-symbols-outlined');
      icon.classList.add('animate-spin');
      
      navigator.geolocation.getCurrentPosition((pos) => {
        icon.classList.remove('animate-spin');
        const { latitude, longitude } = pos.coords;
        
        map.setView([latitude, longitude], 15);
        marker.setLatLng([latitude, longitude]);
        updateCoordinates(latitude, longitude);
        
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&addressdetails=1`)
          .then(res => res.json())
          .then(data => {
            if (data && data.display_name) inputLokasi.value = data.display_name;
          });
      }, (err) => {
        icon.classList.remove('animate-spin');
        alert('Gagal mendapatkan lokasi Anda. Pastikan GPS aktif dan izin diberikan.');
      });
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', (e) => {
      if (suggestionsCont && !suggestionsCont.contains(e.target) && e.target !== inputLokasi) {
        suggestionsCont.classList.add('hidden');
      }
    });
  });
</script>
@endpush

</x-layout-user>