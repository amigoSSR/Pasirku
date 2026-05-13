@include('tampilanUntukAdmin.topbarAdmin')
<!-- Main Content -->
<main class="md:ml-72 pt-24 px-6 pb-12 min-h-screen bg-surface transition-all duration-300">
<!-- Header Section -->
<div class="max-w-7xl mx-auto mb-10">
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
<div>
<nav class="flex items-center gap-2 text-slate-500 text-sm mb-4">
<a class="hover:text-primary" href="#">Seller Network</a>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<span class="text-on-surface">Shop Detail</span>
</nav>
<h1 class="monolithic-text text-4xl font-extrabold text-on-surface mb-2">Sahara Sands Quarry</h1>
<div class="flex items-center gap-2 text-secondary font-medium">
<span class="material-symbols-outlined text-base">location_on</span>
<span class="text-sm tracking-wide">Eastern Ridge Industrial Zone, Sector 4</span>
</div>
</div>
<div class="flex gap-4">
<button class="bg-surface-container-low text-on-surface px-6 py-3 rounded-md font-semibold text-sm flex items-center gap-2 hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-sm">arrow_back</span>
                        Back to Dashboard
                    </button>
<button class="bg-gradient-to-br from-primary to-primary-container text-white px-6 py-3 rounded-md font-semibold text-sm flex items-center gap-2 shadow-sm active:scale-95 transition-all">
<span class="material-symbols-outlined text-sm">edit</span>
                        Manage Shop
                    </button>
</div>
</div>
</div>
<!-- Bento Grid Analytics -->
<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<!-- Total Customers -->
<div class="bg-surface-container-low p-8 rounded-xl relative overflow-hidden group">
<div class="relative z-10">
<span class="text-xs font-bold uppercase tracking-widest text-secondary mb-4 block">Total Customers</span>
<h2 class="monolithic-text text-5xl font-black text-on-surface">1,284</h2>
<p class="text-sm text-slate-500 mt-4 flex items-center gap-1">
<span class="material-symbols-outlined text-green-600 text-sm">trending_up</span>
<span class="text-green-600 font-bold">+12%</span> from last month
                    </p>
</div>
<span class="material-symbols-outlined absolute -bottom-4 -right-4 text-9xl text-primary/5 opacity-20 pointer-events-none">group</span>
</div>
<!-- Total Revenue -->
<div class="bg-surface-container-low p-8 rounded-xl relative overflow-hidden group">
<div class="relative z-10">
<span class="text-xs font-bold uppercase tracking-widest text-secondary mb-4 block">Total Shop Revenue</span>
<h2 class="monolithic-text text-5xl font-black text-on-surface">$428.5k</h2>
<p class="text-sm text-slate-500 mt-4 flex items-center gap-1">
<span class="material-symbols-outlined text-green-600 text-sm">trending_up</span>
<span class="text-green-600 font-bold">+8.4%</span> volume increase
                    </p>
</div>
<span class="material-symbols-outlined absolute -bottom-4 -right-4 text-9xl text-primary/5 opacity-20 pointer-events-none">payments</span>
</div>
<!-- Admin Commission -->
<div class="bg-on-background p-8 rounded-xl relative overflow-hidden border border-primary/10">
<div class="relative z-10">
<span class="text-xs font-bold uppercase tracking-widest text-primary-fixed mb-4 block">Admin Commission (11%)</span>
<h2 class="monolithic-text text-5xl font-black text-white">$47,135</h2>
<div class="mt-4 flex items-center justify-between">
<p class="text-xs text-primary-fixed/60 font-medium">Platform Fee Net</p>
<span class="bg-primary-container/30 text-primary-fixed px-2 py-1 rounded text-[10px] font-bold uppercase">Settled</span>
</div>
</div>
<div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent opacity-50"></div>
</div>
</div>
<!-- Transactions Section -->
<div class="max-w-7xl mx-auto">
<div class="flex items-center justify-between mb-6">
<h3 class="monolithic-text text-2xl font-bold text-on-surface">Recent Transactions</h3>
<button class="text-primary text-sm font-bold flex items-center gap-1 hover:underline">
                    View All Manifests
                    <span class="material-symbols-outlined text-sm">open_in_new</span>
