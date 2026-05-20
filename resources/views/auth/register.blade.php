<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Daftar Akun Baru - Pasirku Marketplace</title>
    
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#ffdcbd",
                        "surface-variant": "#eae1db",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed": "#d7e5ec",
                        "tertiary-container": "#a1afb6",
                        "inverse-on-surface": "#f9efe9",
                        "surface-container-high": "#f0e6e0",
                        "error-container": "#ffdad6",
                        "background": "#fff8f5",
                        "on-secondary-fixed-variant": "#5b4137",
                        "on-primary": "#ffffff",
                        "surface-bright": "#fff8f5",
                        "error": "#ba1a1a",
                        "primary-container": "#d4a373",
                        "secondary": "#75584d",
                        "inverse-surface": "#342f2c",
                        "surface-dim": "#e2d8d2",
                        "tertiary": "#536067",
                        "secondary-fixed-dim": "#e4beb2",
                        "primary-fixed-dim": "#f0bd8b",
                        "surface-tint": "#7d562d",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "on-secondary-container": "#795c51",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed-variant": "#3c494f",
                        "on-background": "#1f1b17",
                        "surface-container-lowest": "#ffffff",
                        "surface-container": "#f6ece6",
                        "on-tertiary-container": "#364348",
                        "on-surface": "#1f1b17",
                        "surface": "#fff8f5",
                        "on-tertiary-fixed": "#101d23",
                        "primary": "#7d562d",
                        "on-secondary-fixed": "#2b160f",
                        "secondary-fixed": "#ffdbce",
                        "surface-container-highest": "#eae1db",
                        "outline": "#82756a",
                        "on-primary-fixed": "#2c1600",
                        "on-primary-container": "#5b3912",
                        "inverse-primary": "#f0bd8b",
                        "on-primary-fixed-variant": "#623f18",
                        "secondary-container": "#fed7ca",
                        "outline-variant": "#d4c4b7",
                        "surface-container-low": "#fcf2eb",
                        "on-surface-variant": "#50453b",
                        "tertiary-fixed-dim": "#bbc9d0"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "16px",
                        "margin-mobile": "16px",
                        "sm": "8px",
                        "xl": "32px",
                        "xs": "4px",
                        "margin-desktop": "48px",
                        "lg": "24px",
                        "base": "4px",
                        "gutter": "20px"
                    },
                    "fontFamily": {
                        "title-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "display-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "title-lg": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 4px 20px rgba(141, 110, 99, 0.05);
        }
        input:focus {
            box-shadow: 0 0 0 2px rgba(212, 163, 115, 0.2);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col overflow-x-hidden">

    <!-- Auth Layout Wrapper -->
    <main class="flex-grow flex flex-col md:flex-row min-h-screen">
        
        <!-- Left Side: Visual/Branding (Hidden on mobile) -->
        <section class="hidden md:flex w-1/2 relative overflow-hidden bg-surface-container-highest">
            <div class="absolute inset-0 z-0 flex items-center justify-center">
                <div class="w-full h-full flex items-center justify-center p-xl">
                    <img alt="Pasirku Logo Large" class="max-w-[60%] h-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfIfXNVBhP0rVPe-_T3m8ZKs1hTsaqR4uCb0hU55aZw4ctKB8Q3HtN0q6fmcidU8Ei82upieOL3jJTqq0LA9zvkkCUdOTYmz40yoxJuoFGJbD8zsBFdonlCzCJSi8zHOfFVSsRPMbR3g1uc1tA26DAjBCNSHNTFnI8nv9D02R6q5bGKcFpMFxzZE0dGjsvfV6BEQPF00cE6z3WZQF5izlwns5BtzvOlZVYk_OxtUsheq7qNSx3hRp0wa6zTk_8zTdD0RZ1Y8vcLUY"/>
                </div>
            </div>
            <div class="relative z-10 p-margin-desktop flex flex-col justify-end h-full text-white">
            </div>
        </section>
        
        <!-- Right Side: Registration Form -->
        <section class="w-full md:w-1/2 flex items-center justify-center p-margin-mobile md:p-margin-desktop bg-surface overflow-y-auto py-12 md:py-16">
            <div class="w-full max-w-md flex flex-col gap-lg my-auto">
                
                <!-- Header -->
                <div class="flex flex-col items-center md:items-start gap-xs text-center md:text-left">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface">Daftar Akun Pasirku</h1>
                    <p class="text-body-md text-on-surface-variant mt-sm">Gabung sekarang dengan ekosistem material bangunan terbaik.</p>
                </div>
                
                <!-- Main Form -->
                <form class="flex flex-col gap-md" method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <!-- Username Input -->
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="Username">Username</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">person</span>
                            <input class="w-full pl-[48px] pr-md py-md bg-surface-container-low border border-outline-variant rounded-xl text-on-surface font-body-md focus:outline-none focus:border-primary transition-all" 
                                   id="Username" name="Username" placeholder="Masukkan username" type="text" value="{{ old('Username') }}" required autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('Username')" class="mt-1 text-red-600 text-xs font-semibold" />
                    </div>
                    
                    <!-- Nomer Telepon Input -->
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="Nomer_Telepon">Nomer Telepon</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">call</span>
                            <input class="w-full pl-[48px] pr-md py-md bg-surface-container-low border border-outline-variant rounded-xl text-on-surface font-body-md focus:outline-none focus:border-primary transition-all" 
                                   id="Nomer_Telepon" name="Nomer_Telepon" placeholder="Contoh: 08123456789" type="text" value="{{ old('Nomer_Telepon') }}" />
                        </div>
                        <x-input-error :messages="$errors->get('Nomer_Telepon')" class="mt-1 text-red-600 text-xs font-semibold" />
                    </div>
                    
                    <!-- Email Input -->
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="Email">Email</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">alternate_email</span>
                            <input class="w-full pl-[48px] pr-md py-md bg-surface-container-low border border-outline-variant rounded-xl text-on-surface font-body-md focus:outline-none focus:border-primary transition-all" 
                                   id="Email" name="Email" placeholder="nama@email.com" type="email" value="{{ old('Email') }}" required autocomplete="email" />
                        </div>
                        <x-input-error :messages="$errors->get('Email')" class="mt-1 text-red-600 text-xs font-semibold" />
                    </div>
                    
                    <!-- Password Input -->
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="Password">Kata Sandi</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                            <input class="w-full pl-[48px] pr-[48px] py-md bg-surface-container-low border border-outline-variant rounded-xl text-on-surface font-body-md focus:outline-none focus:border-primary transition-all" 
                                   id="Password" name="Password" placeholder="Min. 8 karakter" type="password" required autocomplete="new-password" />
                            <button class="absolute right-md top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" onclick="const p=document.getElementById('Password');p.type=p.type==='password'?'text':'password';">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('Password')" class="mt-1 text-red-600 text-xs font-semibold" />
                    </div>
                    
                    <!-- Confirm Password Input -->
                    <div class="flex flex-col gap-xs">
                        <label class="font-label-md text-label-md text-on-surface-variant" for="Password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock_reset</span>
                            <input class="w-full pl-[48px] pr-[48px] py-md bg-surface-container-low border border-outline-variant rounded-xl text-on-surface font-body-md focus:outline-none focus:border-primary transition-all" 
                                   id="Password_confirmation" name="Password_confirmation" placeholder="Ulangi kata sandi" type="password" required autocomplete="new-password" />
                            <button class="absolute right-md top-1/2 -translate-y-1/2 text-outline hover:text-on-surface transition-colors" type="button" onclick="const p=document.getElementById('Password_confirmation');p.type=p.type==='password'?'text':'password';">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('Password_confirmation')" class="mt-1 text-red-600 text-xs font-semibold" />
                    </div>
                    
                    <!-- Submit Button -->
                    <button class="w-full py-md mt-sm bg-primary-container text-on-primary-container font-title-lg text-title-lg rounded-xl soft-shadow hover:brightness-105 active:scale-[0.98] transition-all duration-200" type="submit">
                        Daftar Akun Baru
                    </button>
                </form>
                
                <!-- Login Link -->
                <p class="text-center font-body-md text-on-surface-variant mt-sm">
                    Sudah punya akun? <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Masuk Sekarang</a>
                </p>
                
                <!-- Trust Signals -->
                <div class="mt-lg flex flex-col items-center gap-md">
                    <div class="flex items-center gap-xl opacity-60">
                        <div class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">lock_person</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider">SSL Encrypted</span>
                        </div>
                        <div class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">verified_user</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Secure Payment</span>
                        </div>
                        <div class="flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px]">gpp_good</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Buyer Protection</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
        
    </main>

    <!-- Simple Auth Footer -->
    <footer class="w-full bg-surface-container-lowest border-t border-outline-variant/30 py-md px-margin-mobile md:px-margin-desktop">
        <div class="max-w-[1280px] mx-auto flex flex-col md:flex-row justify-between items-center gap-md">
            <p class="font-body-md text-on-surface-variant/70">© 2026 Pasirku Industrial Marketplace. All rights reserved.</p>
            <div class="flex gap-lg">
                <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
                <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
                <a class="font-label-md text-on-surface-variant hover:text-primary transition-colors" href="#">Pusat Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>
