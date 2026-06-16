<x-layout-user title="Riwayat Pesanan | Pasir Ku" :fullHeight="false">
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
    .empty-state-icon {
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    .fade-in {
      animation: fadeInCard 0.4s ease forwards;
      opacity: 0;
    }
    @keyframes fadeInCard {
      from { opacity: 0; transform: translateY(12px); }
      to { opacity: 1; transform: translateY(0); }
    }
    /* Filter chip active */
    .filter-chip-active {
      background: #944a00;
      color: #fff;
      border-color: #944a00;
    }
    /* Pagination styling */
    .pagination-wrapper nav > div:first-child { display: none; }
    .pagination-wrapper .relative.inline-flex { gap: 4px; }
    .pagination-wrapper span[aria-current="page"] span,
    .pagination-wrapper a {
      border-radius: 0.75rem !important;
      font-weight: 700 !important;
      font-size: 0.8rem !important;
      min-width: 2.25rem;
      height: 2.25rem;
      display: inline-flex !important;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }
    .pagination-wrapper span[aria-current="page"] span {
      background: #944a00 !important;
      color: #fff !important;
      border-color: #944a00 !important;
    }
    .pagination-wrapper a:hover {
      background: rgba(148, 74, 0, 0.08) !important;
      color: #944a00 !important;
    }
  </style>
  @endpush

  <!-- Content Shell -->
  <div class="p-6 md:p-10 max-w-5xl mx-auto w-full mb-24 md:mb-10">

    <!-- Page Header -->
    <div class="mb-6">
      <div class="flex items-center gap-3 mb-2">
        <div class="w-12 h-12 bg-green-600/10 rounded-2xl flex items-center justify-center">
          <span class="material-symbols-outlined text-green-600 text-2xl" style="font-variation-settings: 'FILL' 1">history</span>
        </div>
        <div>
          <h1 class="text-on-surface text-2xl md:text-3xl font-extrabold tracking-tight">Riwayat Pesanan</h1>
          <p class="text-on-surface-variant text-sm font-medium">Daftar pesanan yang telah selesai atau dibatalkan</p>
        </div>
      </div>
    </div>

    {{-- ===== FILTER & SEARCH TOOLBAR ===== --}}
    <div class="bg-surface-container-lowest rounded-2xl tectonic-shadow p-4 mb-6 border border-outline-variant/20">
      <form method="GET" action="{{ route('riwayat') }}" id="filterForm">
        <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">

          {{-- Search --}}
          <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}"
              class="w-full bg-surface-container border-none rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-on-surface-variant/60"
              placeholder="Cari ID pesanan, produk, atau toko..." />
          </div>

          {{-- Status Filter --}}
          <div class="flex items-center gap-2 flex-shrink-0">
            @php
              $currentStatus = request('status', 'Semua');
              $statuses = ['Semua', 'Selesai', 'Dibatalkan'];
            @endphp
            @foreach($statuses as $s)
              <button type="submit" name="status" value="{{ $s }}"
                class="px-3.5 py-2 rounded-xl text-xs font-bold border transition-all duration-200
                  {{ $currentStatus === $s
                    ? 'filter-chip-active'
                    : 'bg-surface-container-low border-outline-variant/30 text-on-surface-variant hover:bg-surface-container-high hover:border-outline-variant/50' }}">
                @if($s === 'Selesai')
                  <span class="material-symbols-outlined text-[13px] align-middle mr-0.5" style="font-variation-settings: 'FILL' 1">task_alt</span>
                @elseif($s === 'Dibatalkan')
                  <span class="material-symbols-outlined text-[13px] align-middle mr-0.5" style="font-variation-settings: 'FILL' 1">cancel</span>
                @endif
                {{ $s }}
              </button>
            @endforeach
          </div>

          {{-- Sort --}}
          <div class="flex-shrink-0">
            <select name="sort" onchange="document.getElementById('filterForm').submit()"
              class="bg-surface-container border-none rounded-xl pl-3 pr-10 py-2.5 text-sm font-semibold text-on-surface-variant focus:ring-2 focus:ring-primary/20 transition-all cursor-pointer">
              <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
              <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
          </div>

        </div>

        {{-- Preserve sort when clicking status filter --}}
        <input type="hidden" id="hiddenSort" value="{{ request('sort', 'terbaru') }}" />
      </form>

      {{-- Results summary --}}
      @if($orders->total() > 0)
        <div class="mt-3 pt-3 border-t border-outline-variant/20 flex items-center justify-between">
          <p class="text-on-surface-variant text-xs font-semibold">
            Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
          </p>
          @if(request('search') || (request('status') && request('status') !== 'Semua'))
            <a href="{{ route('riwayat') }}" class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
              <span class="material-symbols-outlined text-[14px]">close</span> Reset filter
            </a>
          @endif
        </div>
      @endif
    </div>

    {{-- ===== ORDERS LIST ===== --}}
    @forelse($orders as $index => $order)
      @php
        $status = $order->Status_Pesanan;
        $isCompleted = $status === \App\Models\Pesanan::STATUS_SELESAI;
        $isCancelled = $status === \App\Models\Pesanan::STATUS_DIBATALKAN;

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
        $statusColors = $isCompleted
            ? 'bg-green-100 text-green-700 border-green-200'
            : 'bg-red-100 text-red-600 border-red-200';

        $statusIcon = $isCompleted ? 'task_alt' : 'cancel';
        $statusLabel = $isCompleted ? 'Selesai' : 'Dibatalkan';
        $accentColor = $isCompleted ? 'green' : 'red';
      @endphp

      <div class="order-card bg-surface-container-lowest rounded-2xl tectonic-shadow overflow-hidden mb-6 border border-outline-variant/20 fade-in" style="animation-delay: {{ $index * 0.06 }}s">

        <!-- Order Header -->
        <div class="px-6 py-4 bg-surface-container-low/50 border-b border-outline-variant/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-{{ $accentColor }}-100 flex items-center justify-center">
              <span class="material-symbols-outlined text-{{ $accentColor }}-{{ $isCompleted ? '600' : '500' }}" style="font-variation-settings: 'FILL' 1">
                {{ $statusIcon }}
              </span>
            </div>
            <div>
              <h3 class="text-on-surface font-bold text-base tracking-tight">#ORD-{{ str_pad($order->ID_Pesanan, 4, '0', STR_PAD_LEFT) }}</h3>
              <p class="text-on-surface-variant text-xs font-medium">{{ $order->created_at->format('d M Y, H:i') }} · {{ $order->Nama_Toko ?? 'Toko' }}</p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] uppercase font-black tracking-wider border {{ $statusColors }}">
              <span class="material-symbols-outlined text-[13px]" style="font-variation-settings: 'FILL' 1">{{ $statusIcon }}</span>
              {{ $statusLabel }}
            </span>
            @if($isCompleted)
              <span class="text-on-surface-variant text-[10px] font-semibold">{{ $order->updated_at->diffForHumans() }}</span>
            @endif
          </div>
        </div>

        <div class="p-6">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Status Info --}}
            <div class="lg:col-span-7">
              @if($isCompleted)
                {{-- Completed State --}}
                <div class="bg-green-50 border border-green-200/50 rounded-xl p-5">
                  <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                      <span class="material-symbols-outlined text-green-600" style="font-variation-settings: 'FILL' 1">verified</span>
                    </div>
                    <div>
                      <h4 class="text-green-700 font-bold text-sm">Pesanan Telah Selesai</h4>
                      <p class="text-green-600/80 text-xs mt-1 leading-relaxed">
                        Pesanan berhasil diselesaikan. Terima kasih telah berbelanja!
                      </p>
                      @if($order->updated_at)
                        <p class="text-green-400 text-[10px] mt-2 font-semibold">Selesai pada {{ $order->updated_at->format('d M Y, H:i') }}</p>
                      @endif

                      {{-- Review Section --}}
                      <div class="mt-4 pt-4 border-t border-green-200/50">
                        @if($order->review)
                          <div class="flex flex-wrap items-center gap-2">
                             <div class="flex text-amber-500">
                               @for($i=1; $i<=5; $i++)
                                 <span class="material-symbols-outlined text-[16px] {{ $i <= $order->review->Rating ? '' : 'opacity-30' }}" style="font-variation-settings: 'FILL' 1">star</span>
                               @endfor
                             </div>
                             <span class="text-[10px] font-bold text-green-700">Sudah Dinilai</span>
                             <button onclick="openReviewModal({{ $order->ID_Pesanan }}, {{ json_encode($order->review) }})" class="text-[10px] font-bold text-primary hover:underline ml-auto">Edit Ulasan</button>
                          </div>
                        @else
                          <button onclick="openReviewModal({{ $order->ID_Pesanan }})" class="inline-flex items-center gap-1.5 bg-green-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-green-700 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-sm">rate_review</span>
                            Beri Rating
                          </button>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @else
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
                          Pesanan ini telah dibatalkan. Silakan hubungi toko untuk informasi lebih lanjut.
                        @endif
                      </p>
                      @if($order->updated_at)
                        <p class="text-red-400 text-[10px] mt-2 font-semibold">{{ $order->updated_at->format('d M Y, H:i') }}</p>
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

                {{-- Price --}}
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
    @empty
      {{-- Empty State --}}
      <div class="bg-surface-container-lowest rounded-2xl tectonic-shadow p-12 text-center">
        <div class="empty-state-icon inline-flex items-center justify-center w-20 h-20 bg-green-600/10 rounded-full mb-5">
          <span class="material-symbols-outlined text-green-600 text-4xl" style="font-variation-settings: 'FILL' 1">
            {{ request('search') || (request('status') && request('status') !== 'Semua') ? 'search_off' : 'history' }}
          </span>
        </div>
        @if(request('search') || (request('status') && request('status') !== 'Semua'))
          <h3 class="text-on-surface font-bold text-lg mb-2">Tidak Ditemukan</h3>
          <p class="text-on-surface-variant text-sm max-w-md mx-auto mb-6">
            Tidak ada riwayat pesanan yang cocok dengan filter atau pencarian Anda.
          </p>
          <a href="{{ route('riwayat') }}" class="inline-flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-md">
            <span class="material-symbols-outlined text-lg">restart_alt</span>
            Reset Filter
          </a>
        @else
          <h3 class="text-on-surface font-bold text-lg mb-2">Belum Ada Riwayat</h3>
          <p class="text-on-surface-variant text-sm max-w-md mx-auto mb-6">
            Anda belum memiliki pesanan yang selesai. Pesanan yang telah selesai atau dibatalkan akan tampil di sini.
          </p>
          <a href="{{ route('MenuUtama') }}" class="inline-flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-xl font-bold text-sm hover:opacity-90 transition-all shadow-md">
            <span class="material-symbols-outlined text-lg">storefront</span>
            Mulai Belanja
          </a>
        @endif
      </div>
    @endforelse

    {{-- ===== PAGINATION ===== --}}
    @if($orders->hasPages())
      <div class="pagination-wrapper mt-8 flex justify-center">
        {{ $orders->links() }}
      </div>
    @endif

  </div>

  @push('modals')
    {{-- ===== REVIEW MODAL ===== --}}
    <div id="reviewModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
      <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeReviewModal()"></div>
      <div class="flex min-h-full items-start justify-center p-4 sm:items-center">
        <div class="relative w-full max-w-lg bg-surface-container-lowest rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 my-auto">
          
          {{-- Header --}}
          <div class="px-6 py-5 border-b border-outline-variant/20 flex items-center justify-between">
            <h3 class="text-xl font-black text-on-surface" id="modalTitle">Beri Rating & Ulasan</h3>
            <button onclick="closeReviewModal()" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-high transition-colors">
              <span class="material-symbols-outlined text-on-surface-variant">close</span>
            </button>
          </div>

          {{-- Form --}}
          <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="ID_Pesanan" id="modalOrderID">

            {{-- Star Rating --}}
            <div class="text-center">
              <p class="text-sm font-bold text-on-surface-variant mb-4">Bagaimana kualitas produk dan layanan kami?</p>
              <div class="flex justify-center gap-2">
                @for($i=1; $i<=5; $i++)
                  <button type="button" onclick="setRating({{ $i }})" class="star-btn transition-transform hover:scale-125" data-value="{{ $i }}">
                    <span class="material-symbols-outlined text-4xl star-icon text-outline-variant" style="font-variation-settings: 'FILL' 0">star</span>
                  </button>
                @endfor
              </div>
              <input type="hidden" name="Rating" id="ratingInput" required>
              <p id="ratingLabel" class="text-xs font-black text-primary mt-3 h-4 uppercase tracking-wider"></p>
            </div>

            {{-- Text Review --}}
            <div>
              <label class="block text-sm font-bold text-on-surface mb-2">Ulasan Anda (Opsional)</label>
              <textarea name="Ulasan" id="reviewText" rows="4" 
                class="w-full bg-surface-container border-none rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-on-surface-variant/50"
                placeholder="Bagikan pengalaman Anda berbelanja di sini..."></textarea>
            </div>

            {{-- Photo Upload --}}
            <div>
              <label class="block text-sm font-bold text-on-surface mb-2">Tambah Foto (Opsional)</label>
              <div class="flex items-center gap-4">
                <label class="flex flex-col items-center justify-center w-24 h-24 border-2 border-dashed border-outline-variant/50 rounded-2xl cursor-pointer hover:bg-surface-container-high hover:border-primary/50 transition-all">
                  <span class="material-symbols-outlined text-on-surface-variant mb-1">add_a_photo</span>
                  <span class="text-[10px] font-bold text-on-surface-variant">Upload</span>
                  <input type="file" name="Foto_Review" class="hidden" accept="image/*" onchange="previewImage(this)">
                </label>
                <div id="imagePreview" class="hidden relative w-24 h-24">
                   <img src="" class="w-full h-full object-cover rounded-2xl border border-outline-variant/30">
                   <button type="button" onclick="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
                     <span class="material-symbols-outlined text-xs">close</span>
                   </button>
                </div>
              </div>
            </div>

            {{-- Anonymous Checkbox --}}
            <label class="flex items-center gap-3 cursor-pointer group">
              <input type="checkbox" name="is_anonymous" id="anonymousCheck" value="1" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary/20">
              <span class="text-sm font-bold text-on-surface-variant group-hover:text-on-surface transition-colors">Kirim sebagai Anonim</span>
            </label>

            {{-- Submit --}}
            <div class="pt-4">
              <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-2xl font-black tracking-wide hover:opacity-90 transition-all shadow-xl flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-lg">send</span>
                KIRIM ULASAN
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endpush

  @push('scripts')
  <script>
    const modal = document.getElementById('reviewModal');
    const form = document.getElementById('reviewForm');
    const stars = document.querySelectorAll('.star-icon');
    const ratingInput = document.getElementById('ratingInput');
    const ratingLabel = document.getElementById('ratingLabel');
    const mainContainer = document.querySelector('main');
    const labels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];

    function openReviewModal(orderId, review = null) {
        document.getElementById('modalOrderID').value = orderId;
        
        if (review) {
            document.getElementById('modalTitle').innerText = 'Edit Ulasan';
            document.getElementById('formMethod').value = 'PUT';
            form.action = `/reviews/${review.ID_Review}`;
            
            // Fill data
            setRating(review.Rating);
            document.getElementById('reviewText').value = review.Ulasan || '';
            document.getElementById('anonymousCheck').checked = !!review.is_anonymous;
        } else {
            document.getElementById('modalTitle').innerText = 'Beri Rating & Ulasan';
            document.getElementById('formMethod').value = 'POST';
            form.action = "{{ route('reviews.store') }}";
            resetForm();
        }

        modal.classList.remove('hidden');
        // Lock both body and main container if it's the scrolling element
        document.body.style.overflow = 'hidden';
        if (mainContainer) mainContainer.style.overflow = 'hidden';
    }

    function closeReviewModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        if (mainContainer) mainContainer.style.overflow = '';
    }

    function setRating(val) {
        ratingInput.value = val;
        ratingLabel.innerText = labels[val];
        
        stars.forEach((star, index) => {
            if (index < val) {
                star.style.fontVariationSettings = "'FILL' 1";
                star.classList.replace('text-outline-variant', 'text-amber-500');
            } else {
                star.style.fontVariationSettings = "'FILL' 0";
                star.classList.replace('text-amber-500', 'text-outline-variant');
            }
        });
    }

    function resetForm() {
        form.reset();
        ratingInput.value = '';
        ratingLabel.innerText = '';
        stars.forEach(star => {
            star.style.fontVariationSettings = "'FILL' 0";
            star.classList.replace('text-amber-500', 'text-outline-variant');
        });
        removeImage();
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const preview = document.getElementById('imagePreview');
        preview.classList.add('hidden');
        preview.querySelector('img').src = '';
        document.querySelector('input[type="file"]').value = '';
    }

    // When clicking status filter buttons, preserve sort & search values
    document.querySelectorAll('#filterForm button[name="status"]').forEach(btn => {
      btn.addEventListener('click', function() {
        const form = document.getElementById('filterForm');
        const sortSelect = form.querySelector('select[name="sort"]');
        // Sort value is already in the select, no extra action needed
      });
    });
  </script>
  @endpush

</x-layout-user>
