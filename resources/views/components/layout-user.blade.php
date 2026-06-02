@props(['title' => 'Customer Portal', 'fullHeight' => false])
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>{{ $title ?? 'Customer Portal' }} | PasirKu</title>

{{-- Fonts & Icons --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

{{-- Leaflet (optional per-page) --}}
@stack('leaflet-css')

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
        primary:                    "#944a00",
        "primary-container":        "#e67e22",
        "primary-fixed":            "#ffdcc5",
        "primary-fixed-dim":        "#ffb783",
        "on-primary":               "#ffffff",
        "on-primary-container":     "#502600",
        "on-primary-fixed":         "#301400",
        secondary:                  "#7a5649",
        "secondary-container":      "#fdcdbc",
        "on-secondary":             "#ffffff",
        "on-secondary-container":   "#795548",
        tertiary:                   "#00658f",
        "tertiary-container":       "#00a3e4",
        "tertiary-fixed":           "#c7e7ff",
        "on-tertiary":              "#ffffff",
        "on-tertiary-container":    "#00354d",
        surface:                    "#f8f9fa",
        "surface-dim":              "#d9dadb",
        "surface-bright":           "#f8f9fa",
        "surface-container-lowest": "#ffffff",
        "surface-container-low":    "#f3f4f5",
        "surface-container":        "#edeeef",
        "surface-container-high":   "#e7e8e9",
        "surface-container-highest":"#e1e3e4",
        "surface-variant":          "#e1e3e4",
        "on-surface":               "#191c1d",
        "on-surface-variant":       "#564337",
        outline:                    "#897365",
        "outline-variant":          "#dcc1b1",
        "inverse-surface":          "#2e3132",
        "inverse-on-surface":       "#f0f1f2",
        "inverse-primary":          "#ffb783",
        error:                      "#ba1a1a",
        "error-container":          "#ffdad6",
        "on-error":                 "#ffffff",
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
  ::-webkit-scrollbar-thumb { background: #dcc1b1; border-radius: 10px; }
  ::-webkit-scrollbar-thumb:hover { background: #897365; }

  .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
  .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }

  .page-content { animation: fadeUp 0.25s ease forwards; }
  @keyframes fadeUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
</style>

{{-- Extra head content injected per-page --}}
@stack('head')
</head>
<body class="bg-surface text-on-surface min-h-screen">

  {{-- ===== TOP BAR ===== --}}
  @include('tampilaUntukUser.topbarUser')

  <div class="flex min-h-screen pt-[60px]">

    {{-- ===== SIDEBAR ===== --}}
    <x-sidebar />

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1 md:ml-64 bg-surface min-h-screen {{ $fullHeight ?? false ? 'overflow-hidden h-[calc(100vh-60px)] flex flex-col' : 'overflow-y-auto' }}">

      {{-- Breadcrumb + Page Header (optional) --}}
      @isset($header)
        <div class="px-6 md:px-8 pt-8 pb-4">
          {{ $header }}
        </div>
      @endisset

      {{-- Main Page Body --}}
      <div class="page-content {{ isset($header) ? '' : 'pt-8' }} {{ $fullHeight ?? false ? 'flex-1 flex flex-col overflow-hidden' : '' }}">
        {{ $slot }}
      </div>
    </main>

  </div>

  {{-- ===== MOBILE BOTTOM NAV ===== --}}
  <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 bg-surface-container-lowest/90 backdrop-blur-xl border-t border-outline-variant/30 flex justify-around items-center px-1 pb-safe pt-2">
    <a href="{{ route('MenuUtama') }}" class="flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-xl {{ request()->routeIs('MenuUtama') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl" @style(["font-variation-settings: 'FILL' 1" => request()->routeIs('MenuUtama')])>home</span>
      <span class="text-[10px] font-bold">Home</span>
    </a>
    <a href="{{ route('ordertracking') }}" class="flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-xl {{ request()->routeIs('ordertracking') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl" @style(["font-variation-settings: 'FILL' 1" => request()->routeIs('ordertracking')])>local_shipping</span>
      <span class="text-[10px] font-bold">Orders</span>
    </a>
    <a href="{{ route('riwayat') }}" class="flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-xl {{ request()->routeIs('riwayat') ? 'text-primary' : 'text-on-surface-variant' }} relative">
      <span class="material-symbols-outlined text-2xl" @style(["font-variation-settings: 'FILL' 1" => request()->routeIs('riwayat')])>history</span>
      <span id="mobile-riwayat-badge" class="hidden absolute top-0.5 right-1 bg-error text-on-error text-[9px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center shrink-0">0</span>
      <span class="text-[10px] font-bold">Riwayat</span>
    </a>
    <a href="{{ route('keranjang') }}" class="flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-xl {{ request()->routeIs('keranjang') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl" @style(["font-variation-settings: 'FILL' 1" => request()->routeIs('keranjang')])>shopping_cart</span>
      <span class="text-[10px] font-bold">Cart</span>
    </a>
    <a href="{{ route('Pesan') }}" class="flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-xl {{ request()->routeIs('Pesan') ? 'text-primary' : 'text-on-surface-variant' }} relative">
      <span class="material-symbols-outlined text-2xl" @style(["font-variation-settings: 'FILL' 1" => request()->routeIs('Pesan')])>forum</span>
      <span id="mobile-chat-badge" class="hidden absolute top-0.5 right-1 bg-error text-on-error text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shrink-0">0</span>
      <span class="text-[10px] font-bold">Chat</span>
    </a>
    <a href="{{ route('Profil') }}" class="flex flex-col items-center gap-0.5 px-2 py-1.5 rounded-xl {{ request()->routeIs('Profil') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-2xl" @style(["font-variation-settings: 'FILL' 1" => request()->routeIs('Profil')])>person</span>
      <span class="text-[10px] font-bold">Profile</span>
    </a>
  </nav>

  {{-- Modern Toast Notification with AlpineJS --}}
  @if(session('success') || session('error') || $errors->any())
  <div x-data="{ show: true }"
       x-show="show"
       x-init="setTimeout(() => show = false, 5000)"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 translate-y-4"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 translate-y-4"
       class="fixed bottom-20 right-6 z-[9999] max-w-sm w-full bg-surface-container-lowest border border-outline-variant/30 rounded-2xl shadow-xl p-4 flex items-start gap-3.5"
       style="display: none;">
       
       @if(session('success'))
       <div class="w-10 h-10 bg-green-500/10 text-green-600 rounded-xl flex items-center justify-center shrink-0">
         <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">check_circle</span>
       </div>
       <div class="flex-1 min-w-0">
         <h4 class="font-headline font-bold text-on-surface text-sm">Berhasil</h4>
         <p class="text-on-surface-variant text-xs mt-0.5 leading-relaxed">{{ session('success') }}</p>
       </div>
       @elseif(session('error') || $errors->any())
       <div class="w-10 h-10 bg-red-500/10 text-red-600 rounded-xl flex items-center justify-center shrink-0">
         <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">error</span>
       </div>
       <div class="flex-1 min-w-0">
         <h4 class="font-headline font-bold text-on-surface text-sm">Pemberitahuan</h4>
         <p class="text-on-surface-variant text-xs mt-0.5 leading-relaxed">
           {{ session('error') ?? $errors->first() }}
         </p>
       </div>
       @endif
       
       <button @click="show = false" class="text-outline hover:text-on-surface transition-colors p-0.5 rounded-lg ml-auto shrink-0">
         <span class="material-symbols-outlined text-[18px]">close</span>
       </button>
  </div>
  @endif

  {{-- Scripts injected per-page --}}
  @stack('scripts')
  @stack('leaflet-js')

</body>
</html>
