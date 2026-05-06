<!doctype html>
<html class="light" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>MarketPlace</title>
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Public+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet" />
  <!-- Material Symbols -->
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
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

    h1, h2, h3, .headline {
      font-family: "Manrope", sans-serif;
    }

    .glass-nav {
      backdrop-filter: blur(20px);
    }
  </style>
</head>

<body class="bg-surface text-on-surface overflow-x-hidden">
  @include('topbar')
  <div class="flex h-screen pt-[60px]">
    <!-- SideNavBar (Desktop Only) — shared component -->
    <x-sidebar />
    <!-- Main Content Canvas -->
    <main class="flex-1 md:ml-64 flex flex-col p-8 overflow-y-auto bg-surface">
        <header class="mb-6">
          <span class="text-xs font-bold text-secondary uppercase tracking-[0.2em] mb-1 block">Tectonic Precision</span>
          <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter leading-none">
            MarketPlace
          </h1>
        </header>

        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm text-center">
            <span class="material-symbols-outlined text-6xl text-primary mb-4">storefront</span>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang di MarketPlace</h2>
            <p class="text-on-surface-variant">Halaman ini siap untuk dikembangkan dan diisi dengan produk-produk terbaik.</p>
        </div>
    </main>
  </div>
</body>

</html>
