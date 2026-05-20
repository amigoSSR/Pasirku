<x-layout-store title="Monitoring Pelanggan">

  <x-slot name="header">
    <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
      <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary">Dashboard</a>
      <span class="material-symbols-outlined text-sm">chevron_right</span>
      <span class="text-primary font-semibold">Monitoring Pelanggan</span>
    </nav>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
      <div>
        <h1 class="font-headline text-3xl font-bold text-on-surface">Monitoring Pelanggan</h1>
        <p class="text-on-surface-variant text-sm mt-1">Pantau aktivitas, transaksi, dan keterlibatan pelanggan toko Anda.</p>
      </div>
      <div class="flex gap-3 shrink-0">
        <button class="flex items-center gap-2 px-4 py-2 border border-outline-variant rounded-xl text-sm font-medium text-on-surface-variant hover:bg-surface-container-low transition-all">
          <span class="material-symbols-outlined text-lg">filter_list</span>Filter
        </button>
        <button class="flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-xl text-sm font-semibold hover:opacity-90 transition-all shadow-sm">
          <span class="material-symbols-outlined text-lg">download</span>Ekspor
        </button>
      </div>
    </div>
  </x-slot>

  <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
      @php
      $stats = [
        ['icon'=>'group','bg'=>'bg-primary/10','text'=>'text-primary','label'=>'Total Pelanggan','value'=>number_format($totalPelanggan, 0, ',', '.'),'badge'=>'Semua','up'=>true],
        ['icon'=>'person_check','bg'=>'bg-tertiary/10','text'=>'text-tertiary','label'=>'Pelanggan Aktif','value'=>number_format($pelangganAktif, 0, ',', '.'),'badge'=>'30 hr','up'=>true],
        ['icon'=>'receipt_long','bg'=>'bg-secondary/10','text'=>'text-secondary','label'=>'Total Transaksi','value'=>number_format($totalTransaksi, 0, ',', '.'),'badge'=>'Selesai','up'=>true],
        ['icon'=>'person_add','bg'=>'bg-amber-500/10','text'=>'text-amber-600','label'=>'Pelanggan Baru','value'=>number_format($pelangganBaru, 0, ',', '.'),'badge'=>'Bulan ini','up'=>true],
      ];
      @endphp
      @foreach($stats as $s)
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 {{ $s['bg'] }} rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined {{ $s['text'] }}" style="font-variation-settings:'FILL' 1">{{ $s['icon'] }}</span>
          </div>
          <span class="text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5 bg-green-50 text-green-600">
            <span class="material-symbols-outlined text-xs">trending_up</span>{{ $s['badge'] }}
          </span>
        </div>
        <p class="text-2xl font-headline font-bold text-on-surface">{{ $s['value'] }}</p>
        <p class="text-xs text-on-surface-variant mt-1 font-medium">{{ $s['label'] }}</p>
      </div>
      @endforeach
    </div>

    {{-- Main Grid: Table + Right Panel --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Customer Table --}}
      <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
        <div class="p-5 border-b border-outline-variant/20 flex flex-col sm:flex-row gap-3 sm:items-center justify-between">
          <h2 class="font-headline font-bold text-lg text-on-surface">Data Pelanggan</h2>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
            <input id="searchInput" type="text" placeholder="Cari pelanggan..."
              class="pl-9 pr-4 py-2 text-sm border border-outline-variant rounded-xl bg-surface-container-low focus:ring-2 focus:ring-primary/20 focus:outline-none w-full sm:w-56 transition-all"/>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
                <th class="px-5 py-3 text-left font-semibold">Pelanggan</th>
                <th class="px-5 py-3 text-left font-semibold">Total Beli</th>
                <th class="px-5 py-3 text-left font-semibold">Transaksi</th>
                <th class="px-5 py-3 text-left font-semibold">Status</th>
                <th class="px-5 py-3 text-left font-semibold">Terakhir Belanja</th>
                <th class="px-5 py-3 text-right font-semibold">Aksi</th>
              </tr>
            </thead>
            <tbody id="customerTable" class="divide-y divide-outline-variant/20">
              @php
              $colors = [
                'bg-orange-100 text-orange-700',
                'bg-amber-100 text-amber-700',
                'bg-blue-100 text-blue-700',
                'bg-green-100 text-green-700',
                'bg-purple-100 text-purple-700',
                'bg-rose-100 text-rose-700',
                'bg-indigo-100 text-indigo-700',
              ];
              @endphp
              @forelse($customersData as $customer)
                @php
                  // Initials logic
                  $name = $customer->name ?? 'Pelanggan';
                  $words = explode(' ', $name);
                  $initials = '';
                  foreach ($words as $w) {
                      $initials .= strtoupper(substr($w, 0, 1));
                  }
                  $initials = substr($initials, 0, 2);
                  if (empty($initials)) {
                      $initials = 'P';
                  }
                  $color = $colors[$customer->ID_Akun % count($colors)];
                  
                  // Active status determination (has order in last 30 days)
                  $lastTx = $customer->last_transaction ? \Carbon\Carbon::parse($customer->last_transaction) : null;
                  $isActive = $lastTx && $lastTx->gt(now()->subDays(30));
                @endphp
                <tr class="hover:bg-surface-container-low/60 transition-colors cursor-pointer">
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-full {{ $color }} flex items-center justify-center font-bold text-sm shrink-0">{{ $initials }}</div>
                      <div>
                        <p class="font-semibold text-on-surface">{{ $customer->name }}</p>
                        <p class="text-xs text-on-surface-variant">{{ $customer->email }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-5 py-4 font-semibold text-primary">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                  <td class="px-5 py-4 text-on-surface-variant">{{ $customer->total_trx }}x</td>
                  <td class="px-5 py-4">
                    @if($isActive)
                      <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif
                      </span>
                    @else
                      <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container text-on-surface-variant">
                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>Nonaktif
                      </span>
                    @endif
                  </td>
                  <td class="px-5 py-4 text-xs text-on-surface-variant">
                    {{ $lastTx ? $lastTx->diffForHumans() : '-' }}
                  </td>
                  <td class="px-5 py-4 text-right">
                    <button 
                      onclick="openCustomerDetail(this)"
                      data-customer="{{ json_encode([
                        'name' => $customer->name,
                        'username' => $customer->username,
                        'email' => $customer->email,
                        'phone' => $customer->phone ?? '-',
                        'total_spent' => 'Rp ' . number_format($customer->total_spent, 0, ',', '.'),
                        'total_trx' => $customer->total_trx . 'x',
                        'initials' => $initials,
                        'color' => $color
                      ]) }}"
                      data-history="{{ json_encode($history[$customer->ID_Akun] ?? []) }}"
                      class="text-primary hover:bg-primary/10 p-1.5 rounded-lg transition-colors" title="Lihat Detail">
                      <span class="material-symbols-outlined text-lg">open_in_new</span>
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="px-5 py-8 text-center text-on-surface-variant text-sm">
                    Belum ada data pelanggan yang melakukan transaksi.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="px-5 py-4 border-t border-outline-variant/20 flex items-center justify-between text-sm">
          <span class="text-on-surface-variant font-medium">
            Menampilkan {{ $customersData->firstItem() ?? 0 }}–{{ $customersData->lastItem() ?? 0 }} dari {{ $customersData->total() }} pelanggan
          </span>
          <div class="flex gap-1">
            {{ $customersData->links() }}
          </div>
        </div>
      </div>

      {{-- Right Panel --}}
      <div class="space-y-6">
        {{-- Activity Timeline --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
          <div class="p-5 border-b border-outline-variant/20 flex items-center justify-between">
            <h2 class="font-headline font-bold text-lg text-on-surface">Aktivitas Terkini</h2>
            <span class="text-xs font-semibold text-primary bg-primary/10 px-2 py-0.5 rounded-md">Live</span>
          </div>
          <div class="p-5 space-y-4">
            @forelse($activities as $act)
            <div class="flex gap-3">
              <div class="w-9 h-9 {{ $act['color'] }} rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">{{ $act['icon'] }}</span>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-on-surface leading-tight">{{ $act['title'] }}</p>
                <p class="text-xs text-on-surface-variant mt-0.5 truncate">{{ $act['desc'] }}</p>
                <p class="text-xs text-outline mt-1">{{ $act['time'] }}</p>
              </div>
            </div>
            @empty
            <p class="text-xs text-on-surface-variant text-center py-4">Belum ada aktivitas pesanan.</p>
            @endforelse
          </div>
        </div>

        {{-- Loyal Customers --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5">
          <h2 class="font-headline font-bold text-lg text-on-surface mb-4">Pelanggan Loyal</h2>
          <div class="space-y-4">
            @forelse($loyalCustomers as $l)
            @php
              $percentage = $maxTrx > 0 ? ($l->trx / $maxTrx) * 100 : 0;
              $colors = ['bg-primary', 'bg-tertiary', 'bg-secondary'];
              $color = $colors[$loop->index % count($colors)];
            @endphp
            <div>
              <div class="flex justify-between items-center mb-1.5">
                <span class="text-sm font-medium text-on-surface">{{ $l->name ?? 'Pelanggan' }}</span>
                <span class="text-xs text-on-surface-variant">{{ $l->trx }} transaksi selesai</span>
              </div>
              <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
                <div class="{{ $color }} h-full rounded-full" style="width: {{ $percentage }}%"></div>
              </div>
            </div>
            @empty
            <p class="text-xs text-on-surface-variant text-center py-4">Belum ada pelanggan selesai membeli.</p>
            @endforelse
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- Detail Pelanggan Modal --}}
  <div id="detailModal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4 transition-all duration-300 opacity-0 backdrop-blur-lg">
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-2xl w-full max-w-2xl shadow-2xl overflow-hidden transform scale-95 transition-all duration-300 flex flex-col max-h-[85vh]">
      <!-- Header -->
      <div class="px-6 py-4 border-b border-outline-variant/20 flex items-center justify-between flex-shrink-0">
        <h3 class="font-headline font-bold text-lg text-on-surface flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">person</span>Detail Pelanggan
        </h3>
        <button onclick="closeCustomerDetailModal()" class="text-on-surface-variant hover:bg-surface-container-low p-1.5 rounded-lg transition-colors">
          <span class="material-symbols-outlined text-xl">close</span>
        </button>
      </div>
      
      <!-- Content -->
      <div class="p-6 overflow-y-auto space-y-6 flex-grow">
        <!-- Profile Summary -->
        <div class="flex items-center gap-4 p-4 bg-surface-container-low rounded-2xl">
          <div id="modalAvatar" class="w-14 h-14 rounded-full flex items-center justify-center font-bold text-lg text-white shrink-0"></div>
          <div>
            <h4 id="modalName" class="font-headline font-bold text-lg text-on-surface"></h4>
            <p id="modalEmail" class="text-sm text-on-surface-variant"></p>
            <p id="modalPhone" class="text-xs text-outline mt-0.5"></p>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 gap-4">
          <div class="p-4 border border-outline-variant/20 rounded-xl bg-surface-container-lowest">
            <p class="text-xs text-on-surface-variant font-medium">Transaksi Selesai</p>
            <p id="modalTotalTrx" class="text-xl font-bold text-on-surface mt-1"></p>
          </div>
          <div class="p-4 border border-outline-variant/20 rounded-xl bg-surface-container-lowest">
            <p class="text-xs text-on-surface-variant font-medium">Total Belanja</p>
            <p id="modalTotalSpent" class="text-xl font-bold text-primary mt-1"></p>
          </div>
        </div>

        <!-- Purchase History -->
        <div>
          <h5 class="font-headline font-semibold text-sm text-on-surface mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">receipt_long</span>Riwayat Belanja Pelanggan
          </h5>
          <div class="overflow-x-auto border border-outline-variant/20 rounded-xl bg-surface-container-lowest">
            <table class="w-full text-sm">
              <thead>
                <tr class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
                  <th class="px-4 py-2.5 text-left font-semibold">Tanggal</th>
                  <th class="px-4 py-2.5 text-left font-semibold">Produk</th>
                  <th class="px-4 py-2.5 text-left font-semibold">Tipe</th>
                  <th class="px-4 py-2.5 text-right font-semibold">Harga</th>
                  <th class="px-4 py-2.5 text-center font-semibold">Status</th>
                </tr>
              </thead>
              <tbody id="modalHistoryTable" class="divide-y divide-outline-variant/20 text-on-surface">
                <!-- Dynamically populated -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    document.getElementById('searchInput').addEventListener('input', function() {
      const q = this.value.toLowerCase();
      document.querySelectorAll('#customerTable tr').forEach(row => {
        // Handle search for empty states too
        if (row.querySelector('td[colspan]')) return;
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });

    function openCustomerDetail(button) {
      const customer = JSON.parse(button.getAttribute('data-customer'));
      const history = JSON.parse(button.getAttribute('data-history'));

      // Populate profile info
      const avatar = document.getElementById('modalAvatar');
      avatar.textContent = customer.initials;
      avatar.className = `w-14 h-14 rounded-full flex items-center justify-center font-bold text-lg shrink-0 ${customer.color}`;
      
      document.getElementById('modalName').textContent = customer.name;
      document.getElementById('modalEmail').textContent = customer.email;
      document.getElementById('modalPhone').textContent = `No. Telp: ${customer.phone}`;
      document.getElementById('modalTotalTrx').textContent = customer.total_trx;
      document.getElementById('modalTotalSpent').textContent = customer.total_spent;

      // Populate history table
      const tbody = document.getElementById('modalHistoryTable');
      tbody.innerHTML = '';

      if (!history || history.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-xs text-on-surface-variant">Tidak ada riwayat pembelian.</td></tr>';
      } else {
        history.forEach(order => {
          const date = new Date(order.created_at).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
          });
          const product = `${order.nama_produk ?? 'Pasir'} (${order.Unit ?? 0} unit)`;
          const delivery = order.tipe_pengiriman === 'truck' ? 'Truk' : 'PickUp';
          const price = 'Rp ' + new Intl.NumberFormat('id-ID').format(order.total_harga);
          
          let statusBadge = '';
          if (order.Status_Pesanan === 'Selesai') {
            statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700">Selesai</span>';
          } else if (order.Status_Pesanan === 'Dibatalkan') {
            statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-600">Batal</span>';
          } else if (order.Status_Pesanan === 'Belum Diterima Toko') {
            statusBadge = '<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700">Menunggu</span>';
          } else {
            statusBadge = `<span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">${order.Status_Pesanan}</span>`;
          }

          const tr = document.createElement('tr');
          tr.className = 'hover:bg-surface-container-low/40 transition-colors';
          tr.innerHTML = `
            <td class="px-4 py-3 text-xs text-on-surface-variant">${date}</td>
            <td class="px-4 py-3 font-semibold text-xs">${product}</td>
            <td class="px-4 py-3 text-xs text-on-surface-variant">${delivery}</td>
            <td class="px-4 py-3 text-right font-semibold text-xs text-primary">${price}</td>
            <td class="px-4 py-3 text-center">${statusBadge}</td>
          `;
          tbody.appendChild(tr);
        });
      }

      // Disable scrolling on background main element
      const mainContainer = document.querySelector('main');
      if (mainContainer) {
        mainContainer.classList.add('overflow-hidden');
        mainContainer.classList.remove('overflow-y-auto');
      }

      // Show Modal with Animation
      const modal = document.getElementById('detailModal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      
      // Delay minor to let CSS trigger transition
      setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.querySelector('.transform').classList.remove('scale-95');
      }, 10);
    }

    function closeCustomerDetailModal() {
      const modal = document.getElementById('detailModal');
      modal.classList.add('opacity-0');
      modal.querySelector('.transform').classList.add('scale-95');

      setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        
        // Restore scrolling on background main element
        const mainContainer = document.querySelector('main');
        if (mainContainer) {
          mainContainer.classList.remove('overflow-hidden');
          mainContainer.classList.add('overflow-y-auto');
        }
      }, 300);
    }

    // Close on backdrop click
    document.getElementById('detailModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeCustomerDetailModal();
      }
    });
  </script>
  @endpush

</x-layout-store>