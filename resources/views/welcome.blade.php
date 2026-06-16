<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" type="image/png" href="{{ asset('img/LogoWebsite.png') }}"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pasirku - Marketplace Material & Pasir Berkualitas</title>

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@600;700;800;900&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#7d562d",
                        "primary-hover": "#623f1c",
                        "primary-container": "#d4a373",
                        "primary-container-hover": "#c8925f",
                        background: "#fff8f5",
                        surface: "#fffbfa",
                        "surface-container": "#f6ece6",
                        "surface-container-high": "#eae1db",
                        "on-surface": "#1f1b17",
                        "on-surface-variant": "#50453b",
                        outline: "#82756a",
                        "outline-variant": "#d4c4b7",
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                        headline: ["Manrope", "sans-serif"],
                    }
                }
            }
        }
    </script>

    <style>
        .glass-header {
            background: rgba(255, 248, 245, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(130, 117, 106, 0.15);
        }
        .soft-shadow {
            box-shadow: 0 10px 30px -10px rgba(125, 86, 45, 0.12);
        }
        .soft-shadow-lg {
            box-shadow: 0 20px 40px -15px rgba(125, 86, 45, 0.18);
        }
        .floating-badge {
            animation: float 4s ease-in-out infinite;
        }
        .floating-badge-delayed {
            animation: float 4s ease-in-out infinite 2s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .gradient-text {
            background: linear-gradient(135deg, #7d562d 20%, #d4a373 80%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-sans antialiased selection:bg-primary-container selection:text-on-surface">

    <!-- ===== HEADER / NAVIGATION ===== -->
    <header class="fixed top-0 left-0 w-full z-50 glass-header transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-2 group">
                <img src="{{ asset('img/LogoWebsite.png') }}" alt="Pasirku" class="h-10 w-auto group-hover:scale-105 transition-transform" />
                <span class="font-headline font-extrabold text-2xl tracking-tight text-primary">Pasir<span class="text-primary-container">ku</span></span>
            </a>

            <!-- Navigation Menu (Desktop) -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-on-surface-variant">
                <a href="#keunggulan" class="hover:text-primary transition-colors">Keunggulan</a>
                <a href="#cara-kerja" class="hover:text-primary transition-colors">Cara Kerja</a>
                <a href="#statistik" class="hover:text-primary transition-colors">Mitra</a>
            </nav>

            <!-- Authentication CTAs -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('MenuUtama') }}" class="px-5 py-2.5 bg-primary text-white hover:bg-primary-hover font-semibold text-sm rounded-xl transition-all duration-200 shadow-sm hover:shadow-md hover:translate-y-[-1px]">
                            Ke Menu Utama
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2.5 text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary-container text-on-surface font-bold text-sm rounded-xl transition-all duration-200 shadow-sm hover:bg-primary-container-hover hover:shadow-md hover:translate-y-[-1px]">
                                Daftar
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- ===== HERO SECTION ===== -->
    <section class="pt-36 pb-24 md:pt-48 md:pb-32 overflow-hidden relative flex items-center justify-center min-h-[85vh]">
        <!-- Blurred Background Image -->
        <div class="absolute inset-0 -z-20 overflow-hidden">
            <img src="{{ asset('img/TambangPasir.png') }}" alt="Background" class="w-full h-full object-cover blur-md scale-110" />
            <div class="absolute inset-0 bg-surface/80 backdrop-blur-[2px]"></div>
        </div>

        <!-- Decorative Ambient Blurs -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-primary-container/20 to-primary/10 rounded-full blur-[100px] pointer-events-none -z-10 animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-container/15 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-primary/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-4xl mx-auto px-6 flex flex-col items-center text-center gap-8 relative z-10">
            
            <!-- Badge Promo/Intro -->
            <!-- <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary font-semibold text-xs sm:text-sm tracking-wide uppercase shadow-sm border border-primary/20 animate-fade-in">
                <span class="material-symbols-outlined text-[16px] sm:text-[18px]">verified</span>
                Marketplace Pasir Terlengkap & Terpercaya
            </div> -->
            
            <!-- Headline -->
            <h1 class="font-headline font-black text-4xl sm:text-6xl lg:text-7xl tracking-tight leading-[1.1] text-on-surface max-w-3xl drop-shadow-sm">
                Pondasi Kokoh Dimulai dari <span class="gradient-text">Pasir Berkualitas</span>
            </h1>
            
            <!-- Paragraph -->
            <p class="text-base sm:text-xl text-on-surface-variant max-w-2xl leading-relaxed font-medium">
                Temukan toko pasir terdekat secara real-time, bandingkan harga secara transparan, dan lakukan pemesanan material bangunan instan dengan jaminan keamanan transaksi.
            </p>
            
            <!-- CTA Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center mt-2 w-full sm:w-auto">
                @auth
                    <a href="{{ route('MenuUtama') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-headline font-bold rounded-2xl shadow-lg hover:bg-primary-hover hover:translate-y-[-2px] transition-all duration-200 text-center flex items-center justify-center gap-2 group">
                        Cari Toko Pasir Terdekat
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-white font-headline font-bold rounded-2xl shadow-lg hover:bg-primary-hover hover:translate-y-[-2px] transition-all duration-200 text-center flex items-center justify-center gap-2 group">
                        Mulai Belanja Sekarang
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">shopping_cart</span>
                    </a>
                    <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-surface-container border border-outline-variant/50 text-on-surface font-headline font-bold rounded-2xl hover:bg-surface-container-high transition-all duration-200 text-center flex items-center justify-center gap-2">
                        Gabung Mitra Penjual
                        <span class="material-symbols-outlined text-lg">storefront</span>
                    </a>
                @endauth
            </div>

            <!-- Small Trust Badges -->
            <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 mt-8 pt-8 border-t border-outline-variant/20 w-full max-w-2xl">
                <div class="flex items-center gap-2 bg-surface-container/60 px-4 py-2 rounded-2xl border border-outline-variant/10 shadow-sm backdrop-blur-sm">
                    <span class="material-symbols-outlined text-primary text-xl">gpp_good</span>
                    <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Garansi Transaksi</span>
                </div>
                <div class="flex items-center gap-2 bg-surface-container/60 px-4 py-2 rounded-2xl border border-outline-variant/10 shadow-sm backdrop-blur-sm">
                    <span class="material-symbols-outlined text-primary text-xl">local_shipping</span>
                    <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Pengiriman Cepat</span>
                </div>
                <!-- <div class="flex items-center gap-2 bg-surface-container/60 px-4 py-2 rounded-2xl border border-outline-variant/10 shadow-sm backdrop-blur-sm">
                    <span class="material-symbols-outlined text-primary text-xl">map</span>
                    <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Lacak Real-Time</span>
                </div> -->
            </div>
            
        </div>
    </section>

    <!-- ===== FEATURES SECTION ===== -->
    <section id="keunggulan" class="py-20 bg-surface-container/50 border-y border-outline-variant/20">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center max-w-2xl mx-auto mb-16 flex flex-col gap-3">
                <span class="text-xs font-bold text-primary uppercase tracking-[0.2em]">Kenapa Harus Pasirku?</span>
                <h2 class="font-headline font-extrabold text-3xl sm:text-4xl text-on-surface">
                    Kemudahan Transaksi Material Bangunan dalam Genggaman
                </h2>
                <div class="w-16 h-1 bg-primary mx-auto rounded-full mt-2"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white border border-outline-variant/30 p-8 rounded-3xl soft-shadow transition-all duration-300 hover:translate-y-[-6px] hover:border-primary/20 group">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">map</span>
                    </div>
                    <h3 class="font-headline font-bold text-xl mb-3 text-on-surface group-hover:text-primary transition-colors">
                        Pencarian Toko Terdekat
                    </h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        Cari, filter, dan temukan toko pasir terdekat secara real-time terintegrasi dengan teknologi Leaflet maps yang presisi.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white border border-outline-variant/30 p-8 rounded-3xl soft-shadow transition-all duration-300 hover:translate-y-[-6px] hover:border-primary/20 group">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">payments</span>
                    </div>
                    <h3 class="font-headline font-bold text-xl mb-3 text-on-surface group-hover:text-primary transition-colors">
                        Harga Transparan & Bersaing
                    </h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        Lihat katalog harga secara langsung tanpa biaya tersembunyi. Hubungi langsung pihak penjual untuk negosiasi terbaik Anda.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white border border-outline-variant/30 p-8 rounded-3xl soft-shadow transition-all duration-300 hover:translate-y-[-6px] hover:border-primary/20 group">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">local_shipping</span>
                    </div>
                    <h3 class="font-headline font-bold text-xl mb-3 text-on-surface group-hover:text-primary transition-colors">
                        Sistem Lacak Pengiriman
                    </h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed">
                        Pantau terus jalannya armada pengiriman material dari toko menuju ke lokasi proyek pembangunan Anda langsung dari dashboard.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== CARA KERJA SECTION ===== -->
    <section id="cara-kerja" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center max-w-2xl mx-auto mb-16 flex flex-col gap-3">
                <span class="text-xs font-bold text-primary uppercase tracking-[0.2em]">Langkah Mudah</span>
                <h2 class="font-headline font-extrabold text-3xl sm:text-4xl text-on-surface">
                    Cara Cepat Menggunakan Pasirku
                </h2>
                <div class="w-16 h-1 bg-primary mx-auto rounded-full mt-2"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-full bg-primary text-white font-bold flex items-center justify-center font-headline text-lg shadow-md">
                        1
                    </div>
                    <h4 class="font-headline font-bold text-lg text-on-surface">Buat Akun</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed max-w-[200px]">
                        Daftar akun baru sebagai pembeli atau penjual secara instan dan aman.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-full bg-primary text-white font-bold flex items-center justify-center font-headline text-lg shadow-md">
                        2
                    </div>
                    <h4 class="font-headline font-bold text-lg text-on-surface">Pilih Toko & Material</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed max-w-[200px]">
                        Cari toko pasir terdekat dari lokasi Anda dan tentukan jumlah material yang diperlukan.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-full bg-primary text-white font-bold flex items-center justify-center font-headline text-lg shadow-md">
                        3
                    </div>
                    <h4 class="font-headline font-bold text-lg text-on-surface">Memesan Pasir</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed max-w-[200px]">
                        Pilih jenis pasir yang dibutuhkan dan pesan secara online.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center gap-4 relative z-10">
                    <div class="w-12 h-12 rounded-full bg-primary text-white font-bold flex items-center justify-center font-headline text-lg shadow-md">
                        4
                    </div>
                    <h4 class="font-headline font-bold text-lg text-on-surface">Terima Barang</h4>
                    <p class="text-xs text-on-surface-variant leading-relaxed max-w-[200px]">
                        Armada toko mengirimkan material ke alamat tujuan Anda. Transaksi selesai dengan aman!
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== STATISTIK / PARTNER SECTION ===== -->
    <section id="statistik" class="py-16 bg-surface-container border-t border-outline-variant/20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <h3 class="font-headline font-extrabold text-4xl text-primary">100+</h3>
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant mt-2">Mitra Toko Terdaftar</p>
                </div>
                <div>
                    <h3 class="font-headline font-extrabold text-4xl text-primary">10k+</h3>
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant mt-2">Order Material Selesai</p>
                </div>
                <div>
                    <h3 class="font-headline font-extrabold text-4xl text-primary">99%</h3>
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant mt-2">Kepuasan Transaksi</p>
                </div>
                <div>
                    <h3 class="font-headline font-extrabold text-4xl text-primary">24/7</h3>
                    <p class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant mt-2">Dukungan Layanan Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-on-surface text-surface-container py-12 border-t border-outline/30">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/LogoWebsite.png') }}" alt="Pasirku" class="h-8 w-auto" />
                <span class="font-headline font-bold text-lg tracking-tight text-white">Pasir<span class="text-primary-container">ku</span></span>
            </div>
            <p class="text-xs text-outline-variant">© 2026 Pasirku Industrial Marketplace. All rights reserved.</p>
            <div class="flex gap-6 text-xs text-outline-variant">
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors">Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>
