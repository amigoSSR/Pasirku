@props(['title' => 'Admin Panel', 'fullHeight' => false])
<!DOCTYPE html>
<html lang="id" x-data="{ 
  darkMode: localStorage.getItem('darkMode') === 'true' 
}" 
x-init="
  $watch('darkMode', val => localStorage.setItem('darkMode', val));
"
:class="{ 'dark': darkMode }">
<head>
    <link rel="icon" type="image/png" href="{{ asset('img/LogoWebsite.png') }}"/>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>{{ $title }} | PasirKu Admin</title>

{{-- Fonts & Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

{{-- Tailwind CDN --}}
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

{{-- Alpine JS --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        primary:                    "var(--primary)",
        "primary-container":        "var(--primary-container)",
        "primary-fixed":            "var(--primary-fixed)",
        "primary-fixed-dim":        "var(--primary-fixed-dim)",
        "on-primary":               "var(--on-primary)",
        "on-primary-container":     "var(--on-primary-container)",
        "on-primary-fixed":         "var(--on-primary-fixed)",
        secondary:                  "var(--secondary)",
        "secondary-container":      "var(--secondary-container)",
        "on-secondary":             "var(--on-secondary)",
        "on-secondary-container":   "var(--on-secondary-container)",
        tertiary:                   "var(--tertiary)",
        "tertiary-container":       "var(--tertiary-container)",
        "on-tertiary":              "var(--on-tertiary)",
        surface:                    "var(--surface)",
        "surface-dim":              "var(--surface-dim)",
        "surface-bright":           "var(--surface-bright)",
        "surface-container-lowest": "var(--surface-container-lowest)",
        "surface-container-low":    "var(--surface-container-low)",
        "surface-container":        "var(--surface-container)",
        "surface-container-high":   "var(--surface-container-high)",
        "surface-container-highest":"var(--surface-container-highest)",
        "surface-variant":          "var(--surface-variant)",
        "on-surface":               "var(--on-surface)",
        "on-surface-variant":       "var(--on-surface-variant)",
        outline:                    "var(--outline)",
        "outline-variant":          "var(--outline-variant)",
        error:                      "var(--error)",
        "error-container":          "var(--error-container)",
        "on-error":                 "var(--on-error)",
      },
      fontFamily: {
        sans:     ["Inter", "sans-serif"],
        headline: ["Manrope", "sans-serif"],
      },
      borderRadius: {
        DEFAULT: "0.5rem",
        lg:      "0.75rem",
        xl:      "1rem",
        "2xl":   "1.25rem",
        full:    "9999px",
      },
    },
  },
}
</script>

