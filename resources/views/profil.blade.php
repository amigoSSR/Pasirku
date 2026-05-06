<!DOCTYPE html>

<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Profile - QUARRY DIRECT</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&amp;family=Public+Sans:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-variant": "#d3e4fe",
                        "on-surface": "#0b1c30",
                        "on-secondary-fixed-variant": "#623f18",
                        "primary-container": "#005fb8",
                        "on-background": "#0b1c30",
                        "on-tertiary-container": "#fcd1c4",
                        "surface": "#f8f9ff",
                        "surface-dim": "#cbdbf5",
                        "secondary": "#7d562d",
                        "surface-container-low": "#eff4ff",
                        "on-primary-fixed": "#001b3d",
                        "inverse-on-surface": "#eaf1ff",
                        "surface-tint": "#005db5",
                        "inverse-surface": "#213145",
                        "outline": "#727783",
                        "on-primary-fixed-variant": "#00468b",
                        "on-tertiary-fixed-variant": "#5d4037",
                        "tertiary-container": "#78584e",
                        "background": "#f8f9ff",
                        "error": "#ba1a1a",
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
                        "primary": "#00488d",
                        "outline-variant": "#c2c6d4",
                        "surface-bright": "#f8f9ff",
                        "tertiary": "#5e4138",
                        "inverse-primary": "#a8c8ff",
                        "secondary-fixed": "#ffdcbd",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed": "#ffdbd0",
                        "on-error": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Public Sans"],
                        "label": ["Public Sans"]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .tonal-shift-bg-slate-100 { background-color: #f1f5f9; }
        .no-border-tonal-layering { border: none; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">

@include('topbar')

<div class="flex min-h-screen pt-[60px] pb-24 md:pb-0">
<!-- SideNavBar Shell (Desktop) — shared component -->
<x-sidebar />
<!-- Main Content Canvas -->
<main class="flex-1 md:ml-64 px-4 md:px-12 py-8 max-w-5xl mx-auto w-full">
<!-- Strata Grid: Profile Header -->
<section class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12 items-end">
<div class="md:col-span-4 aspect-square bg-surface-container-low rounded-xl overflow-hidden shadow-sm">
<img alt="Profile" class="w-full h-full object-cover" data-alt="close-up studio portrait of a professional man in his 40s with a confident smile, wearing a dark navy polo shirt" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5PQtLotEWu5Gayn3BYAklIw_RIGZZ9W4Va4b6CgPo1Vc63rl0AsarywWh0O9JeqvGNBy29ZhR37zpxw7Q0D0wegVj9ndr7ki257XmzjvsTQy7_qy8VSbS_MHwpnPd9RerrDoWwWtRWGEmvoYFpJ01SL9PYZ2WPsMMI4oMTZ00pq-oQqnM6jidyCFcHRED5qU1xDteSLy8EbgbL9ZKOPqKvdE0WJ7tcwp7m8eEKUnZVhCh7I8yJyvHQBnB1Qi_SRypz1rveyUHZQ"/>
</div>
<div class="md:col-span-8 pb-4">
<span class="font-label text-secondary uppercase tracking-widest text-sm mb-2 block">Account Overview</span>
<h1 class="font-headline text-5xl font-extrabold tracking-tighter text-on-surface mb-4">{{ Auth::user()->Username ?? 'Pengguna' }}</h1>
<div class="flex gap-4">
<div class="bg-surface-container-highest px-4 py-2 rounded-lg">
<p class="text-xs text-on-surface-variant font-medium uppercase">Total Orders</p>
<p class="text-xl font-headline font-bold text-primary">124</p>
</div>
<div class="bg-surface-container-highest px-4 py-2 rounded-lg">
<p class="text-xs text-on-surface-variant font-medium uppercase">Trust Score</p>
<p class="text-xl font-headline font-bold text-secondary">9.8</p>
</div>
</div>
</div>
</section>
<!-- Strata Grid: Profile Options Bento -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Chat (History) -->
<a class="group relative overflow-hidden bg-surface-container-lowest p-8 rounded-xl transition-all duration-300 hover:shadow-[0px_24px_48px_rgba(11,28,48,0.08)]" href="#">
<div class="flex justify-between items-start mb-12">
<div class="p-3 bg-blue-50 text-primary rounded-xl group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl">forum</span>
</div>
<span class="material-symbols-outlined text-slate-300">arrow_outward</span>
</div>
<h3 class="font-headline text-2xl font-bold text-on-surface mb-2">Chat</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">View your negotiation history and active inquiries with suppliers.</p>
</a>
<!-- Daftar sebagai Penjual -->
<a class="group relative overflow-hidden bg-primary text-white p-8 rounded-xl transition-all duration-300 hover:shadow-[0px_24px_48px_rgba(0,72,141,0.2)]" href="#">
<div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
<div class="flex justify-between items-start mb-12">
<div class="p-3 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl">add_business</span>
</div>
</div>
<h3 class="font-headline text-2xl font-bold mb-2">Daftar sebagai Penjual</h3>
<p class="text-white/80 text-sm leading-relaxed">Expand your business reach. Register your quarry or logistics company today.</p>
</a>
<!-- Update Isi Toko -->
<a class="group relative overflow-hidden bg-surface-container-low p-8 rounded-xl transition-all duration-300 border-2 border-transparent hover:border-primary-container" href="#">
<div class="flex justify-between items-start mb-12">
<div class="p-3 bg-white text-secondary rounded-xl group-hover:rotate-12 transition-transform">
<span class="material-symbols-outlined text-3xl">inventory_2</span>
</div>
</div>
<h3 class="font-headline text-2xl font-bold text-on-surface mb-2">Update Isi Toko</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">Manage your catalog, update pricing for sand, stone, and aggregates.</p>
</a>
<!-- Logout (Large Span) -->
<form method="POST" action="{{ route('profil.logout') }}" class="md:col-span-3">
    @csrf
    <button type="submit" class="w-full flex items-center justify-between bg-surface-container-lowest border-2 border-error/10 p-6 rounded-xl group hover:bg-error/5 transition-colors">
        <div class="flex items-center gap-4">
            <div class="p-2 bg-error/10 text-error rounded-lg">
                <span class="material-symbols-outlined">logout</span>
            </div>
            <div class="text-left">
                <span class="font-headline font-bold text-on-surface block">Logout</span>
                <span class="text-xs text-on-surface-variant">Securely end your session</span>
            </div>
        </div>
        <span class="material-symbols-outlined text-error opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
    </button>
</form>
</div>
<!-- Profile Details Section (Asymmetric) -->
</main>
</div>
<!-- BottomNavBar Shell (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-slate-50/80 backdrop-blur-xl shadow-[0px_-8px_24px_rgba(11,28,48,0.05)] rounded-t-xl">
<a class="flex flex-col items-center justify-center text-slate-500 px-6 py-1 hover:text-blue-700" href="#">
<span class="material-symbols-outlined">trolley</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Home</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-500 px-6 py-1 hover:text-blue-700" href="#">
<span class="material-symbols-outlined">shopping_cart</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Cart</span>
</a>
<a class="flex flex-col items-center justify-center bg-blue-100 text-blue-900 rounded-xl px-6 py-1 active:scale-90 transition-all duration-200" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Profile</span>
</a>
</nav>
</body></html>