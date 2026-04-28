<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Checkout | Pasir Ku</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Public+Sans:wght@300;400;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
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
          borderRadius: {
            DEFAULT: "0.125rem",
            lg: "0.25rem",
            xl: "0.5rem",
            full: "0.75rem"
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Public Sans"],
            label: ["Public Sans"]
          }
        }
      }
    }
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    body {
      font-family: 'Public Sans', sans-serif;
      background-color: #f8f9ff;
      color: #0b1c30;
    }
    h1, h2, h3, h4 {
      font-family: 'Manrope', sans-serif;
    }
    .strata-grid {
      display: grid;
      grid-template-columns: 1fr 400px;
      gap: 2rem;
    }
    @media (max-width: 1024px) {
      .strata-grid {
        grid-template-columns: 1fr;
      }
    }
    .input-industrial {
      background-color: #dce9ff;
      border: none;
      border-bottom: 2px solid transparent;
      transition: border-bottom 0.2s ease;
    }
    .input-industrial:focus {
      border-bottom: 2px solid #00488d;
      box-shadow: none;
      outline: none;
    }
    .glass-panel {
      background: rgba(248, 249, 255, 0.8);
      backdrop-filter: blur(20px);
    }
  </style>
</head>

<body class="bg-surface text-on-surface">

  @include('topbar')

  <main class="max-w-7xl mx-auto px-6 pt-24 pb-12">

    <div class="mb-12">
      <p class="text-secondary font-bold uppercase tracking-widest text-xs mb-2">Finalisasi Pesanan</p>
      <h1 class="text-5xl font-extrabold tracking-tight text-on-surface">Checkout</h1>
    </div>

    <div class="strata-grid">

      <!-- Left Column: Forms -->
      <div class="space-y-8">

        <!-- Section: Shipping Address -->
        <section class="bg-surface-container-low p-8 rounded-xl relative overflow-hidden">
          <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-primary" data-icon="local_shipping">local_shipping</span>
            <h2 class="text-2xl font-bold">Alamat Pengiriman</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col gap-2">
              <label class="text-xs font-bold text-secondary uppercase tracking-wider">Nama Penerima</label>
              <input class="input-industrial px-4 py-3 rounded-lg w-full" placeholder="Contoh: PT. Konstruksi Maju" type="text" />
            </div>
            <div class="flex flex-col gap-2">
              <label class="text-xs font-bold text-secondary uppercase tracking-wider">Nomor Telepon Lapangan</label>
              <input class="input-industrial px-4 py-3 rounded-lg w-full" placeholder="+62 812 XXXX" type="tel" />
            </div>
            <div class="md:col-span-2 flex flex-col gap-2">
              <label class="text-xs font-bold text-secondary uppercase tracking-wider">Detail Lokasi Proyek</label>
              <textarea class="input-industrial px-4 py-3 rounded-lg w-full resize-none"
                placeholder="Jl. Industrial No. 45, Area Konstruksi Blok B" rows="3"></textarea>
            </div>
            <div class="flex flex-col gap-2">
              <label class="text-xs font-bold text-secondary uppercase tracking-wider">Kode Pos / Area</label>
              <input class="input-industrial px-4 py-3 rounded-lg w-full" placeholder="12345" type="text" />
            </div>
          </div>
        </section>

        <!-- Section: Delivery Schedule -->
        <section class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border-l-8 border-secondary">
          <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-secondary" data-icon="calendar_today">calendar_today</span>
            <h2 class="text-2xl font-bold">Jadwal Pengiriman Pasir</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-surface-container-low p-6 rounded-lg">
              <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-4">Pilih Tanggal</p>
              <div class="flex items-center justify-between bg-white px-4 py-3 rounded-md">
                <span class="font-semibold">24 Oktober 2023</span>
                <span class="material-symbols-outlined text-primary" data-icon="event">event</span>
              </div>
            </div>
            <div class="bg-surface-container-low p-6 rounded-lg">
              <p class="text-xs font-bold text-secondary uppercase tracking-wider mb-4">Estimasi Waktu Tiba</p>
              <div class="grid grid-cols-2 gap-2">
                <button class="bg-primary text-white py-2 rounded font-bold text-sm">Pagi (08:00)</button>
                <button class="bg-white text-on-surface py-2 rounded font-bold text-sm hover:bg-primary-fixed">Siang (13:00)</button>
              </div>
            </div>
          </div>
        </section>

        <!-- Section: Material Selection Review -->
        <div class="grid grid-cols-3 gap-4">
          <div class="bg-surface-container-high aspect-video rounded-xl flex flex-col justify-end p-4 relative group cursor-pointer overflow-hidden">
            <img alt="Sand Texture"
              class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30 grayscale"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRVc8wBYMwhz6Z3nfXbagYl6IL-ISuls71Qn7thhIRk8gq1ZFW5HXviix2qGzOOVceSBpwJqqb1XydGwVY9xt1qMReXVRWuVTdCehwfP4C5uAJeI_5YsbsJCTeeWtNPs_OV6rmTiAaIuz8JaednsWjAjop2IvlPub26hzul6ifQ1Av_abclK1asG9Zh77ER4rLVaNjzUbxk4YXcWw1insz4sY6noFI4F1P3GHCKhBdx3suGtq6ej3mfD1mdHJ7pRR9YJdC4Jer8w" />
            <span class="relative z-10 text-xs font-bold uppercase tracking-tighter opacity-70">Material</span>
            <h4 class="relative z-10 font-black text-lg">Pasir Sungai Progo</h4>
          </div>
          <div class="bg-surface-container-high aspect-video rounded-xl flex flex-col justify-end p-4 relative group overflow-hidden">
            <img alt="Dump Truck"
              class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30 grayscale"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1eWakIa7-JPtuFz2IP-CQr64t1MN8sq3Pw8LBgHViPVNMhxdnUQADYkF6S8rrIeqpwYGZIj2s8eBcoPOZb5Ar8YrkUtFuvSefkbT5slJRyXtxlHxUg4kWxIO_tY6sS38VIVvwEgXCdPRH-G9FGnHFVpG5aDJFhNF7c3Q7RKW_HpHr9GioeM9LgTEth_ndzppFuv9juPxyQzfEG5Qvh-bwDpCWtAIBVzFUlrufk5e-EAD1onHq1pCZ0UKbK7itZhaneLuH6YVRow" />
            <span class="relative z-10 text-xs font-bold uppercase tracking-tighter opacity-70">Volume</span>
            <h4 class="relative z-10 font-black text-lg">24 m³ (3 Truk)</h4>
          </div>
          <div class="bg-surface-container-high aspect-video rounded-xl flex flex-col justify-end p-4 relative overflow-hidden">
            <div class="absolute inset-0 bg-primary/10"></div>
            <span class="relative z-10 text-xs font-bold uppercase tracking-tighter opacity-70">Status</span>
            <h4 class="relative z-10 font-black text-lg text-primary">Siap Kirim</h4>
          </div>
        </div>

      </div>

      <!-- Right Column: Payment & Summary -->
      <div class="space-y-6">
        <div class="sticky top-24">

          <!-- Order Summary Card -->
          <div class="bg-on-surface text-surface rounded-xl p-8 mb-6 relative">
            <div class="absolute top-0 right-0 p-4 opacity-10">
              <span class="material-symbols-outlined text-9xl" style="font-variation-settings: 'wght' 700">receipt_long</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-[0.2em] mb-6 text-surface-dim">Ringkasan Pembayaran</h3>
            <div class="space-y-4 mb-8">
              <div class="flex justify-between text-sm opacity-80">
                <span>Subtotal Material</span>
                <span>Rp 8.400.000</span>
              </div>
              <div class="flex justify-between text-sm opacity-80">
                <span>Biaya Logistik (3 Armada)</span>
                <span>Rp 1.250.000</span>
              </div>
              <div class="flex justify-between text-sm opacity-80">
                <span>Pajak (PPN 11%)</span>
                <span>Rp 1.061.500</span>
              </div>
            </div>
            <div class="border-t border-white/10 pt-6 mb-2">
              <div class="flex justify-between items-end">
                <span class="text-sm font-bold uppercase">Total Tagihan</span>
                <span class="text-3xl font-black text-primary-fixed">Rp 10.711.500</span>
              </div>
            </div>
          </div>

          <!-- Payment Section -->
          <div class="bg-white p-8 rounded-xl shadow-xl">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary" data-icon="qr_code_2">qr_code_2</span>
              Pembayaran QRIS
            </h3>
            <div class="flex flex-col items-center justify-center bg-surface-container-low p-6 rounded-lg mb-6">
              <!-- Placeholder for QRIS -->
              <div class="w-48 h-48 bg-white p-3 rounded-lg shadow-inner mb-4 relative flex items-center justify-center">
                <div class="w-full h-full bg-slate-100 flex items-center justify-center border-2 border-dashed border-slate-300">
                  <span class="material-symbols-outlined text-4xl text-slate-400" data-icon="qr_code_scanner">qr_code_scanner</span>
                </div>
                <div class="absolute inset-0 bg-gradient-to-tr from-primary/5 to-transparent pointer-events-none"></div>
              </div>
              <p class="text-[10px] text-center text-on-surface-variant font-bold uppercase tracking-wider">
                Pindai QRIS di atas melalui Aplikasi Bank atau E-Wallet Anda
              </p>
            </div>
            <div class="space-y-4">
              <button class="w-full flex items-center justify-center gap-2 bg-surface-container-high py-4 rounded-lg font-bold hover:bg-surface-container-highest transition-colors group">
                <span class="material-symbols-outlined group-hover:scale-110 transition-transform" data-icon="cloud_upload">cloud_upload</span>
                Upload Bukti Pembayaran
              </button>
              <button class="w-full bg-gradient-to-br from-primary to-primary-container text-white py-5 rounded-lg font-black text-lg shadow-lg hover:scale-[1.02] active:scale-95 transition-all">
                KONFIRMASI PESANAN
              </button>
              <p class="text-[10px] text-center text-on-surface-variant italic">
                *Dengan mengklik Konfirmasi, Anda menyetujui syarat &amp; ketentuan pengiriman material konstruksi.
              </p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </main>

  <footer class="mt-20 bg-surface-container-low py-12 px-6">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
      <div class="flex flex-col">
        <span class="text-2xl font-black text-blue-900 tracking-tighter">Pasir Ku</span>
        <p class="text-sm text-on-surface-variant mt-1">Industrial Raw Material Hub</p>
      </div>
      <div class="flex gap-8">
        <a class="text-xs font-bold uppercase text-on-surface-variant hover:text-primary" href="#">Bantuan</a>
        <a class="text-xs font-bold uppercase text-on-surface-variant hover:text-primary" href="#">Kebijakan Pengembalian</a>
        <a class="text-xs font-bold uppercase text-on-surface-variant hover:text-primary" href="#">Kontak Support</a>
      </div>
      <div class="text-[10px] font-medium text-slate-400">
        © 2024 Pasir Ku. All rights reserved.
      </div>
    </div>
  </footer>

</body>
</html>