<style>
  :root {
    --primary: #944a00;
    --primary-container: #e67e22;
    --primary-fixed: #ffdcc5;
    --primary-fixed-dim: #ffb783;
    --on-primary: #ffffff;
    --on-primary-container: #502600;
    --on-primary-fixed: #301400;
    --secondary: #7a5649;
    --secondary-container: #fdcdbc;
    --on-secondary: #ffffff;
    --on-secondary-container: #795548;
    --tertiary: #00658f;
    --tertiary-container: #00a3e4;
    --on-tertiary: #ffffff;
    --surface: #f8f9fa;
    --surface-dim: #d9dadb;
    --surface-bright: #f8f9fa;
    --surface-container-lowest: #ffffff;
    --surface-container-low: #f3f4f5;
    --surface-container: #edeeef;
    --surface-container-high: #e7e8e9;
    --surface-container-highest: #e1e3e4;
    --surface-variant: #e1e3e4;
    --on-surface: #191c1d;
    --on-surface-variant: #564337;
    --outline: #897365;
    --outline-variant: #dcc1b1;
    --error: #ba1a1a;
    --error-container: #ffdad6;
    --on-error: #ffffff;
  }

  .dark {
    --primary: #ffb783;
    --primary-container: #793800;
    --primary-fixed: #ffdcc5;
    --primary-fixed-dim: #ffb783;
    --on-primary: #502600;
    --on-primary-container: #ffdcbe;
    --on-primary-fixed: #301400;
    --secondary: #e7bdb0;
    --secondary-container: #5f3f33;
    --on-secondary: #442a20;
    --on-secondary-container: #ffdad0;
    --tertiary: #87ceff;
    --tertiary-container: #004d6e;
    --on-tertiary: #00344d;
    --on-tertiary-container: #cbe6ff;
    --surface: #0f1416;
    --surface-dim: #0f1416;
    --surface-bright: #353a3c;
    --surface-container-lowest: #0a0f11;
    --surface-container-low: #171c1e;
    --surface-container: #1b2022;
    --surface-container-high: #262b2d;
    --surface-container-highest: #313638;
    --surface-variant: #51443a;
    --on-surface: #e1e3e4;
    --on-surface-variant: #d5c3b6;
    --outline: #9d8d82;
    --outline-variant: #51443a;
    --error: #ffb4ab;
    --error-container: #93000a;
    --on-error: #690005;
  }

  [x-cloak] { display: none !important; }
  *, *::before, *::after { box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body { font-family: 'Inter', sans-serif; }
  .material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    user-select: none;
  }
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: var(--outline-variant); border-radius: 10px; }
  ::-webkit-scrollbar-thumb:hover { background: #897365; }
  .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
  .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
  .page-content { animation: fadeUp 0.25s ease forwards; }
  @keyframes fadeUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
</style>

@stack('head')
</head>
<body class="bg-surface text-on-surface min-h-screen">

  {{-- ===== TOP BAR ===== --}}
  <header class="fixed top-0 left-0 right-0 h-[60px] z-50 bg-surface-container-lowest/90 backdrop-blur-xl border-b border-outline-variant/30 flex items-center px-4 md:px-6 gap-3 shadow-sm">

    {{-- Mobile Menu Toggle --}}
    <button id="admin-sidebar-toggle"
      class="md:hidden w-9 h-9 flex items-center justify-center rounded-xl hover:bg-surface-container-low text-on-surface-variant transition-colors"
      onclick="document.getElementById('admin-sidebar').classList.toggle('-translate-x-full')">
      <span class="material-symbols-outlined text-[22px]">menu</span>
    </button>

    {{-- Logo --}}
    <div class="flex items-center gap-2 mr-auto">
      <div class="w-8 h-8 rounded-xl bg-primary flex items-center justify-center shadow-sm shrink-0">
        <span class="material-symbols-outlined text-on-primary text-[18px]" style="font-variation-settings:'FILL' 1">shield_person</span>
      </div>
      <div class="leading-tight">
        <span class="font-headline font-extrabold text-on-surface text-sm tracking-tight block">PasirKu</span>
        <span class="text-[10px] font-bold text-primary uppercase tracking-widest leading-none">Admin Panel</span>
      </div>
    </div>

    {{-- Right Actions --}}
    <div class="flex items-center gap-2 ml-auto">
      {{-- Notification Bell --}}
      <button class="relative w-9 h-9 flex items-center justify-center rounded-xl hover:bg-surface-container-low text-on-surface-variant transition-colors">
        <span class="material-symbols-outlined text-[20px]">notifications</span>
        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-primary rounded-full border border-surface-container-lowest"></span>
      </button>

      {{-- Avatar --}}
      <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-headline font-extrabold text-sm uppercase shrink-0 border-2 border-primary/20">
        {{ strtoupper(substr(Auth::user()->Username ?? 'A', 0, 1)) }}
      </div>
      <div class="hidden md:block leading-tight">
        <span class="text-sm font-bold text-on-surface block">{{ Auth::user()->Username ?? 'Admin' }}</span>
        <span class="text-[10px] text-primary font-semibold uppercase tracking-wide">Administrator</span>
      </div>
    </div>
  </header>

  {{-- ===== SIDEBAR ===== --}}
  <aside id="admin-sidebar"
    class="fixed left-0 top-[60px] bottom-0 w-64 z-40 flex flex-col bg-surface-container-lowest border-r border-outline-variant/30 shadow-sm -translate-x-full md:translate-x-0 transition-transform duration-300 py-4">

    {{-- Sidebar Header Label --}}
    <div class="px-5 mb-4">
      <span class="text-[10px] font-black text-on-surface-variant uppercase tracking-[0.2em]">Navigasi Admin</span>
    </div>

    @php
      $isMenuAdmin = request()->routeIs('MenuUtamaAdmin', 'admin.dashboard');
      $isShopAdmin = request()->routeIs('ShopeRegistry');
      $isQueryAdmin = request()->routeIs('admin.queryToko');
      $isUserAdmin = request()->routeIs('UserRegistry');
      $isKomisiAdmin = request()->routeIs('admin.komisi');
      $isProfilAdmin = request()->routeIs('ProfilAdmin');
      $isChatAdmin = request()->routeIs('chat.*') || request()->is('chat/*') || request()->routeIs('PesanAdmin');
    @endphp

    <nav class="flex-1 space-y-0.5 px-3">

      {{-- Dashboard --}}
      <a href="{{ route('MenuUtamaAdmin') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isMenuAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isMenuAdmin) style="font-variation-settings:'FILL' 1" @endif>dashboard</span>
        <span class="text-sm">Dashboard</span>
      </a>

      {{-- Manajemen Toko --}}
      <a href="{{ route('ShopeRegistry') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isShopAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isShopAdmin) style="font-variation-settings:'FILL' 1" @endif>storefront</span>
        <span class="text-sm">Manajemen Toko</span>
      </a>

      {{-- Komisi & Masa Aktif --}}
      <a href="{{ route('admin.komisi') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isKomisiAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isKomisiAdmin) style="font-variation-settings:'FILL' 1" @endif>account_balance_wallet</span>
        <span class="text-sm">Komisi & Masa Aktif</span>
      </a>

      {{-- Query Toko (Monitoring) --}}
      <a href="{{ route('admin.queryToko') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isQueryAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isQueryAdmin) style="font-variation-settings:'FILL' 1" @endif>monitoring</span>
        <span class="text-sm">Query Toko</span>
      </a>

      {{-- Manajemen Pengguna --}}
      <a href="{{ route('UserRegistry') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isUserAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isUserAdmin) style="font-variation-settings:'FILL' 1" @endif>group</span>
        <span class="text-sm">Manajemen Pengguna</span>
      </a>

      {{-- Chat Admin --}}
      <a href="{{ route('PesanAdmin') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isChatAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isChatAdmin) style="font-variation-settings:'FILL' 1" @endif>forum</span>
        <span class="text-sm">Pesan & Support</span>
      </a>

      {{-- Profil --}}
      <a href="{{ route('ProfilAdmin') }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 border border-transparent
          {{ $isProfilAdmin ? 'bg-primary/10 text-primary font-bold border-primary/10' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-low' }}">
        <span class="material-symbols-outlined text-[20px]" @if($isProfilAdmin) style="font-variation-settings:'FILL' 1" @endif>manage_accounts</span>
        <span class="text-sm">Profil Admin</span>
      </a>

    </nav>

    {{-- Sidebar Footer --}}
    <div class="border-t border-outline-variant/30 pt-3 px-3 space-y-0.5 mt-2">
      <form method="POST" action="{{ route('profil.logout') }}">
        @csrf
        <button type="submit"
          class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-on-surface-variant hover:text-error hover:bg-error/5 transition-all duration-200 border border-transparent">
          <span class="material-symbols-outlined text-[20px]">logout</span>
          <span class="text-sm">Logout</span>
        </button>
      </form>
    </div>
  </aside>

  {{-- Backdrop for mobile --}}
  <div id="admin-sidebar-backdrop"
    class="md:hidden fixed inset-0 bg-black/40 z-30 hidden"
    onclick="document.getElementById('admin-sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')">
  </div>

  {{-- ===== MAIN CONTENT ===== --}}
  <main class="flex-1 md:ml-64 bg-surface min-h-screen pt-[60px] {{ $fullHeight ? 'overflow-hidden h-screen flex flex-col' : 'overflow-y-auto' }}">

    {{-- Optional page header slot --}}
    @isset($header)
      <div class="px-6 md:px-8 pt-8 pb-4">{{ $header }}</div>
    @endisset

    <div class="page-content {{ isset($header) ? '' : 'pt-8' }} {{ $fullHeight ? 'flex-1 flex flex-col overflow-hidden' : '' }}">
      {{ $slot }}
    </div>
  </main>

  {{-- Global Store Edit Modal (Alpine.js) --}}
  <div x-data="globalStoreEditModal()" 
       @open-store-edit-modal.window="openModal($event.detail.toko)"
       x-show="open" 
       class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto bg-black/60 backdrop-blur-md"
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Provinsi</label>
                <input type="text" x-model="form.provinsi" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm" />
              </div>
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kota</label>
                <input type="text" x-model="form.kota" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm" />
              </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kecamatan</label>
                <input type="text" x-model="form.kecamatan" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm" />
              </div>
              <div class="space-y-1">
                <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kode Pos</label>
                <input type="text" x-model="form.kode_pos" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm" />
              </div>
            </div>
            <div class="space-y-1">
              <label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Alamat Lengkap</label>
              <textarea x-model="form.detail_alamat" rows="2" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-2 text-sm resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4 bg-surface-container-low/70 p-4 rounded-xl">
              <div>
                <span class="text-[9px] font-black uppercase block">Lat</span>
                <span class="font-mono text-xs font-bold" x-text="form.latitude"></span>
              </div>
              <div>
                <span class="text-[9px] font-black uppercase block">Lng</span>
                <span class="font-mono text-xs font-bold" x-text="form.longitude"></span>
              </div>
            </div>
            <button type="button" @click="searchAddress()" class="w-full bg-secondary/10 text-secondary border border-secondary/20 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-1.5">
              <span class="material-symbols-outlined text-[18px]">search</span> Cari di Peta
            </button>
          </div>
          <div class="flex flex-col h-full min-h-[300px]">
            <div class="flex-1 w-full rounded-2xl border border-outline-variant/30 overflow-hidden relative">
              <div id="global-admin-edit-map" class="absolute inset-0 z-0"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="px-6 py-4 border-t border-outline-variant/20 flex items-center justify-end gap-3 bg-surface-container-low/50">
        <button type="button" @click="open = false" class="px-5 py-2.5 rounded-xl border text-xs font-bold">Batal</button>
        <button type="button" @click="submitForm()" :disabled="submitting" class="px-5 py-2.5 rounded-xl bg-primary text-on-primary text-xs font-bold shadow-sm">
          <span x-text="submitting ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
        </button>
      </div>
    </div>
  </div>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    function globalStoreEditModal() {
      return {
        open: false, store: {}, submitting: false, map: null, marker: null,
        form: { provinsi:'', kota:'', kecamatan:'', detail_alamat:'', kode_pos:'', latitude:'', longitude:'' },
        openModal(toko) {
          this.store = toko;
          this.form = {
            provinsi: toko.provinsi || '', kota: toko.kota || '', kecamatan: toko.kecamatan || '',
            detail_alamat: toko.detail_alamat || '', kode_pos: toko.kode_pos || '',
            latitude: toko.latitude || -5.147665, longitude: toko.longitude || 119.432731
          };
          this.open = true;
          this.$nextTick(() => this.initMap());
        },
        initMap() {
          if (this.map) { this.map.remove(); this.map = null; }
          const lat = parseFloat(this.form.latitude), lng = parseFloat(this.form.longitude);
          this.map = L.map('global-admin-edit-map').setView([lat, lng], 13);
          L.tileLayer('https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', { maxZoom: 20, subdomains: ['mt0','mt1','mt2','mt3'] }).addTo(this.map);
          this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);
          this.marker.on('dragend', (e) => {
            const pos = e.target.getLatLng();
            this.form.latitude = pos.lat.toFixed(8); this.form.longitude = pos.lng.toFixed(8);
          });
          this.map.on('click', (e) => {
            this.marker.setLatLng(e.latlng);
            this.form.latitude = e.latlng.lat.toFixed(8); this.form.longitude = e.latlng.lng.toFixed(8);
          });
        },
        searchAddress() {
          const q = [this.form.detail_alamat, this.form.kecamatan, this.form.kota, this.form.provinsi].filter(Boolean).join(', ');
          if (!q) return alert('Isi alamat!');
          fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}&limit=1`)
            .then(res => res.json()).then(data => {
              if (data.length) {
                const lat = parseFloat(data[0].lat), lng = parseFloat(data[0].lon);
                this.map.setView([lat, lng], 15); this.marker.setLatLng([lat, lng]);
                this.form.latitude = lat.toFixed(8); this.form.longitude = lng.toFixed(8);
              }
            });
        },
        submitForm() {
          this.submitting = true;
          fetch(`/admin/shope-registry/${this.store.ID_Toko}/update-location`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(this.form)
          }).then(res => res.json()).then(data => {
            this.submitting = false;
            if (data.success) { alert(data.message); this.open = false; window.location.reload(); }
          }).catch(() => { this.submitting = false; alert('Kesalahan koneksi'); });
        }
      }
    }
  </script>

  {{-- Mobile Bottom Nav --}}
  <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl border-t border-outline-variant/30 flex justify-around items-center px-2 pb-safe pt-2">
    <a href="{{ route('MenuUtamaAdmin') }}"
      class="flex flex-col items-center gap-0.5 px-4 py-1.5 rounded-xl {{ $isMenuAdmin ?? false ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl">dashboard</span>
      <span class="text-[10px] font-bold">Dashboard</span>
    </a>
    <a href="{{ route('ShopeRegistry') }}"
      class="flex flex-col items-center gap-0.5 px-4 py-1.5 rounded-xl {{ $isShopAdmin ?? false ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl">storefront</span>
      <span class="text-[10px] font-bold">Toko</span>
    </a>
    <a href="{{ route('PesanAdmin') }}"
      class="flex flex-col items-center gap-0.5 px-4 py-1.5 rounded-xl {{ $isChatAdmin ?? false ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl">forum</span>
      <span class="text-[10px] font-bold">Chat</span>
    </a>
    <a href="{{ route('ProfilAdmin') }}"
      class="flex flex-col items-center gap-0.5 px-4 py-1.5 rounded-xl {{ $isProfilAdmin ?? false ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl">person</span>
      <span class="text-[10px] font-bold">Profil</span>
    </a>
  </nav>

  {{-- Mobile sidebar toggle script --}}
  <script>
    const toggle = document.getElementById('admin-sidebar-toggle');
    const backdrop = document.getElementById('admin-sidebar-backdrop');
    if (toggle && backdrop) {
      toggle.addEventListener('click', () => {
        backdrop.classList.toggle('hidden');
      });
    }
  </script>

  @stack('scripts')
</body>
</html>
