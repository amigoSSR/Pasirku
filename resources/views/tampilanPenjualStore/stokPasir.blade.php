<x-layout-store title="Stok Pasir Realtime">
<x-slot name="header">
  <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-2">
    <a href="{{ route('MenuUtamaStore') }}" class="hover:text-primary">Dashboard</a>
    <span class="material-symbols-outlined text-xs">chevron_right</span>
    <span class="font-semibold text-primary">Stok Pasir</span>
  </nav>
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div>
      <h1 class="font-headline text-3xl font-bold text-on-surface">Stok Pasir Realtime</h1>
      <p class="text-on-surface-variant text-sm mt-1">Update otomatis setiap 5 detik.</p>
    </div>
    <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 border border-green-200 rounded-xl">
      <span id="pulse" class="w-2 h-2 rounded-full bg-green-500 animate-pulse inline-block"></span>
      <span class="text-xs font-semibold text-green-700">Live · <span id="last-updated">--:--:--</span></span>
    </div>
  </div>
</x-slot>

<div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-6">

  {{-- Toast --}}
  <div id="toast" class="hidden fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg text-sm font-semibold transition-all duration-300"></div>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/30 shadow-sm">
      <div class="w-10 h-10 bg-tertiary/10 rounded-xl flex items-center justify-center mb-3">
        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings:'FILL' 1">inventory_2</span>
      </div>
      <p class="text-2xl font-headline font-bold text-on-surface" id="sum-total">-</p>
      <p class="text-xs text-on-surface-variant font-medium mt-0.5">Total Produk</p>
    </div>
    <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/30 shadow-sm">
      <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-3">
        <span class="material-symbols-outlined text-green-600" style="font-variation-settings:'FILL' 1">check_circle</span>
      </div>
      <p class="text-2xl font-headline font-bold text-on-surface" id="sum-aman">-</p>
      <p class="text-xs text-on-surface-variant font-medium mt-0.5">Stok Aman</p>
    </div>
    <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/30 shadow-sm">
      <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mb-3">
        <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">warning</span>
      </div>
      <p class="text-2xl font-headline font-bold text-on-surface" id="sum-menipis">-</p>
      <p class="text-xs text-on-surface-variant font-medium mt-0.5">Stok Menipis</p>
    </div>
    <div class="stat-card bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/30 shadow-sm">
      <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mb-3">
        <span class="material-symbols-outlined text-error" style="font-variation-settings:'FILL' 1">cancel</span>
      </div>
      <p class="text-2xl font-headline font-bold text-on-surface" id="sum-habis">-</p>
      <p class="text-xs text-on-surface-variant font-medium mt-0.5">Stok Habis</p>
    </div>
  </div>

  {{-- Chart + Filter Row --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Bar Chart --}}
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6">
      <h2 class="font-headline font-bold text-base text-on-surface mb-4">Grafik Stok per Kategori</h2>
      <div class="relative h-48">
        <canvas id="stokChart"></canvas>
      </div>
    </div>

    {{-- Filter Panel --}}
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm p-6 flex flex-col gap-4">
      <h2 class="font-headline font-bold text-base text-on-surface">Filter & Cari</h2>
      <div class="relative">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
        <input id="search-input" type="text" placeholder="Cari nama pasir..."
          class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-outline-variant bg-surface-container-low text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
      </div>
      <div>
        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Kategori</label>
        <div class="relative">
          <select id="filter-kategori"
            class="w-full appearance-none px-4 py-2.5 pr-8 rounded-xl border border-outline-variant bg-surface-container-low text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all cursor-pointer">
            <option value="semua">Semua Kategori</option>
            @foreach($kategoriList as $kat)
              <option value="{{ $kat }}">{{ $kat }}</option>
            @endforeach
          </select>
          <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
        </div>
      </div>
      <div>
        <label class="block text-xs font-semibold text-on-surface-variant mb-1.5">Status Stok</label>
        <div class="relative">
          <select id="filter-status"
            class="w-full appearance-none px-4 py-2.5 pr-8 rounded-xl border border-outline-variant bg-surface-container-low text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all cursor-pointer">
            <option value="semua">Semua Status</option>
            <option value="aman">Aman</option>
            <option value="menipis">Menipis</option>
            <option value="habis">Habis</option>
          </select>
          <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[18px]">expand_more</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Table --}}
  <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-outline-variant/20 flex items-center justify-between">
      <h2 class="font-headline font-bold text-base text-on-surface">Daftar Produk Pasir</h2>
      <span class="text-xs text-on-surface-variant" id="count-label">Memuat...</span>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-surface-container-low text-on-surface-variant text-xs font-semibold uppercase tracking-wide">
            <th class="px-5 py-3 text-left">Produk</th>
            <th class="px-5 py-3 text-left">Kategori</th>
            <th class="px-5 py-3 text-center">Harga</th>
            <th class="px-5 py-3 text-center">Stok PickUp</th>
            <th class="px-5 py-3 text-center">Ongkir PickUp</th>
            <th class="px-5 py-3 text-center">Stok Truck</th>
            <th class="px-5 py-3 text-center">Ongkir Truck</th>
            <th class="px-5 py-3 text-center">Masuk</th>
            <th class="px-5 py-3 text-center">Keluar</th>
            <th class="px-5 py-3 text-center">Status</th>
            <th class="px-5 py-3 text-center">Diperbarui</th>
            <th class="px-5 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="stok-table-body" class="divide-y divide-outline-variant/20">
          <tr><td colspan="9" class="text-center py-12 text-on-surface-variant">
            <span class="material-symbols-outlined text-4xl animate-spin block mb-2">progress_activity</span>
            Memuat data...
          </td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Modal Ubah Stok --}}
