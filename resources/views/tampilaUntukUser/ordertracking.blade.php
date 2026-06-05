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
    /* Report Modal */
    .report-overlay {
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
    }
    .report-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }
    .report-modal {
      transform: scale(0.9) translateY(20px);
      opacity: 0;
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .report-overlay.active .report-modal {
      transform: scale(1) translateY(0);
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
  <div class="p-6 md:p-10 max-w-5xl mx-auto w-full mb-24 md:mb-10">

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
    @forelse($orders as $order)
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

        // Delivery type
        $cartItems = $order->cart_items;
        $deliveryTypes = [];
        if (is_array($cartItems)) {
            foreach ($cartItems as $item) {
                $type = $item['type'] ?? 'pickup';
                if (!in_array($type, $deliveryTypes)) {
                    $deliveryTypes[] = $type;
                }
            }
        }

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

      <div class="order-card bg-surface-container-lowest rounded-2xl tectonic-shadow overflow-hidden mb-6 border border-outline-variant/20">

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
            {{-- Report Button --}}
            <button type="button" onclick="openReportModal({{ $order->ID_Pesanan }})" title="Laporkan Pesanan"
              class="w-9 h-9 rounded-xl bg-red-50 hover:bg-red-100 border border-red-200/50 flex items-center justify-center transition-all duration-200 group">
              <span class="material-symbols-outlined text-red-400 group-hover:text-red-600 text-[18px] transition-colors" style="font-variation-settings: 'FILL' 1">flag</span>
            </button>
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
                      @if($order->updated_at)
                        <p class="text-red-400 text-[10px] mt-2 font-semibold">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                      @endif
                    </div>
                  </div>
                </div>
              @else
                {{-- Active Stepper --}}
                <div class="space-y-0">

                  {{-- Step 1: Menunggu Konfirmasi Toko --}}
                  <div class="flex gap-4 min-h-[70px]">
                    <div class="flex flex-col items-center">
                      @if($currentStep >= 1)
                        <div class="w-7 h-7 rounded-full {{ $currentStep > 1 ? 'bg-primary' : 'bg-primary/20 border-2 border-primary' }} flex items-center justify-center">
                          @if($currentStep > 1)
                            <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                          @else
                            <div class="w-2.5 h-2.5 bg-primary rounded-full status-pulse"></div>
                          @endif
                        </div>
                      @else
                        <div class="w-7 h-7 rounded-full bg-surface-container-high border-2 border-outline-variant/40 flex items-center justify-center">
                          <div class="w-2 h-2 bg-outline-variant/40 rounded-full"></div>
                        </div>
                      @endif
                      <div class="w-0.5 flex-1 {{ $currentStep > 1 ? 'bg-primary' : 'bg-outline-variant/30' }} step-line"></div>
                    </div>
                    <div class="pb-5">
                      <h4 class="{{ $currentStep == 1 ? 'text-primary font-extrabold' : ($currentStep > 1 ? 'text-on-surface font-bold' : 'text-on-surface-variant font-medium') }} text-sm">
                        Menunggu Konfirmasi Toko
                      </h4>
                      <p class="text-on-surface-variant text-xs mt-0.5">
                        @if($currentStep == 1)
                          Pesanan Anda sedang menunggu konfirmasi dari toko
                        @elseif($currentStep > 1)
                          Pesanan telah diterima oleh toko
                        @else
                          —
                        @endif
                      </p>
                    </div>
                  </div>

                  {{-- Step 2: Sedang Diproses --}}
                  <div class="flex gap-4 min-h-[70px]">
                    <div class="flex flex-col items-center">
                      @if($currentStep >= 2)
                        <div class="w-7 h-7 rounded-full {{ $currentStep > 2 ? 'bg-primary' : 'bg-primary/20 border-2 border-primary' }} flex items-center justify-center">
                          @if($currentStep > 2)
                            <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                          @else
                            <div class="w-2.5 h-2.5 bg-primary rounded-full status-pulse"></div>
                          @endif
                        </div>
                      @else
                        <div class="w-7 h-7 rounded-full bg-surface-container-high border-2 border-outline-variant/40 flex items-center justify-center">
                          <div class="w-2 h-2 bg-outline-variant/40 rounded-full"></div>
                        </div>
                      @endif
                      <div class="w-0.5 flex-1 {{ $currentStep > 2 ? 'bg-primary' : 'bg-outline-variant/30' }} step-line"></div>
                    </div>
                    <div class="pb-5">
                      <h4 class="{{ $currentStep == 2 ? 'text-primary font-extrabold' : ($currentStep > 2 ? 'text-on-surface font-bold' : 'text-on-surface-variant font-medium') }} text-sm">
                        Sedang Diproses
                      </h4>
                      <p class="text-on-surface-variant text-xs mt-0.5">
                        @if($currentStep == 2)
                          Toko sedang menyiapkan pesanan Anda
                        @elseif($currentStep > 2)
                          Pesanan telah selesai diproses
                        @else
                          —
                        @endif
                      </p>
                    </div>
                  </div>

                  {{-- Step 3: Dalam Pengiriman --}}
                  <div class="flex gap-4 min-h-[70px]">
                    <div class="flex flex-col items-center">
                      @if($currentStep >= 3)
                        <div class="w-7 h-7 rounded-full {{ $currentStep > 3 ? 'bg-primary' : 'bg-primary/20 border-2 border-primary' }} flex items-center justify-center">
                          @if($currentStep > 3)
                            <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                          @else
                            <div class="w-2.5 h-2.5 bg-primary rounded-full status-pulse"></div>
                          @endif
                        </div>
                      @else
                        <div class="w-7 h-7 rounded-full bg-surface-container-high border-2 border-outline-variant/40 flex items-center justify-center">
                          <div class="w-2 h-2 bg-outline-variant/40 rounded-full"></div>
                        </div>
                      @endif
                      <div class="w-0.5 flex-1 {{ $currentStep > 3 ? 'bg-primary' : 'bg-outline-variant/30' }} step-line"></div>
                    </div>
                    <div class="pb-5">
                      <h4 class="{{ $currentStep == 3 ? 'text-primary font-extrabold' : ($currentStep > 3 ? 'text-on-surface font-bold' : 'text-on-surface-variant font-medium') }} text-sm">
                        Dalam Pengiriman
                      </h4>
                      <p class="text-on-surface-variant text-xs mt-0.5">
                        @if($currentStep == 3)
                          {{ $order->info_pengiriman ?? 'Pesanan sedang dikirim menuju lokasi Anda' }}
                        @elseif($currentStep > 3)
                          Pesanan telah sampai
                        @else
                          —
                        @endif
                      </p>
                    </div>
                  </div>

                  {{-- Step 4: Selesai --}}
                  <div class="flex gap-4">
                    <div class="flex flex-col items-center">
                      @if($currentStep >= 4)
                        <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center">
                          <span class="material-symbols-outlined text-[14px] text-white font-bold">check</span>
                        </div>
                      @else
                        <div class="w-7 h-7 rounded-full bg-surface-container-high border-2 border-outline-variant/40 flex items-center justify-center">
                          <div class="w-2 h-2 bg-outline-variant/40 rounded-full"></div>
                        </div>
                      @endif
                    </div>
                    <div class="flex-1">
                      <h4 class="{{ $currentStep >= 4 ? 'text-green-600 font-extrabold' : 'text-on-surface-variant font-medium' }} text-sm">
                        Pesanan Selesai
                      </h4>
                      <p class="text-on-surface-variant text-xs mt-0.5">
                        @if($currentStep >= 4)
                          Pesanan telah selesai. Terima kasih!
                        @elseif($currentStep == 3)
                          Konfirmasi bahwa pesanan sudah diterima
                        @else
                          —
                        @endif
                      </p>

                      {{-- Tombol Konfirmasi Pesanan Diterima (hanya saat status Dikirim) --}}
                      @if($currentStep == 3)
                        <div class="mt-4 bg-green-50 border border-green-200/50 rounded-xl p-4 space-y-3">
                          <div class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-green-600 text-lg shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1">package_2</span>
                            <div>
                              <p class="text-green-800 font-bold text-xs">Pesanan sudah sampai?</p>
                              <p class="text-green-700/70 text-[11px] mt-0.5 leading-relaxed">Tekan tombol di bawah untuk mengkonfirmasi bahwa pesanan telah Anda terima dengan baik.</p>
                            </div>
                          </div>
                          <form method="POST" action="{{ route('ordertracking.selesai', $order->ID_Pesanan) }}" onsubmit="return confirm('Apakah Anda yakin pesanan sudah diterima dengan baik?')">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-3 px-5 rounded-xl text-sm font-bold transition-all shadow-sm hover:shadow-md active:scale-[0.98]">
                              <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1">check_circle</span>
                              Konfirmasi Pesanan Diterima
                            </button>
                          </form>
                          @php
                            $autoCompleteDate = \Carbon\Carbon::parse($order->Tanggal_Pengiriman)->addDays(3);
                          @endphp
                          <p class="text-[10px] text-green-600/60 text-center font-medium leading-relaxed">
                            <span class="material-symbols-outlined text-[12px] align-middle">info</span>
                            Pesanan akan otomatis selesai pada <strong>{{ $autoCompleteDate->format('d M Y') }}</strong> jika tidak dikonfirmasi.
                          </p>
                        </div>
                      @endif
                    </div>
                  </div>

                </div>
              @endif
            </div>

            {{-- Order Details --}}
            <div class="lg:col-span-5 space-y-4">
              {{-- Product Info --}}
              <div class="bg-surface-container-low/50 rounded-xl p-4 space-y-3">
                <div>
                  <p class="text-on-surface-variant text-[10px] uppercase font-black tracking-widest mb-1">Produk</p>
                  <h4 class="text-on-surface font-bold text-base leading-snug">{{ $order->nama_produk }}</h4>
                </div>

                {{-- Price — hanya tampilkan tipe yang dipesan --}}
                @php
                  $orderedTypes = array_map('trim', explode(',', $order->tipe_pengiriman ?? ''));
                @endphp
                <div class="flex flex-wrap gap-2">
                  @if(in_array('pickup', $orderedTypes) && $order->Harga_PickUp)
                    <div class="bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 flex items-center gap-2">
                      <span class="material-symbols-outlined text-[14px] text-blue-600">directions_car</span>
                      <div>
                        <span class="text-[9px] font-bold text-blue-500 uppercase tracking-wide block">Pick Up</span>
                        <span class="text-blue-800 font-black text-sm">Rp {{ number_format($order->Harga_PickUp, 0, ',', '.') }}</span>
                      </div>
                    </div>
                  @endif
                  @if(in_array('truck', $orderedTypes) && $order->Harga_Truck)
                    <div class="bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 flex items-center gap-2">
                      <span class="material-symbols-outlined text-[14px] text-amber-600">local_shipping</span>
                      <div>
                        <span class="text-[9px] font-bold text-amber-500 uppercase tracking-wide block">Truk</span>
                        <span class="text-amber-800 font-black text-sm">Rp {{ number_format($order->Harga_Truck, 0, ',', '.') }}</span>
                      </div>
                    </div>
                  @endif
                </div>

                {{-- Total --}}
                <div class="pt-2 border-t border-outline-variant/20 flex items-center justify-between">
                  <span class="text-on-surface-variant text-xs font-semibold">Total Bayar</span>
                  <span class="text-primary font-black text-lg">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
              </div>

              {{-- Delivery Location --}}
              @if($order->Lokasi_Pengantaran)
                <div class="flex items-start gap-3 bg-surface-container-low/50 rounded-xl p-4">
                  <span class="material-symbols-outlined text-secondary shrink-0" style="font-variation-settings: 'FILL' 1">location_on</span>
                  <div>
                    <p class="text-on-surface-variant text-[10px] uppercase font-black tracking-widest mb-0.5">Lokasi Pengantaran</p>
                    <p class="text-on-surface text-xs leading-relaxed font-medium">{{ $order->Lokasi_Pengantaran }}</p>
                  </div>
                </div>
              @endif

              {{-- Payment Status --}}
              <div class="flex items-center gap-3 bg-surface-container-low/50 rounded-xl p-4">
                <span class="material-symbols-outlined text-on-surface-variant shrink-0">payments</span>
                <div class="flex-1">
                  <p class="text-on-surface-variant text-[10px] uppercase font-black tracking-widest mb-0.5">Pembayaran</p>
                  @php
                    $payStatus = $order->Status_Pembayaran;
                    if ($payStatus === 'Lunas' || $payStatus === 'paid') {
                        $payLabel = 'Lunas';
                        $payBadge = 'bg-green-100 text-green-700 border-green-200';
                    } elseif ($payStatus === 'Dibatalkan') {
                        $payLabel = 'Dibatalkan';
                        $payBadge = 'bg-red-100 text-red-600 border-red-200';
                    } else {
                        $payLabel = 'Menunggu';
                        $payBadge = 'bg-amber-100 text-amber-700 border-amber-200';
                    }
                  @endphp
                  <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider border {{ $payBadge }}">{{ $payLabel }}</span>
                </div>
                @if($order->Bukti_Pembayaran)
                  <a href="{{ route('bukti.image', basename($order->Bukti_Pembayaran)) }}" target="_blank" class="flex items-center gap-1 text-[11px] font-bold text-primary hover:underline transition-all shrink-0">
                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">receipt</span>Bukti
                  </a>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>

      {{-- Report Modal for this order --}}
      <div id="reportOverlay-{{ $order->ID_Pesanan }}" class="report-overlay fixed inset-0 z-[99999] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeReportModal({{ $order->ID_Pesanan }})"></div>
        <div class="report-modal bg-surface-container-lowest rounded-2xl shadow-2xl w-full max-w-md relative overflow-hidden border border-outline-variant/20">
          {{-- Modal Header --}}
          <div class="px-6 py-5 bg-red-50 border-b border-red-200/30">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-red-500 text-xl" style="font-variation-settings: 'FILL' 1">flag</span>
              </div>
              <div class="flex-1">
                <h3 class="text-red-800 font-bold text-base">Laporkan Pesanan</h3>
                <p class="text-red-600/70 text-xs font-medium">#ORD-{{ str_pad($order->ID_Pesanan, 4, '0', STR_PAD_LEFT) }} · {{ $order->nama_produk }}</p>
              </div>
              <button type="button" onclick="closeReportModal({{ $order->ID_Pesanan }})" class="w-8 h-8 rounded-lg hover:bg-red-100 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-red-400 text-lg">close</span>
              </button>
            </div>
          </div>

          {{-- Modal Body --}}
          <form method="POST" action="{{ route('ordertracking.report', $order->ID_Pesanan) }}">
            @csrf
            <div class="p-6 space-y-4">
              <div>
                <label class="block text-on-surface text-sm font-bold mb-2">Alasan Laporan <span class="text-red-500">*</span></label>
                <textarea name="alasan_report" rows="4" required maxlength="1000"
                  class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/50 focus:ring-2 focus:ring-red-300 focus:border-red-300 transition-all resize-none"
                  placeholder="Jelaskan masalah yang Anda alami dengan pesanan ini..."></textarea>
                <p class="text-on-surface-variant text-[10px] mt-1.5 font-medium">Laporan akan dikirim ke Customer Support dan Toko.</p>
              </div>

              <div class="bg-amber-50 border border-amber-200/50 rounded-xl p-3 flex items-start gap-2.5">
                <span class="material-symbols-outlined text-amber-500 text-lg shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1">info</span>
                <p class="text-amber-700 text-[11px] leading-relaxed font-medium">
                  Pastikan Anda memberikan detail yang jelas agar tim kami dapat membantu menyelesaikan masalah Anda dengan cepat.
                </p>
              </div>
            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-surface-container-low/50 border-t border-outline-variant/20 flex items-center justify-end gap-3">
              <button type="button" onclick="closeReportModal({{ $order->ID_Pesanan }})"
                class="px-5 py-2.5 rounded-xl text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-all">
                Batal
              </button>
              <button type="submit"
                class="px-5 py-2.5 rounded-xl text-sm font-bold bg-red-600 hover:bg-red-700 text-white transition-all shadow-sm hover:shadow-md flex items-center gap-2 active:scale-[0.97]">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1">send</span>
                Kirim Laporan
              </button>
            </div>
          </form>
        </div>
      </div>

    @empty
      {{-- Empty State --}}
      <div class="bg-surface-container-lowest rounded-2xl tectonic-shadow p-12 text-center">
        <div class="empty-state-icon inline-flex items-center justify-center w-20 h-20 bg-primary/10 rounded-full mb-5">
          <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings: 'FILL' 1">shopping_bag</span>
        </div>
        <h3 class="text-on-surface font-bold text-lg mb-2">Belum Ada Pesanan</h3>
        <p class="text-on-surface-variant text-sm max-w-md mx-auto mb-6">
          Anda belum memiliki pesanan. Mulai belanja dan temukan berbagai jenis pasir berkualitas dari toko terdekat.
        </p>
        <a href="{{ route('MenuUtama') }}" class="inline-flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-md">
          <span class="material-symbols-outlined text-lg">storefront</span>
          Mulai Belanja
        </a>
      </div>
    @endforelse

  </div>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Pindahkan semua modal ke dalam <body> agar posisi 'fixed' tidak terganggu oleh 'transform' dari parent
      document.querySelectorAll('.report-overlay').forEach(function(modal) {
        document.body.appendChild(modal);
      });
    });

    function openReportModal(orderId) {
      const overlay = document.getElementById('reportOverlay-' + orderId);
      if (overlay) {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    }

    function closeReportModal(orderId) {
      const overlay = document.getElementById('reportOverlay-' + orderId);
      if (overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.querySelectorAll('.report-overlay.active').forEach(el => {
          el.classList.remove('active');
        });
        document.body.style.overflow = '';
      }
    });
  </script>
  @endpush

</x-layout-user>
