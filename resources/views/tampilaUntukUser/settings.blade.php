@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('lat');
        const lngInput = document.getElementById('lng');
        const btnGetCurrent = document.getElementById('btn-get-current');
        
        const initialLat = parseFloat(latInput.value) || -5.147665;
        const initialLng = parseFloat(lngInput.value) || 119.432731;

        const map = L.map('location-picker-map').setView([initialLat, initialLng], 13);
        
        L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

        function updateInputs(lat, lng) {
            latInput.value = lat.toFixed(8);
            lngInput.value = lng.toFixed(8);
        }

        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            updateInputs(pos.lat, pos.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });

        btnGetCurrent.addEventListener('click', function() {
            if (navigator.geolocation) {
                const icon = this.querySelector('.material-symbols-outlined');
                icon.classList.add('animate-spin');
                
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 15);
                    updateInputs(lat, lng);
                    icon.classList.remove('animate-spin');
                }, function() {
                    icon.classList.remove('animate-spin');
                    alert('Gagal mengambil lokasi saat ini.');
                });
            }
        });
    });
</script>
@endpush

<x-layout-user title="Pengaturan">
    <div class="px-6 md:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-6">
            <a href="{{ route('MenuUtama') }}" class="hover:text-primary transition-colors">Home</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="font-bold text-on-surface">Settings</span>
        </nav>

        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-headline font-extrabold text-on-surface dark:text-zinc-100 tracking-tight">Pengaturan</h1>
            <p class="text-on-surface-variant dark:text-zinc-400 text-sm mt-1.5">Kelola preferensi tampilan dan akun Anda.</p>
        </header>

        <div class="max-w-3xl space-y-6">
            {{-- Appearance Section --}}
            <section class="bg-surface-container-lowest dark:bg-zinc-900 rounded-2xl p-6 border border-outline-variant/30 dark:border-zinc-800 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-primary/10 dark:bg-primary/20 rounded-xl flex items-center justify-center text-primary dark:text-primary-fixed">
                        <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">palette</span>
                    </div>
                    <div>
                        <h2 class="font-headline font-bold text-on-surface dark:text-zinc-100">Tampilan</h2>
                        <p class="text-on-surface-variant dark:text-zinc-400 text-xs">Sesuaikan visual antarmuka sistem.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Dark Mode Toggle --}}
                    <div class="flex items-center justify-between p-4 rounded-xl bg-surface-container-low dark:bg-zinc-800/50 border border-transparent hover:border-outline-variant/20 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container-highest dark:bg-zinc-800 text-on-surface dark:text-zinc-300">
                                <span class="material-symbols-outlined" x-show="!darkMode">light_mode</span>
                                <span class="material-symbols-outlined" x-show="darkMode" x-cloak>dark_mode</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface dark:text-zinc-200">Mode Gelap</p>
                                <p class="text-[11px] text-on-surface-variant dark:text-zinc-400">Gunakan tampilan bertema gelap untuk mengurangi kelelahan mata.</p>
                            </div>
                        </div>
                        
                        {{-- Toggle Switch --}}
                        <button 
                            @click="darkMode = !darkMode"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                            :class="darkMode ? 'bg-primary' : 'bg-surface-container-highest dark:bg-zinc-700'"
                        >
                            <span
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                :class="darkMode ? 'translate-x-6' : 'translate-x-1'"
                            ></span>
                        </button>
                    </div>
                </div>
            </section>

            {{-- Location Section --}}
            <section class="bg-surface-container-lowest dark:bg-zinc-900 rounded-2xl p-6 border border-outline-variant/30 dark:border-zinc-800 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-primary/10 dark:bg-primary/20 rounded-xl flex items-center justify-center text-primary dark:text-primary-fixed">
                        <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">location_on</span>
                    </div>
                    <div>
                        <h2 class="font-headline font-bold text-on-surface dark:text-zinc-100">Lokasi Default</h2>
                        <p class="text-on-surface-variant dark:text-zinc-400 text-xs">Simpan lokasi Anda untuk pencarian toko terdekat saat GPS tidak aktif.</p>
                    </div>
                </div>

                <form action="{{ route('profile.update-location') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Latitude</label>
                            <input type="text" name="latitude" id="lat" value="{{ Auth::user()->latitude }}" readonly
                                class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Longitude</label>
                            <input type="text" name="longitude" id="lng" value="{{ Auth::user()->longitude }}" readonly
                                class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Detail Alamat</label>
                        <textarea name="detail_alamat" id="address" rows="2" 
                            class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"
                            placeholder="Contoh: Perumahan Gading, Blok A1 No. 5">{{ Auth::user()->detail_alamat }}</textarea>
                    </div>

                    {{-- Map for selection --}}
                    <div class="h-64 w-full rounded-2xl border border-outline-variant/20 overflow-hidden relative" id="location-picker-map"></div>
                    <p class="text-[10px] text-on-surface-variant italic leading-relaxed">
                        * Klik pada peta untuk menentukan lokasi default Anda, atau gunakan tombol "Ambil Lokasi Saat Ini" di bawah.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button type="button" id="btn-get-current" class="flex-1 bg-surface-container-high text-on-surface font-bold py-3 rounded-xl text-xs flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-all">
                            <span class="material-symbols-outlined text-[18px]">my_location</span>
                            Ambil Lokasi Saat Ini
                        </button>
                        <button type="submit" class="flex-1 bg-primary text-on-primary font-bold py-3 rounded-xl text-xs flex items-center justify-center gap-2 hover:opacity-90 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Simpan Lokasi
                        </button>
                    </div>
                </form>
            </section>

            {{-- Logout Section --}}
            <section class="bg-surface-container-lowest dark:bg-zinc-900 rounded-2xl p-6 border border-outline-variant/30 dark:border-zinc-800 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-error/10 dark:bg-error/20 rounded-xl flex items-center justify-center text-error">
                        <span class="material-symbols-outlined text-[22px]">logout</span>
                    </div>
                    <div>
                        <h2 class="font-headline font-bold text-on-surface dark:text-zinc-100">Keamanan</h2>
                        <p class="text-on-surface-variant dark:text-zinc-400 text-xs">Kelola akses akun Anda.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <form method="POST" action="{{ route('profil.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-between p-4 rounded-xl bg-error/5 hover:bg-error/10 transition-all border border-transparent">
                            <div class="flex items-center gap-4">
                                <p class="text-sm font-bold text-error">Keluar dari Akun</p>
                            </div>
                            <span class="material-symbols-outlined text-error">chevron_right</span>
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-layout-user>