<div id="modal-stok" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
  <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 animate-fadeUp">
    <div class="flex items-center justify-between mb-5">
      <div>
        <h3 class="font-headline font-bold text-lg text-on-surface" id="modal-title">Ubah Stok</h3>
        <p class="text-xs text-on-surface-variant mt-0.5" id="modal-produk-nama">-</p>
      </div>
      <button onclick="closeModal()" class="text-on-surface-variant hover:text-on-surface transition-colors">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>

    <form id="modal-form" class="space-y-4">
      <input type="hidden" id="modal-id-produk">
      <input type="hidden" id="modal-tipe">

      <div>
        <label class="block text-sm font-semibold text-on-surface mb-1.5">Jenis Kendaraan</label>
        <div class="grid grid-cols-2 gap-3">
          <label class="cursor-pointer">
            <input type="radio" name="modal-jenis" value="pickup" class="peer sr-only" checked>
            <div class="flex items-center justify-center gap-2 p-3 rounded-xl border-2 border-outline-variant peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-sm font-semibold">
              <span class="material-symbols-outlined text-[18px]">local_taxi</span> Pick Up
            </div>
          </label>
          <label class="cursor-pointer">
            <input type="radio" name="modal-jenis" value="truck" class="peer sr-only">
            <div class="flex items-center justify-center gap-2 p-3 rounded-xl border-2 border-outline-variant peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-sm font-semibold">
              <span class="material-symbols-outlined text-[18px]">local_shipping</span> Truck
            </div>
          </label>
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-on-surface mb-1.5">
          Jumlah <span class="text-error">*</span>
        </label>
        <input id="modal-jumlah" type="number" min="1" placeholder="0"
          class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface-container-low text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
        <p class="text-xs text-on-surface-variant mt-1" id="modal-stok-info"></p>
      </div>

      <div>
        <label class="block text-sm font-semibold text-on-surface mb-1.5">Keterangan</label>
        <input id="modal-keterangan" type="text" placeholder="Opsional..."
          class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface-container-low text-sm focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all">
      </div>

      <div class="flex gap-3 pt-2">
        <button type="button" onclick="closeModal()"
          class="flex-1 py-3 rounded-xl border border-outline-variant text-on-surface-variant text-sm font-semibold hover:bg-surface-container-low transition-all">
          Batal
        </button>
        <button type="submit" id="modal-submit"
          class="flex-1 py-3 rounded-xl bg-primary text-on-primary text-sm font-bold hover:opacity-90 transition-all shadow-md shadow-primary/20">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;
const API    = "{{ route('stokPasir.data') }}";
const URL_T  = "{{ route('stokPasir.tambah') }}";
const URL_K  = "{{ route('stokPasir.kurangi') }}";
const URL_O  = "{{ route('stokPasir.updateOngkir') }}";

let allData  = [];
let chart    = null;
let modalProduk = null;

/* ===== CHART ===== */
function initChart() {
  const ctx = document.getElementById('stokChart').getContext('2d');
  chart = new Chart(ctx, {
    type: 'bar',
    data: { labels: [], datasets: [{ label: 'Total Stok', data: [], backgroundColor: '#944a00cc', borderRadius: 8 }] },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, grid: { color: '#dcc1b120' } }, x: { grid: { display: false } } }
    }
  });
}

function updateChart(chartData) {
  if (!chart) return;
  chart.data.labels   = chartData.map(d => d.label);
  chart.data.datasets[0].data = chartData.map(d => d.value);
  chart.update('none');
}

