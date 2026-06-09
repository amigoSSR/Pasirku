@props(['title' => 'Admin Panel', 'fullHeight' => false])
<!DOCTYPE html>
<html lang="id">
<head>
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
        "on-tertiary":              "#ffffff",
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
