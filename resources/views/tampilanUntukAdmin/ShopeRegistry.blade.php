@include('tampilanUntukAdmin.topbarAdmin')
<!-- Main Content Area -->
<main class="md:ml-72 flex-1 p-8 bg-surface overflow-y-auto transition-all duration-300 pt-24 min-h-screen">
<header class="mb-10">
<h1 class="text-4xl font-extrabold text-on-surface tracking-tighter headline-lg">Daftar toko yang mendaftar</h1>
</header>

@if(session('success'))
<div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200 text-sm font-semibold flex items-center gap-2">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200 text-sm font-semibold flex items-center gap-2">
    <span class="material-symbols-outlined">error</span>
    {{ session('error') }}
</div>
@endif
<!-- Bento Layout Content -->
<div class="grid grid-cols-12 gap-8">
<!-- Registered Buyers Section -->
<section class="col-span-12 lg:col-span-12">
<div class="bg-surface-container-low rounded-xl p-1 overflow-hidden">
<div class="px-6 py-5 flex justify-between items-center bg-surface-container-low">
<div>
<h2 class="text-xl font-bold text-primary tracking-tight">Registered Buyers</h2>
<p class="text-sm text-on-surface-variant">Active procurement entities in the last 30 days.</p>
</div>
<button class="bg-white hover:bg-surface text-primary border border-outline-variant/30 px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="download">download</span> Export CSV
                            </button>
</div>
<div class="overflow-x-auto bg-white rounded-lg shadow-sm">
<table class="w-full min-w-max text-left border-collapse whitespace-nowrap">
<thead>
<tr class="border-b border-surface-container text-xs font-bold text-outline uppercase tracking-wider">
<th class="px-6 py-4">Name</th>
<th class="px-6 py-4">Email</th>
<th class="px-6 py-4">Phone Number</th>
<th class="px-6 py-4">Lokasi Toko</th>
<th class="px-6 py-4">Pendapatan Toko</th>
<th class="px-6 py-4">Total Pembelian</th>
<th class="px-6 py-4">Komis Tokoh</th>
<th class="px-6 py-4 text-right">Status</th>

</tr>
</thead>
<tbody class="divide-y divide-surface-container">
@forelse ($tokoList as $toko)
<tr class="hover:bg-surface-container-low/50 transition-colors group">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="h-8 w-8 rounded-md bg-surface-container-highest flex items-center justify-center text-primary font-bold text-xs">{{ strtoupper(substr($toko->Nama_Toko, 0, 2)) }}</div>
<span class="font-semibold text-on-surface">{{ $toko->Nama_Toko }}</span>
</div>
</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">{{ $toko->Email_Toko }}</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">{{ $toko->Nomer_Telepon_Toko }}</td>
<td class="px-6 py-4 text-sm text-on-surface-variant">{{ $toko->Lokasi_Toko ?? '-' }}</td>
<td class="px-6 py-4 text-sm text-on-surface-variant font-medium">Rp {{ number_format($toko->Pendapatan_Toko ?? 0, 0, ',', '.') }}</td>
<td class="px-6 py-4 text-sm text-on-surface-variant font-medium">{{ number_format($toko->Total_Pembelian ?? 0, 0, ',', '.') }}</td>
<td class="px-6 py-4 text-sm text-on-surface-variant font-medium">Rp {{ number_format($toko->Komisi_Admin ?? 0, 0, ',', '.') }}</td>
<td class="px-6 py-4 text-right">
    <div class="flex flex-col items-end gap-2">
        @if(isset($toko->Status) && $toko->Status == 'active')
            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase inline-flex items-center gap-1"><span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Active</span>
            <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan toko ini?');">
                @csrf
                @method('PUT')
                <button type="submit" class="text-[10px] bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-md hover:bg-red-100 transition-colors font-bold uppercase tracking-wider">Set Inactive</button>
            </form>
        @else
            <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-3 py-1 rounded-full uppercase inline-flex items-center gap-1"><span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span> Inactive</span>
            <form action="{{ route('admin.shope.toggleStatus', $toko->ID_Toko) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan toko ini?');">
                @csrf
                @method('PUT')
                <button type="submit" class="text-[10px] bg-green-50 text-green-600 border border-green-200 px-3 py-1.5 rounded-md hover:bg-green-100 transition-colors font-bold uppercase tracking-wider">Set Active</button>
            </form>
        @endif
    </div>
</td>
</tr>
@empty
<tr>
<td colspan="8" class="px-6 py-8 text-center text-on-surface-variant">Belum ada data toko.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
<!-- Card Variant for Seller Network to showcase "Non-Standard" layout -->

<!-- Seller Table Detail (Traditional but Elevated) -->
</body></html>