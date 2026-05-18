<!doctype html>

<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>@yield('title', 'Dashboard') | Industrial Hub</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <!-- Fonts -->

  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&amp;family=Public+Sans:wght@300;400;500;600&amp;display=swap"
    rel="stylesheet" />
  <!-- Material Symbols -->
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "surface-variant": "#d3e4fe",
            "on-surface": "#0b1c30",
            "on-secondary-fixed-variant": "#623f18",
            "primary-container": "#005fb8",
            "on-background": "#0b1c30",
            "on-tertiary-container": "#fcd1c4",
            surface: "#f8f9ff",
            "surface-dim": "#cbdbf5",
            secondary: "#7d562d",
            "surface-container-low": "#eff4ff",
            "on-primary-fixed": "#001b3d",
            "inverse-on-surface": "#eaf1ff",
            "surface-tint": "#005db5",
            "inverse-surface": "#213145",
            outline: "#727783",
            "on-primary-fixed-variant": "#00468b",
            "on-tertiary-fixed-variant": "#5d4037",
            "tertiary-container": "#78584e",
            background: "#f8f9ff",
            error: "#ba1a1a",
            "on-primary": "#ffffff",
            "surface-container-highest": "#d3e4fe",
            "on-secondary": "#ffffff",
            "primary-fixed": "#d6e3ff",
            "on-secondary-container": "#7a532a",
            "on-error-container": "#93000a",
            "surface-container-lowest": "#ffffff",
            "secondary-fixed-dim": "#f0bd8b",
            "tertiary-fixed-dim": "#e7bdb1",
            "on-primary-container": "#cadcff",
            "error-container": "#ffdad6",
            "on-secondary-fixed": "#2c1600",
            "primary-fixed-dim": "#a8c8ff",
            "surface-container": "#e5eeff",
            "on-surface-variant": "#424752",
            "secondary-container": "#ffca98",
            "surface-container-high": "#dce9ff",
            "on-tertiary-fixed": "#2c160e",
            primary: "#00488d",
            "outline-variant": "#c2c6d4",
            "surface-bright": "#f8f9ff",
            tertiary: "#5e4138",
            "inverse-primary": "#a8c8ff",
            "secondary-fixed": "#ffdcbd",
            "on-tertiary": "#ffffff",
            "tertiary-fixed": "#ffdbd0",
            "on-error": "#ffffff",
          },
          borderRadius: {
            DEFAULT: "0.125rem",
            lg: "0.25rem",
            xl: "0.5rem",
            full: "0.75rem",
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Public Sans"],
            label: ["Public Sans"],
          },
        },
      },
    };
  </script>
  <style>
    
    .material-symbols-outlined {
      font-variation-settings:
        "FILL" 0,
        "wght" 400,
        "GRAD" 0,
        "opsz" 24;
    }

    body {
      font-family: "Public Sans", sans-serif;
    }

    h1,
    h2,
    h3,
    .headline {
      font-family: "Manrope", sans-serif;
    }

    .glass-nav {
      backdrop-filter: blur(20px);
    }
  </style>
</head>
<!-- TopNavBar (Shared Component) -->
<header
  class="bg-slate-50/80 backdrop-blur-lg fixed top-0 w-full z-[100] transition-transform duration-150 docked full-width flex justify-center">
  <div class="flex justify-between items-center w-full px-4 py-3 max-w-7xl mx-auto">
    <div class="flex items-center gap-8">
      <span class="text-xl font-black tracking-tighter text-blue-900 uppercase">Pasir Ku</span>
      <!-- Desktop Nav Cluster -->
      <nav class="hidden md:flex items-center gap-6">
        <a class="text-blue-800 font-bold text-sm tracking-wide" href="{{ route('MenuUtama') }}">Menu Utama</a>
        <a class="text-slate-500 hover:bg-slate-200/50 px-3 py-1 rounded transition-colors text-sm tracking-wide"
          href="{{ route('keranjang') }}">Checkout</a>
        <a class="text-slate-500 hover:bg-slate-200/50 px-3 py-1 rounded transition-colors text-sm tracking-wide"
          href="{{ route('Pesan') }}">Pesan</a>
      </nav>
    </div>
    <div class="flex items-center gap-4">
      <div class="hidden sm:flex relative items-center">
        <input
          id="search-input"
          class="bg-surface-container-high border-none rounded-lg px-4 py-2 text-sm w-64 focus:ring-2 focus:ring-primary transition-all"
          placeholder="Cari toko pasir..." type="text" autocomplete="off" />
        <span class="material-symbols-outlined absolute right-3 text-on-surface-variant text-lg"
          data-icon="search">search</span>
      </div>
      <div class="flex items-center gap-2">
        <button class="p-2 hover:bg-slate-200/50 rounded-full transition-all">
          <span class="material-symbols-outlined text-blue-900"
            data-icon="notifications">notifications</span>
        </button>
        <button class="p-2 hover:bg-slate-200/50 rounded-full transition-all">
          <span class="material-symbols-outlined text-blue-900"
            data-icon="chat_bubble">chat_bubble</span>
        </button>
        <div class="w-8 h-8 rounded-full bg-primary-container overflow-hidden ml-2 border-2 border-white shadow-sm">
          <a href="{{ route('Profil') }}"><img alt="User profile photo" class="w-full h-full object-cover"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpBHj5IV2Kn3qm24UVsbcdYBYQ89XXfIj4YbvJKRLj6WLp8H4Q9ZVekGNFKZ2mwLQsDcn1OvQtqY4jNHVI93cihWqIsObwhQnAiTdtzu5A0WdbcexbKokX7JXWiplAzj1I6vFnPQJwdk0t8ogkH3hL9BhLYezo57n8tqRFVw9fTUW7umYAx-9XYNzsjHt6ai42pUtB71acUJ9pBjK4qW7plGWOx3tuinjqVZbbLMoKQaDk1Qnd7VhIgGYmoeFMdYk6EguMZpY7Nw" /></a>
        </div>
      </div>
    </div>
  </div>
</header>