</button>
</div>
<!-- Custom Table Component (Tectonic Precision Style) -->
<div class="bg-surface-container-low rounded-xl overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-high/50">
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Transaction ID</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Date</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Material</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Customer</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Volume</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Total Paid</th>
<th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-secondary">Status</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
<!-- Row 1 -->
<tr class="hover:bg-white transition-colors">
<td class="px-8 py-6 font-mono text-sm font-bold text-primary">#TRX-88210</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">Oct 24, 2023</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-on-secondary-container text-sm">terrain</span>
</div>
<span class="text-sm font-semibold">Fine Silic Sands</span>
</div>
</td>
<td class="px-8 py-6 text-sm">Apex Foundations Ltd.</td>
<td class="px-8 py-6 text-sm font-medium">450 Tons</td>
<td class="px-8 py-6 text-sm font-bold">$12,450.00</td>
<td class="px-8 py-6">
<span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 text-[10px] font-black uppercase">Delivered</span>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-white transition-colors">
<td class="px-8 py-6 font-mono text-sm font-bold text-primary">#TRX-88209</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">Oct 23, 2023</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-on-secondary-container text-sm">grid_view</span>
</div>
<span class="text-sm font-semibold">Coarse Gravel Mix</span>
</div>
</td>
<td class="px-8 py-6 text-sm">City Metro Works</td>
<td class="px-8 py-6 text-sm font-medium">1,200 Tons</td>
<td class="px-8 py-6 text-sm font-bold">$28,800.00</td>
<td class="px-8 py-6">
<span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-700 text-[10px] font-black uppercase">In Transit</span>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-white transition-colors">
<td class="px-8 py-6 font-mono text-sm font-bold text-primary">#TRX-88204</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">Oct 22, 2023</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-on-secondary-container text-sm">layers</span>
</div>
<span class="text-sm font-semibold">Base Rock Layer</span>
</div>
</td>
<td class="px-8 py-6 text-sm">Riverway Dev.</td>
<td class="px-8 py-6 text-sm font-medium">85 Tons</td>
<td class="px-8 py-6 text-sm font-bold">$4,250.00</td>
<td class="px-8 py-6">
<span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 text-[10px] font-black uppercase">Delivered</span>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-white transition-colors">
<td class="px-8 py-6 font-mono text-sm font-bold text-primary">#TRX-88198</td>
<td class="px-8 py-6 text-sm text-on-surface-variant">Oct 21, 2023</td>
<td class="px-8 py-6">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-on-secondary-container text-sm">terrain</span>
</div>
<span class="text-sm font-semibold">Fine Silic Sands</span>
</div>
</td>
<td class="px-8 py-6 text-sm">Solo Build Co.</td>
<td class="px-8 py-6 text-sm font-medium">200 Tons</td>
<td class="px-8 py-6 text-sm font-bold">$5,800.00</td>
<td class="px-8 py-6">
<span class="inline-flex items-center px-2 py-1 rounded bg-orange-100 text-orange-700 text-[10px] font-black uppercase">Pending Payment</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<!-- Supplementary Data Section -->
<div class="max-w-7xl mx-auto mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="bg-surface-container-high/30 p-8 rounded-xl flex flex-col justify-between">
<div>
<h4 class="monolithic-text text-xl font-bold mb-4">Location Precision</h4>
<p class="text-sm text-on-surface-variant leading-relaxed mb-6">Sahara Sands Quarry operates in a high-density industrial corridor. Logistic efficiency for this hub is currently rated at 94.2% based on access to primary haulage routes.</p>
</div>
<div class="h-48 w-full rounded-lg overflow-hidden bg-surface-dim relative">
<img class="w-full h-full object-cover grayscale opacity-50" data-alt="abstract satellite map view of industrial grid with heavy machinery tracks and earthwork patterns" data-location="Eastern Ridge" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDcR82cxCtH_9ChyhzQv97njRiPO9wQeDsuFuzlKbEboeQJiPemN2WdatcS2b4MZXWIYY3G_NeIEgC5A_tN-O_ySSp005n1oU3dy39KjeFCxAdS4-j3_1QU6kqnOgjVsDDxz4VOfbvuwaWUqaoKZMrnLWs1i-F-xik4gluczzimOKUst0KKIfNM_Y2hLdRS15ZCntH7MP0DZmyx0guxUCD8WseMhD7wOUbnEk1OMMQNKndkyZYniVQdV1FR8MXZ91hcQcWUqQuFPQ"/>
<div class="absolute inset-0 flex items-center justify-center">
<div class="w-4 h-4 bg-primary rounded-full shadow-[0_0_0_8px_rgba(0,72,141,0.2)]"></div>
</div>
</div>
</div>
<div class="bg-surface-container-high/30 p-8 rounded-xl">
<h4 class="monolithic-text text-xl font-bold mb-6">Inventory Summary</h4>
<div class="space-y-6">
<div>
<div class="flex justify-between text-xs font-bold uppercase tracking-widest text-secondary mb-2">
<span>Silic Sand Capacity</span>
<span>82%</span>
</div>
<div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary" style="width: 82%"></div>
</div>
</div>
<div>
<div class="flex justify-between text-xs font-bold uppercase tracking-widest text-secondary mb-2">
<span>Gravel Stocks</span>
<span>45%</span>
</div>
<div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-secondary" style="width: 45%"></div>
</div>
</div>
<div>
<div class="flex justify-between text-xs font-bold uppercase tracking-widest text-secondary mb-2">
<span>Crushed Stone</span>
<span>91%</span>
</div>
<div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary" style="width: 91%"></div>
</div>
</div>
</div>
<button class="mt-10 w-full border border-outline-variant py-3 rounded-md text-sm font-bold text-on-surface hover:bg-white transition-all">
                    Generate Inventory Audit
                </button>
</div>
</div>
</main>
<!-- Mobile Navigation -->
<nav class="md:hidden fixed bottom-0 left-0 w-full glass-overlay h-16 flex items-center justify-around px-4 z-50 border-t border-outline-variant/10">
<button class="flex flex-col items-center gap-1 text-slate-500">
<span class="material-symbols-outlined text-xl">dashboard</span>
<span class="text-[10px] font-bold uppercase">Overview</span>
</button>
<button class="flex flex-col items-center gap-1 text-primary">
<span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">storefront</span>
<span class="text-[10px] font-bold uppercase">Network</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-500">
<span class="material-symbols-outlined text-xl">monitoring</span>
<span class="text-[10px] font-bold uppercase">Stats</span>
</button>
<a href="{{ route('ProfilAdmin') }}" class="flex flex-col items-center gap-1 text-slate-500">
<span class="material-symbols-outlined text-xl">person</span>
<span class="text-[10px] font-bold uppercase">Admin</span>
</a>
</nav>
</body></html>