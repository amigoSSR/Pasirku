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
        ['icon'=>'group','bg'=>'bg-primary/10','text'=>'text-primary','label'=>'Total Pelanggan','value'=>'1.284','badge'=>'+12%','up'=>true],
        ['icon'=>'person_check','bg'=>'bg-tertiary/10','text'=>'text-tertiary','label'=>'Pelanggan Aktif','value'=>'942','badge'=>'+3%','up'=>true],
        ['icon'=>'receipt_long','bg'=>'bg-secondary/10','text'=>'text-secondary','label'=>'Total Transaksi','value'=>'3.741','badge'=>'+8%','up'=>true],
        ['icon'=>'person_add','bg'=>'bg-amber-500/10','text'=>'text-amber-600','label'=>'Pelanggan Baru','value'=>'47','badge'=>'Bulan ini','up'=>true],
      ];
      @endphp
      @foreach($stats as $s)
      <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 cursor-default">
        <div class="flex justify-between items-start mb-4">
          <div class="w-11 h-11 {{ $s['bg'] }} rounded-xl flex items-center justify-center">
            <span class="material-symbols-outlined {{ $s['text'] }}" style="font-variation-settings:'FILL' 1">{{ $s['icon'] }}</span>
          </div>
          <span class="text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5 {{ $s['up'] ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }}">
            <span class="material-symbols-outlined text-xs">{{ $s['up'] ? 'trending_up' : 'trending_down' }}</span>{{ $s['badge'] }}
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
              $customers = [
                ['name'=>'Budi Santoso','email'=>'budi@example.com','initials'=>'BS','color'=>'bg-orange-100 text-orange-700','total'=>'Rp 4.250.000','trx'=>12,'status'=>'Aktif','last'=>'2 jam lalu'],
                ['name'=>'Siti Rahayu','email'=>'siti@example.com','initials'=>'SR','color'=>'bg-amber-100 text-amber-700','total'=>'Rp 2.100.000','trx'=>7,'status'=>'Aktif','last'=>'1 hari lalu'],
                ['name'=>'Ahmad Fauzi','email'=>'ahmad@example.com','initials'=>'AF','color'=>'bg-blue-100 text-blue-700','total'=>'Rp 890.000','trx'=>3,'status'=>'Nonaktif','last'=>'12 hari lalu'],
                ['name'=>'Dewi Lestari','email'=>'dewi@example.com','initials'=>'DL','color'=>'bg-green-100 text-green-700','total'=>'Rp 5.700.000','trx'=>18,'status'=>'Aktif','last'=>'5 menit lalu'],
                ['name'=>'Rizky Pratama','email'=>'rizky@example.com','initials'=>'RP','color'=>'bg-purple-100 text-purple-700','total'=>'Rp 340.000','trx'=>1,'status'=>'Nonaktif','last'=>'30 hari lalu'],
              ];
              @endphp
              @foreach($customers as $c)
              <tr class="hover:bg-surface-container-low/60 transition-colors cursor-pointer">
                <td class="px-5 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full {{ $c['color'] }} flex items-center justify-center font-bold text-sm shrink-0">{{ $c['initials'] }}</div>
                    <div>
                      <p class="font-semibold text-on-surface">{{ $c['name'] }}</p>
                      <p class="text-xs text-on-surface-variant">{{ $c['email'] }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-5 py-4 font-semibold text-primary">{{ $c['total'] }}</td>
                <td class="px-5 py-4 text-on-surface-variant">{{ $c['trx'] }}x</td>
                <td class="px-5 py-4">
                  @if($c['status'] === 'Aktif')
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-50 text-green-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container text-on-surface-variant">
                      <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>Nonaktif
                    </span>
                  @endif
                </td>
                <td class="px-5 py-4 text-xs text-on-surface-variant">{{ $c['last'] }}</td>
                <td class="px-5 py-4 text-right">
                  <button class="text-primary hover:bg-primary/10 p-1.5 rounded-lg transition-colors" title="Lihat Detail">
                    <span class="material-symbols-outlined text-lg">open_in_new</span>
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="px-5 py-4 border-t border-outline-variant/20 flex items-center justify-between text-sm">
          <span class="text-on-surface-variant">Menampilkan 1–5 dari 1.284 pelanggan</span>
          <div class="flex gap-1">
            <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant disabled:opacity-40" disabled>
              <span class="material-symbols-outlined text-sm">chevron_left</span>
            </button>
            <button class="px-3 py-1.5 rounded-lg bg-primary text-on-primary font-semibold">1</button>
            <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">2</button>
            <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">3</button>
            <button class="px-3 py-1.5 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-low transition-colors">
              <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
          </div>
        </div>
      </div>

      {{-- Right Panel --}}
      <div class="space-y-6">
        {{-- Activity Timeline --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
          <div class="p-5 border-b border-outline-variant/20 flex items-center justify-between">
            <h2 class="font-headline font-bold text-lg text-on-surface">Aktivitas Terkini</h2>
            <a href="#" class="text-primary text-xs font-semibold hover:underline">Lihat Semua</a>
          </div>
          <div class="p-5 space-y-4">
            @php
            $activities = [
              ['icon'=>'shopping_bag','color'=>'bg-primary/10 text-primary','title'=>'Dewi Lestari melakukan pesanan','desc'=>'Pasir Cor 5m³ — Rp 350.000','time'=>'5 mnt lalu'],
              ['icon'=>'rate_review','color'=>'bg-amber-50 text-amber-600','title'=>'Budi Santoso memberi ulasan','desc'=>'Bintang 5 untuk Batu Split','time'=>'1 jam lalu'],
              ['icon'=>'local_shipping','color'=>'bg-green-50 text-green-600','title'=>'Pesanan Siti Rahayu dikirim','desc'=>'No. Resi: TRP-20240514','time'=>'3 jam lalu'],
              ['icon'=>'person_add','color'=>'bg-blue-50 text-blue-600','title'=>'Pelanggan baru bergabung','desc'=>'Hendra Gunawan mendaftar','time'=>'5 jam lalu'],
              ['icon'=>'cancel','color'=>'bg-red-50 text-red-500','title'=>'Ahmad Fauzi membatalkan pesanan','desc'=>'Pasir Halus 2m³','time'=>'1 hari lalu'],
            ];
            @endphp
            @foreach($activities as $act)
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
            @endforeach
          </div>
        </div>

        {{-- Loyal Customers --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/30 p-5">
          <h2 class="font-headline font-bold text-lg text-on-surface mb-4">Pelanggan Loyal</h2>
          <div class="space-y-4">
            @php
            $loyal = [
              ['name'=>'Dewi Lestari','trx'=>18,'max'=>20,'color'=>'bg-primary'],
              ['name'=>'Budi Santoso','trx'=>12,'max'=>20,'color'=>'bg-tertiary'],
              ['name'=>'Siti Rahayu','trx'=>7,'max'=>20,'color'=>'bg-secondary'],
            ];
            @endphp
            @foreach($loyal as $l)
            <div>
              <div class="flex justify-between items-center mb-1.5">
                <span class="text-sm font-medium text-on-surface">{{ $l['name'] }}</span>
                <span class="text-xs text-on-surface-variant">{{ $l['trx'] }}/{{ $l['max'] }} transaksi</span>
              </div>
              <div class="h-2 bg-surface-container-high rounded-full overflow-hidden">
                <div class="{{ $l['color'] }} h-full rounded-full" style="width: {{ ($l['trx']/$l['max'])*100 }}%"></div>
              </div>
            </div>
            @endforeach
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
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  </script>
  @endpush

</x-layout-store>