<!DOCTYPE html>

<html class="light" lang="en"><head>
    <link rel="icon" type="image/png" href="{{ asset('img/LogoWebsite.png') }}"/>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Shop Detail - Sahara Sands Quarry</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&amp;family=Public_Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-error-container": "#93000a",
                        "surface-container": "#e5eeff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#ffca98",
                        "surface-dim": "#cbdbf5",
                        "secondary": "#7d562d",
                        "primary-fixed": "#d6e3ff",
                        "tertiary-container": "#78584e",
                        "surface-container-lowest": "#ffffff",
                        "inverse-primary": "#a8c8ff",
                        "surface": "#f8f9ff",
                        "surface-container-highest": "#d3e4fe",
                        "surface-container-high": "#dce9ff",
                        "outline": "#727783",
                        "primary-container": "#005fb8",
                        "surface-container-low": "#eff4ff",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#ffdcbd",
                        "on-primary-container": "#cadcff",
                        "error-container": "#ffdad6",
                        "on-surface": "#0b1c30",
                        "surface-tint": "#005db5",
                        "on-secondary-fixed": "#2c1600",
                        "secondary-fixed-dim": "#f0bd8b",
                        "on-primary-fixed-variant": "#00468b",
                        "primary": "#00488d",
                        "on-background": "#0b1c30",
                        "on-primary": "#ffffff",
                        "inverse-surface": "#213145",
                        "tertiary-fixed-dim": "#e7bdb1",
                        "surface-variant": "#d3e4fe",
                        "on-tertiary-fixed-variant": "#5d4037",
                        "surface-bright": "#f8f9ff",
                        "on-tertiary-fixed": "#2c160e",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#424752",
                        "tertiary-fixed": "#ffdbd0",
                        "on-error": "#ffffff",
                        "background": "#f8f9ff",
                        "on-secondary-fixed-variant": "#623f18",
                        "on-primary-fixed": "#001b3d",
                        "on-secondary-container": "#7a532a",
                        "tertiary": "#5e4138",
                        "outline-variant": "#c2c6d4",
                        "primary-fixed-dim": "#a8c8ff",
                        "on-tertiary-container": "#fcd1c4"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "display": ["Manrope"],
                        "body": ["Public Sans"],
                        "label": ["Public Sans"]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Public Sans', sans-serif;
        }
        .monolithic-text {
            font-family: 'Manrope', sans-serif;
            letter-spacing: -0.02em;
        }
        .glass-overlay {
            backdrop-filter: blur(20px);
            background-color: rgba(248, 249, 255, 0.8);
        }
    </style>
