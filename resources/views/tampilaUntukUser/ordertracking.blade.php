<x-layout-user title="Pesanan Saya | Pasir Ku" :fullHeight="false">
  @push('head')
  <style>
    .tectonic-shadow {
      box-shadow: 0px 24px 48px rgba(11, 28, 48, 0.08);
    }
    .order-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .order-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(11, 28, 48, 0.12);
    }
    .step-line {
      transition: background-color 0.5s ease;
    }
    .status-pulse {
      animation: statusPulse 2s infinite;
    }
    @keyframes statusPulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
    .empty-state-icon {
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    .fade-in-up {
      animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .slide-in-right {
      animation: slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
    @keyframes slideInRight {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }
    .pulse-ring {
      position: relative;
    }
    .pulse-ring::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background-color: var(--md-sys-color-primary, #944a00);
      opacity: 0.4;
      animation: ringScale 1.5s infinite ease-out;
      z-index: -1;
    }
    @keyframes ringScale {
      0% { transform: scale(1); opacity: 0.4; }
      100% { transform: scale(1.8); opacity: 0; }
    }
    /* Modal Styles */
    .report-overlay { 
      position: fixed;
      inset: 0;
      z-index: 99999;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(4px);
    }
    .report-overlay.active { 
      display: flex;
    }
    .report-modal { 
      transform: scale(0.95);
      transition: all 0.2s ease-out;
      opacity: 0;
    }
    .report-overlay.active .report-modal { 
      transform: scale(1);
      opacity: 1;
    }
  </style>
  @endpush

  {{-- Toast Notifikasi Sukses --}}
  @if(session('success'))
    <div id="toast-success" class="fixed top-20 left-1/2 -translate-x-1/2 z-[99999] bg-gradient-to-r from-emerald-600 to-green-500 text-white font-bold py-4 px-6 rounded-2xl shadow-2xl flex items-center gap-3 border border-white/20 transition-all duration-500 animate-bounce">
      <span class="material-symbols-outlined bg-white/20 p-1.5 rounded-full text-lg leading-none" style="font-variation-settings: 'FILL' 1">check_circle</span>
      <span class="text-sm font-semibold tracking-tight">{{ session('success') }}</span>
      <button onclick="document.getElementById('toast-success').remove()" class="hover:bg-white/20 p-1 rounded-lg transition-colors ml-4 flex items-center justify-center">
        <span class="material-symbols-outlined text-sm leading-none">close</span>
      </button>
    </div>
    <script>
      setTimeout(() => {
        const toast = document.getElementById('toast-success');
        if (toast) {
          toast.style.opacity = '0';
          toast.style.transform = 'translate(-50%, -20px)';
          setTimeout(() => toast.remove(), 500);
        }
      }, 5000);
    </script>
  @endif

  <!-- Content Shell -->
  <div class="p-6 md:p-10 max-w-5xl mx-auto w-full mb-24 md:mb-10 fade-in-up">

    <!-- Page Header -->
    <div class="mb-8">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center">
          <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1">receipt_long</span>
        </div>
        <div>
          <h1 class="text-on-surface text-2xl md:text-3xl font-extrabold tracking-tight">Pesanan Saya</h1>
          <p class="text-on-surface-variant text-sm font-medium">Pantau status pesanan Anda secara real-time</p>
        </div>
      </div>
    </div>

    <!-- Orders List -->
    @forelse($orders as $index => $order)
      @php
        // Determine which step the order is at
        $status = $order->Status_Pesanan;
        $isCancelled = $status === \App\Models\Pesanan::STATUS_DIBATALKAN;

        // Steps: 1=Pending, 2=Diproses, 3=Dikirim, 4=Selesai
        $stepMap = [
            \App\Models\Pesanan::STATUS_PENDING => 1,
            \App\Models\Pesanan::STATUS_DIPROSES => 2,
            \App\Models\Pesanan::STATUS_DIKIRIM => 3,
            \App\Models\Pesanan::STATUS_SELESAI => 4,
            \App\Models\Pesanan::STATUS_DIBATALKAN => 0,
        ];
        $currentStep = $stepMap[$status] ?? 0;

        // Status colors for the main badge
        $statusColors = match($status) {
            \App\Models\Pesanan::STATUS_PENDING => 'bg-amber-100 text-amber-700 border-amber-200',
            \App\Models\Pesanan::STATUS_DIPROSES => 'bg-blue-100 text-blue-700 border-blue-200',
            \App\Models\Pesanan::STATUS_DIKIRIM => 'bg-purple-100 text-purple-700 border-purple-200',
            \App\Models\Pesanan::STATUS_SELESAI => 'bg-green-100 text-green-700 border-green-200',
            \App\Models\Pesanan::STATUS_DIBATALKAN => 'bg-red-100 text-red-600 border-red-200',
            default => 'bg-gray-100 text-gray-600 border-gray-200',
        };
      @endphp

      <div class="order-card bg-surface-container-lowest rounded-2xl tectonic-shadow overflow-hidden mb-6 border border-outline-variant/20 slide-in-right" style="animation-delay: {{ $index * 150 }}ms">

        <!-- Order Header -->
        <div class="px-6 py-4 bg-surface-container-low/50 border-b border-outline-variant/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl {{ $isCancelled ? 'bg-red-100' : ($currentStep >= 4 ? 'bg-green-100' : 'bg-primary/10') }} flex items-center justify-center">
              <span class="material-symbols-outlined {{ $isCancelled ? 'text-red-500' : ($currentStep >= 4 ? 'text-green-600' : 'text-primary') }}" style="font-variation-settings: 'FILL' 1">
                {{ $isCancelled ? 'cancel' : ($currentStep >= 4 ? 'task_alt' : 'local_shipping') }}
              </span>
            </div>
            <div>
              <h3 class="text-on-surface font-bold text-base tracking-tight">#ORD-{{ str_pad($order->ID_Pesanan, 4, '0', STR_PAD_LEFT) }}</h3>
              <p class="text-on-surface-variant text-xs font-medium">{{ $order->created_at->format('d M Y, H:i') }} · {{ $order->Nama_Toko ?? 'Toko' }}</p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] uppercase font-black tracking-wider border {{ $statusColors }}">
              <span class="material-symbols-outlined text-[13px]" style="font-variation-settings: 'FILL' 1">{{ $order->statusIcon() }}</span>
              {{ $order->statusLabel() }}
            </span>
            @if(!$isCancelled && $status !== \App\Models\Pesanan::STATUS_SELESAI)
            <button type="button" onclick="openReportModal({{ $order->ID_Pesanan }})" title="Laporkan Pesanan"
              class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-100 border border-red-200/50 flex items-center justify-center transition-all duration-200 group">
              <span class="material-symbols-outlined text-red-400 group-hover:text-red-600 text-[18px]" style="font-variation-settings: 'FILL' 1">flag</span>
            </button>
            @endif
          </div>
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Status Stepper --}}
            <div class="lg:col-span-7">
              @if($isCancelled)
                {{-- Cancelled State --}}
                <div class="bg-red-50 border border-red-200/50 rounded-xl p-5">
                  <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                      <span class="material-symbols-outlined text-red-500" style="font-variation-settings: 'FILL' 1">block</span>
                    </div>
                    <div>
                      <h4 class="text-red-700 font-bold text-sm">Pesanan Dibatalkan</h4>
                      <p class="text-red-600/80 text-xs mt-1 leading-relaxed">
                        @if($order->alasan_tolak)
                          Alasan: {{ $order->alasan_tolak }}
                        @else
                          Pesanan ini telah dibatalkan oleh toko. Silakan hubungi toko untuk informasi lebih lanjut.
                        @endif
                      </p>
                    </div>
                  </div>
                </div>
              @else
                <div class="space-y-0">
                  {{-- Step 1 --}}
                  <div class="flex gap-4 min-h-[70px]">
                    <div class="flex flex-col items-center">
                      <div class="w-7 h-7 rounded-full {{ $currentStep >= 1 ? ($currentStep > 1 ? 'bg-primary' : 'bg-primary/20 border-2 border-primary pulse-ring') : 'bg-surface-container-high' }} flex items-center justify-center">
                        @if($currentStep > 1) <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                        @elseif($currentStep == 1) <div class="w-2.5 h-2.5 bg-primary rounded-full status-pulse"></div>
                        @endif
                      </div>
                      <div class="w-0.5 flex-1 {{ $currentStep > 1 ? 'bg-primary' : 'bg-outline-variant/30' }} step-line"></div>
                    </div>
                    <div class="pb-5">
                      <h4 class="text-sm {{ $currentStep == 1 ? 'text-primary font-extrabold' : 'text-on-surface font-bold' }}">Menunggu Konfirmasi</h4>
                    </div>
                  </div>

                  {{-- Step 2 --}}
                  <div class="flex gap-4 min-h-[70px]">
                    <div class="flex flex-col items-center">
                      <div class="w-7 h-7 rounded-full {{ $currentStep >= 2 ? ($currentStep > 2 ? 'bg-primary' : 'bg-primary/20 border-2 border-primary pulse-ring') : 'bg-surface-container-high' }} flex items-center justify-center">
                        @if($currentStep > 2) <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                        @elseif($currentStep == 2) <div class="w-2.5 h-2.5 bg-primary rounded-full status-pulse"></div>
                        @endif
                      </div>
                      <div class="w-0.5 flex-1 {{ $currentStep > 2 ? 'bg-primary' : 'bg-outline-variant/30' }} step-line"></div>
                    </div>
                    <div class="pb-5">
                      <h4 class="text-sm {{ $currentStep == 2 ? 'text-primary font-extrabold' : 'text-on-surface font-bold' }}">Sedang Diproses</h4>
                    </div>
                  </div>

                  {{-- Step 3 --}}
                  <div class="flex gap-4 min-h-[70px]">
                    <div class="flex flex-col items-center">
                      <div class="w-7 h-7 rounded-full {{ $currentStep >= 3 ? ($currentStep > 3 ? 'bg-primary' : 'bg-primary/20 border-2 border-primary pulse-ring') : 'bg-surface-container-high' }} flex items-center justify-center">
                        @if($currentStep > 3) <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                        @elseif($currentStep == 3) <div class="w-2.5 h-2.5 bg-primary rounded-full status-pulse"></div>
                        @endif
                      </div>
                      <div class="w-0.5 flex-1 {{ $currentStep > 3 ? 'bg-primary' : 'bg-outline-variant/30' }} step-line"></div>
                    </div>
                    <div class="pb-5">
                      <h4 class="text-sm {{ $currentStep == 3 ? 'text-primary font-extrabold' : 'text-on-surface font-bold' }}">Dalam Pengiriman</h4>
                    </div>
                  </div>

                  {{-- Step 4 --}}
                  <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                      <div class="w-7 h-7 rounded-full {{ $currentStep >= 4 ? 'bg-green-500' : 'bg-surface-container-high' }} flex items-center justify-center">
                        @if($currentStep >= 4) <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span> @endif
                      </div>
                    </div>
                    <div class="flex-1">
                      <h4 class="text-sm {{ $currentStep >= 4 ? 'text-green-600 font-extrabold' : 'text-on-surface-variant font-medium' }}">Pesanan Selesai</h4>
                      
                      {{-- Action: Konfirmasi Diterima --}}
                      @if($currentStep == 3)
                        <div class="mt-4 bg-green-50 border border-green-200/50 rounded-xl p-4">
                          <p class="text-green-800 font-bold text-xs mb-3">Pesanan sudah sampai?</p>
                          <form method="POST" action="{{ route('ordertracking.selesai', $order->ID_Pesanan) }}">
                            @csrf @method('PUT')
                            <button type="submit" class="w-full bg-green-600 text-white py-2.5 rounded-xl text-sm font-bold shadow-sm">Konfirmasi Diterima</button>
                          </form>
                        </div>
                      @endif

                      {{-- Action: Beri Rating --}}
                      @if($currentStep >= 4)
                        <div class="mt-4 pt-4 border-t border-green-100">
                          @if($order->review)
                            <div class="flex items-center gap-2 text-amber-500">
                              @for($i=1;$i<=5;$i++) <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' {{ $i <= $order->review->Rating ? 1 : 0 }}">star</span> @endfor
                              <span class="text-[10px] font-bold text-green-700">Sudah Dinilai</span>
                            </div>
                          @else
                            <button onclick="openReviewModal({{ $order->ID_Pesanan }})" class="bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold">Beri Rating</button>
                          @endif
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              @endif
            </div>

            {{-- Order Details Sidebar --}}
            <div class="lg:col-span-5 space-y-4">
              <div class="bg-surface-container-low/50 rounded-xl p-4">
                <p class="text-[10px] font-black text-on-surface-variant uppercase mb-1">Produk</p>
                <h4 class="text-on-surface font-bold text-sm">{{ $order->nama_produk }}</h4>
                <div class="mt-3 pt-3 border-t border-outline-variant/20 flex justify-between items-center">
                  <span class="text-xs font-semibold text-on-surface-variant">Total</span>
                  <span class="text-primary font-black">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Modal Report (Per Order) --}}
      <div id="reportOverlay-{{ $order->ID_Pesanan }}" class="report-overlay">
        <div class="report-modal bg-surface-container-lowest rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border">
          <div class="px-6 py-4 bg-red-50 border-b flex justify-between items-center">
            <h3 class="text-red-800 font-bold">Laporkan Pesanan</h3>
            <button onclick="closeReportModal({{ $order->ID_Pesanan }})" class="material-symbols-outlined text-red-400">close</button>
          </div>
          <form method="POST" action="{{ route('ordertracking.report', $order->ID_Pesanan) }}" class="p-6">
            @csrf
            <textarea name="alasan_report" rows="4" required class="w-full bg-surface-container border rounded-xl p-3 text-sm" placeholder="Alasan laporan..."></textarea>
            <div class="mt-6 flex justify-end gap-3">
              <button type="button" onclick="closeReportModal({{ $order->ID_Pesanan }})" class="text-sm font-bold px-4 py-2">Batal</button>
              <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-xl text-sm font-bold">Kirim Laporan</button>
            </div>
          </form>
        </div>
      </div>
    @empty
      <div class="text-center py-20 bg-surface-container-lowest rounded-2xl shadow-sm border border-dashed">
        <span class="material-symbols-outlined text-5xl text-outline mb-4">shopping_bag</span>
        <h3 class="font-bold text-on-surface">Belum ada pesanan</h3>
        <a href="{{ route('MenuUtama') }}" class="mt-4 inline-block bg-primary text-white px-6 py-2 rounded-xl font-bold">Mulai Belanja</a>
      </div>
    @endforelse
  </div>

  {{-- Modal Review (Global) --}}
  <div id="reviewModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-surface-container-lowest rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in zoom-in duration-200">
      <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-xl font-black">Beri Rating & Ulasan</h3>
        <button onclick="closeReviewModal()" class="material-symbols-outlined">close</button>
      </div>
      <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        <input type="hidden" name="ID_Pesanan" id="modalOrderID">
        <div class="text-center">
          <div class="flex justify-center gap-2 mb-4">
            @for($i=1;$i<=5;$i++)
              <button type="button" onclick="setRating({{ $i }})" class="star-btn"><span class="material-symbols-outlined text-4xl star-icon text-outline-variant">star</span></button>
            @endfor
          </div>
          <input type="hidden" name="Rating" id="ratingInput" required>
          <p id="ratingLabel" class="text-xs font-black text-primary uppercase"></p>
        </div>
        <textarea name="Ulasan" rows="3" class="w-full bg-surface-container rounded-2xl p-4 text-sm" placeholder="Tulis ulasan..."></textarea>
        <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-black">KIRIM ULASAN</button>
      </form>
    </div>
  </div>

  @push('scripts')
  <script>
    // Review Modal Logic
    function openReviewModal(id) { 
      document.getElementById('modalOrderID').value = id;
      document.getElementById('reviewModal').classList.replace('hidden', 'flex');
      document.body.style.overflow = 'hidden';
    }
    function closeReviewModal() { 
      document.getElementById('reviewModal').classList.replace('flex', 'hidden');
      document.body.style.overflow = '';
    }
    function setRating(v) {
      document.getElementById('ratingInput').value = v;
      const labels = ['', 'Buruk Sekali', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
      document.getElementById('ratingLabel').innerText = labels[v];
      document.querySelectorAll('.star-icon').forEach((s, i) => {
        s.style.fontVariationSettings = `'FILL' ${i < v ? 1 : 0}`;
        s.classList.toggle('text-amber-500', i < v);
        s.classList.toggle('text-outline-variant', i >= v);
      });
    }

    // Report Modal Logic
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.report-overlay').forEach(m => document.body.appendChild(m));
    });
    function openReportModal(id) {
      const el = document.getElementById('reportOverlay-' + id);
      if(el) { el.classList.add('active'); document.body.style.overflow = 'hidden'; }
    }
    function closeReportModal(id) {
      const el = document.getElementById('reportOverlay-' + id);
      if(el) { el.classList.remove('active'); document.body.style.overflow = ''; }
    }
  </script>
  @endpush
</x-layout-user>