/* ===== FETCH DATA ===== */
function fetchData() {
  const search   = document.getElementById('search-input').value;
  const kategori = document.getElementById('filter-kategori').value;
  const params   = new URLSearchParams({ search, kategori });

  fetch(`${API}?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json())
    .then(json => {
      allData = json.produk;
      renderTable(allData);
      updateSummary(json.summary);
      updateChart(json.chart);
      document.getElementById('last-updated').textContent = json.last_updated;
    })
    .catch(() => {});
}

/* ===== SUMMARY ===== */
function updateSummary(s) {
  document.getElementById('sum-total').textContent   = s.totalProduk;
  document.getElementById('sum-aman').textContent    = s.stokAman;
  document.getElementById('sum-menipis').textContent = s.stokMenipis;
  document.getElementById('sum-habis').textContent   = s.stokHabis;
}

/* ===== TABLE ===== */
function statusBadge(s) {
  const map = {
    aman:    { cls: 'bg-green-100 text-green-700',  label: 'Aman' },
    menipis: { cls: 'bg-amber-100 text-amber-700',  label: 'Menipis' },
    habis:   { cls: 'bg-red-100 text-red-700',      label: 'Habis' },
  };
  const b = map[s] ?? map.habis;
  return `<span class="px-2.5 py-1 rounded-full text-xs font-bold ${b.cls}">${b.label}</span>`;
}

function renderTable(data) {
  const filterStatus = document.getElementById('filter-status').value;
  const filtered = filterStatus === 'semua' ? data : data.filter(p => p.status_stok === filterStatus);
  const tbody = document.getElementById('stok-table-body');
  document.getElementById('count-label').textContent = `${filtered.length} produk`;

  if (!filtered.length) {
    tbody.innerHTML = `<tr><td colspan="9" class="text-center py-12 text-on-surface-variant text-sm">Tidak ada produk ditemukan.</td></tr>`;
    return;
  }

  tbody.innerHTML = filtered.map(p => `
    <tr class="hover:bg-surface-container-low/50 transition-colors" id="row-${p.id}">
      <td class="px-5 py-4">
        <p class="font-semibold text-on-surface">${p.nama_pasir}</p>
        <p class="text-xs text-on-surface-variant">${p.satuan}</p>
      </td>
      <td class="px-5 py-4">
        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">${p.kategori}</span>
      </td>
      <td class="px-5 py-4 text-center">
        <span class="text-xs font-black text-primary">Rp ${Number(p.harga).toLocaleString('id-ID')}</span>
      </td>
      <td class="px-5 py-4 text-center font-bold text-on-surface">${p.stock_pickup}</td>
      <td class="px-5 py-4 text-center">
        <div class="flex flex-col items-center gap-1">
          <span class="text-xs font-semibold text-on-surface-variant">Rp ${Number(p.ongkir_pickup).toLocaleString('id-ID')}</span>
          <button onclick="openModal('ongkir', ${p.id}, 'pickup')" class="text-[10px] font-bold text-on-surface-variant hover:text-primary underline uppercase tracking-tighter">Ubah</button>
        </div>
      </td>
      <td class="px-5 py-4 text-center font-bold text-on-surface">${p.stock_truck}</td>
      <td class="px-5 py-4 text-center">
        <div class="flex flex-col items-center gap-1">
          <span class="text-xs font-semibold text-on-surface-variant">Rp ${Number(p.ongkir_truck).toLocaleString('id-ID')}</span>
          <button onclick="openModal('ongkir', ${p.id}, 'truck')" class="text-[10px] font-bold text-on-surface-variant hover:text-primary underline uppercase tracking-tighter">Ubah</button>
        </div>
      </td>
      <td class="px-5 py-4 text-center">
        <span class="text-green-600 font-semibold">+${p.stok_masuk}</span>
      </td>
      <td class="px-5 py-4 text-center">
        <span class="text-error font-semibold">-${p.stok_keluar}</span>
      </td>
      <td class="px-5 py-4 text-center">${statusBadge(p.status_stok)}</td>
      <td class="px-5 py-4 text-center text-xs text-on-surface-variant">${p.terakhir_diperbarui}</td>
      <td class="px-5 py-4 text-center">
        <div class="flex items-center justify-center gap-2">
          <button onclick="openModal('tambah', ${p.id})"
            class="w-8 h-8 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 flex items-center justify-center transition-colors"
            title="Tambah Stok">
            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1">add</span>
          </button>
          <button onclick="openModal('kurangi', ${p.id})"
            class="w-8 h-8 rounded-lg bg-red-100 text-error hover:bg-red-200 flex items-center justify-center transition-colors"
            title="Kurangi Stok">
            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1">remove</span>
          </button>
        </div>
      </td>
    </tr>
  `).join('');
}

/* ===== MODAL ===== */
function openModal(tipe, id, defaultJenis = 'pickup') {
  modalProduk = allData.find(p => p.id === id);
  if (!modalProduk) return;

  const titles = { 'tambah': 'Tambah Stok', 'kurangi': 'Kurangi Stok', 'ongkir': 'Update Ongkir' };
  document.getElementById('modal-title').textContent = titles[tipe] ?? 'Ubah Data';
  document.getElementById('modal-produk-nama').textContent = modalProduk.nama_pasir;
  document.getElementById('modal-id-produk').value = id;
  document.getElementById('modal-tipe').value = tipe;
  document.getElementById('modal-jumlah').value = '';
  document.getElementById('modal-keterangan').value = '';
  
  // Set default jenis radio
  document.querySelectorAll('input[name="modal-jenis"]').forEach(r => {
    if(r.value === defaultJenis) r.checked = true;
  });

  const submitText = titles[tipe] ?? 'Simpan';
  document.getElementById('modal-submit').textContent = submitText;
  
  let submitClass = 'flex-1 py-3 rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-md ';
  if(tipe === 'tambah') submitClass += 'bg-green-600 text-white shadow-green-600/20';
  else if(tipe === 'kurangi') submitClass += 'bg-error text-on-error shadow-error/20';
  else submitClass += 'bg-primary text-on-primary shadow-primary/20';
  
  document.getElementById('modal-submit').className = submitClass;
  updateModalInfo();
  document.getElementById('modal-stok').classList.remove('hidden');
}

function closeModal() {
  document.getElementById('modal-stok').classList.add('hidden');
}

function updateModalInfo() {
  if (!modalProduk) return;
  const tipe  = document.getElementById('modal-tipe').value;
  const jenis = document.querySelector('input[name="modal-jenis"]:checked')?.value ?? 'pickup';
  
  if (tipe === 'ongkir') {
    const ongkir = jenis === 'pickup' ? modalProduk.ongkir_pickup : modalProduk.ongkir_truck;
    document.getElementById('modal-stok-info').textContent = `Ongkir ${jenis} saat ini: Rp ${Number(ongkir).toLocaleString('id-ID')}`;
  } else {
    const stok  = jenis === 'pickup' ? modalProduk.stock_pickup : modalProduk.stock_truck;
    document.getElementById('modal-stok-info').textContent = `Stok ${jenis} saat ini: ${stok} ${modalProduk.satuan}`;
  }
}
document.querySelectorAll('input[name="modal-jenis"]').forEach(r => r.addEventListener('change', updateModalInfo));

/* ===== FORM SUBMIT ===== */
document.getElementById('modal-form').addEventListener('submit', async function(e) {
  e.preventDefault();
  const tipe       = document.getElementById('modal-tipe').value;
  const id_produk  = document.getElementById('modal-id-produk').value;
  const jenis      = document.querySelector('input[name="modal-jenis"]:checked')?.value ?? 'pickup';
  const jumlah     = document.getElementById('modal-jumlah').value;
  const keterangan = document.getElementById('modal-keterangan').value;
  
  let url = URL_T;
  if(tipe === 'kurangi') url = URL_K;
  else if(tipe === 'ongkir') url = URL_O;

  const btn = document.getElementById('modal-submit');
  btn.disabled = true;
  btn.textContent = 'Menyimpan...';

  try {
    const res  = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
      body: JSON.stringify({ id_produk, jenis, jumlah, keterangan }),
    });
    const json = await res.json();
    if (json.success) {
      showToast(json.message, 'success');
      closeModal();
      fetchData();
    } else {
      showToast(json.message, 'error');
    }
  } catch {
    showToast('Terjadi kesalahan jaringan.', 'error');
  } finally {
    btn.disabled = false;
  }
});

/* ===== TOAST ===== */
function showToast(msg, type) {
  const t = document.getElementById('toast');
  t.className = `fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl shadow-lg text-sm font-semibold transition-all duration-300 ${type === 'success' ? 'bg-green-600 text-white' : 'bg-error text-on-error'}`;
  t.innerHTML = `<span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 1">${type === 'success' ? 'check_circle' : 'error'}</span>${msg}`;
  t.classList.remove('hidden');
  setTimeout(() => t.classList.add('hidden'), 3000);
}

/* ===== INIT ===== */
initChart();
fetchData();
setInterval(fetchData, 5000);

document.getElementById('search-input').addEventListener('input', fetchData);
document.getElementById('filter-kategori').addEventListener('change', fetchData);
document.getElementById('filter-status').addEventListener('change', () => renderTable(allData));
</script>
@endpush
</x-layout-store>