</head>
<body class="bg-surface text-on-surface">
<!-- TopNavBar -->
<header class="fixed top-0 w-full z-50 h-16 bg-[#eff4ff] dark:bg-[#162a45] shadow-none flex justify-between items-center px-6 w-full max-w-full">
<div class="flex items-center gap-2">
<button onclick="toggleSidebar()" class="p-2 hover:bg-[#d3e4fe]/50 rounded-full transition-colors hidden md:block">
<span class="material-symbols-outlined text-[#00488d]">menu_open</span>
</button>
<span class="text-xl font-black text-[#00488d] dark:text-[#d3e4fe] tracking-tighter font-['Manrope']">Industrial Admin</span>
<div class="hidden md:flex ml-8 gap-6">
<a class="text-[#00488d] dark:text-white font-bold border-b-2 border-[#00488d] py-5" href="#">Overview</a>
<a class="text-slate-500 dark:text-slate-400 font-medium hover:bg-[#d3e4fe]/50 dark:hover:bg-[#005fb8]/20 transition-colors py-5 px-2" href="#">Analytics</a>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-2 hover:bg-[#d3e4fe]/50 rounded-full transition-colors">
<span class="material-symbols-outlined text-[#00488d]">notifications</span>
</button>
<button class="p-2 hover:bg-[#d3e4fe]/50 rounded-full transition-colors">
<span class="material-symbols-outlined text-[#00488d]">settings</span>
</button>
<a href="{{ route('ProfilAdmin') }}">
<div class="w-8 h-8 rounded-full bg-primary-container overflow-hidden">
<img alt="Administrator Profile" data-alt="professional portrait of a middle-aged male administrator in a clean office setting with soft natural light" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzsidksKe4xBzLl_BsmX8V1Br--ApfLmzB0HTYb6_c3qvpelIMKEoLBVXyjr8stb9lyIxP4mu1BJ3BnMQjmgVCjXGKwUsYct6nbxgWLnh_s4kC-p1gTFQeTxQZfPHDnxB4pRDDr3mFfy2LN1eQatp-UpTsxbK3jtTpssmgdZPYQsSYV2cj-Lh8yMiTsULM7wqpXYlbzM08YTot5c5wapNbb6A39x4qSwW05JVzf3DyUyJWuhgvWsqOxSrwZIut8IALdaMyp67i2w"/>
</div>
</a>
</div>
</header>
<!-- SideNavBar -->
<aside id="adminSidebar" class="fixed left-0 top-0 h-screen w-72 pt-16 z-40 bg-[#eff4ff] dark:bg-[#162a45] flex flex-col gap-2 py-8 hidden md:flex transition-all duration-300 overflow-hidden">
<div class="px-6 mb-8 mt-4 whitespace-nowrap sidebar-header-text">
<p class="font-['Public_Sans'] text-xs font-bold uppercase tracking-widest text-secondary mb-1">Operations Hub</p>
<p class="text-slate-500 text-xs">Tectonic Precision v1.0</p>
</div>
<nav class="flex flex-col gap-1">
<a class="flex items-center gap-4 text-slate-600 dark:text-slate-400 py-3 px-6 hover:bg-white/50 transition-all group whitespace-nowrap" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">dashboard</span>
<span class="font-['Public_Sans'] text-sm tracking-wide sidebar-text">Overview</span>
</a>
<a class="flex items-center gap-4 text-slate-600 dark:text-slate-400 py-3 px-6 hover:bg-white/50 transition-all group whitespace-nowrap" href="{{ route('ShopeRegistry') }}">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">group</span>
<span class="font-['Public_Sans'] text-sm tracking-wide sidebar-text">User Registry</span>
</a>
<a class="flex items-center gap-4 bg-white dark:bg-[#00488d] text-[#00488d] dark:text-white rounded-r-full shadow-sm font-semibold py-3 px-6 translate-x-1 duration-200 whitespace-nowrap" href="{{ route('MenuUtamaAdmin') }}">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">storefront</span>
<span class="font-['Public_Sans'] text-sm tracking-wide sidebar-text">Seller Network</span>
</a>
<a class="flex items-center gap-4 text-slate-600 dark:text-slate-400 py-3 px-6 hover:bg-white/50 transition-all group whitespace-nowrap" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">monitoring</span>
<span class="font-['Public_Sans'] text-sm tracking-wide sidebar-text">Market Analytics</span>
</a>
<a class="flex items-center gap-4 text-slate-600 dark:text-slate-400 py-3 px-6 hover:bg-white/50 transition-all group whitespace-nowrap" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">receipt_long</span>
<span class="font-['Public_Sans'] text-sm tracking-wide sidebar-text">System Logs</span>
</a>
</nav>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const mainContents = document.querySelectorAll('main');
        const texts = sidebar.querySelectorAll('.sidebar-text');
        const headerText = sidebar.querySelector('.sidebar-header-text');

        if (sidebar.classList.contains('w-72')) {
            sidebar.classList.remove('w-72');
            sidebar.classList.add('w-20');
            texts.forEach(t => t.classList.add('hidden'));
            if(headerText) headerText.classList.add('hidden');
            
            mainContents.forEach(main => {
                if(main.classList.contains('md:ml-72')) { main.classList.remove('md:ml-72'); main.classList.add('md:ml-20'); }
                if(main.classList.contains('ml-72')) { main.classList.remove('ml-72'); main.classList.add('ml-20'); }
            });
        } else {
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-72');
            setTimeout(() => {
                texts.forEach(t => t.classList.remove('hidden'));
                if(headerText) headerText.classList.remove('hidden');
            }, 150);
            
            mainContents.forEach(main => {
                if(main.classList.contains('md:ml-20')) { main.classList.remove('md:ml-20'); main.classList.add('md:ml-72'); }
                if(main.classList.contains('ml-20')) { main.classList.remove('ml-20'); main.classList.add('ml-72'); }
            });
        }
    }
</script>
</aside>