

@include('tampilanUntukAdmin.topbarAdmin')

<!-- Main Content Area -->
<main class="md:ml-72 flex-1 p-8 bg-surface overflow-y-auto transition-all duration-300 pt-24 min-h-screen">
<!-- Strata Grid: Profile Header -->
<section class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12 items-end">
<div class="md:col-span-4 aspect-square bg-surface-container-low rounded-xl overflow-hidden shadow-sm">
<img alt="Profile" class="w-full h-full object-cover" data-alt="close-up studio portrait of a professional man in his 40s with a confident smile, wearing a dark navy polo shirt" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5PQtLotEWu5Gayn3BYAklIw_RIGZZ9W4Va4b6CgPo1Vc63rl0AsarywWh0O9JeqvGNBy29ZhR37zpxw7Q0D0wegVj9ndr7ki257XmzjvsTQy7_qy8VSbS_MHwpnPd9RerrDoWwWtRWGEmvoYFpJ01SL9PYZ2WPsMMI4oMTZ00pq-oQqnM6jidyCFcHRED5qU1xDteSLy8EbgbL9ZKOPqKvdE0WJ7tcwp7m8eEKUnZVhCh7I8yJyvHQBnB1Qi_SRypz1rveyUHZQ"/>
</div>
<div class="md:col-span-8 pb-4">
<span class="font-label text-secondary uppercase tracking-widest text-sm mb-2 block">Account Overview</span>
<h1 class="font-headline text-5xl font-extrabold tracking-tighter text-on-surface mb-4">{{ Auth::user()->Username ?? 'Pengguna' }}</h1>
<div class="flex gap-4">
<div class="bg-surface-container-highest px-4 py-2 rounded-lg">
<p class="text-xs text-on-surface-variant font-medium uppercase">Total Orders</p>
<p class="text-xl font-headline font-bold text-primary">124</p>
</div>
<div class="bg-surface-container-highest px-4 py-2 rounded-lg">
<p class="text-xs text-on-surface-variant font-medium uppercase">Trust Score</p>
<p class="text-xl font-headline font-bold text-secondary">9.8</p>
</div>
</div>
</div>
</section>
<!-- Strata Grid: Profile Options Bento -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<!-- Chat (History) -->
<a class="group relative overflow-hidden bg-surface-container-lowest p-8 rounded-xl transition-all duration-300 hover:shadow-[0px_24px_48px_rgba(11,28,48,0.08)]" href="#">
<div class="flex justify-between items-start mb-12">
<div class="p-3 bg-blue-50 text-primary rounded-xl group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl">forum</span>
</div>
<span class="material-symbols-outlined text-slate-300">arrow_outward</span>
</div>
<h3 class="font-headline text-2xl font-bold text-on-surface mb-2">Chat</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">View your negotiation history and active inquiries with suppliers.</p>
</a>
<!-- Daftar sebagai Penjual -->
<a class="group relative overflow-hidden bg-primary text-white p-8 rounded-xl transition-all duration-300 hover:shadow-[0px_24px_48px_rgba(0,72,141,0.2)]" href="#">
<div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
<div class="flex justify-between items-start mb-12">
<div class="p-3 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined text-3xl">add_business</span>
</div>
</div>
<h3 class="font-headline text-2xl font-bold mb-2">Daftar sebagai Penjual</h3>
<p class="text-white/80 text-sm leading-relaxed">Expand your business reach. Register your quarry or logistics company today.</p>
</a>
<!-- Update Isi Toko -->
<a class="group relative overflow-hidden bg-surface-container-low p-8 rounded-xl transition-all duration-300 border-2 border-transparent hover:border-primary-container" href="#">
<div class="flex justify-between items-start mb-12">
<div class="p-3 bg-white text-secondary rounded-xl group-hover:rotate-12 transition-transform">
<span class="material-symbols-outlined text-3xl">inventory_2</span>
</div>
</div>
<h3 class="font-headline text-2xl font-bold text-on-surface mb-2">Update Isi Toko</h3>
<p class="text-on-surface-variant text-sm leading-relaxed">Manage your catalog, update pricing for sand, stone, and aggregates.</p>
</a>
<!-- Logout (Large Span) -->
<form method="POST" action="{{ route('profil.logout') }}" class="md:col-span-3">
    @csrf
    <button type="submit" class="w-full flex items-center justify-between bg-surface-container-lowest border-2 border-error/10 p-6 rounded-xl group hover:bg-error/5 transition-colors">
        <div class="flex items-center gap-4">
            <div class="p-2 bg-error/10 text-error rounded-lg">
                <span class="material-symbols-outlined">logout</span>
            </div>
            <div class="text-left">
                <span class="font-headline font-bold text-on-surface block">Logout</span>
                <span class="text-xs text-on-surface-variant">Securely end your session</span>
            </div>
        </div>
        <span class="material-symbols-outlined text-error opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
    </button>
</form>
</div>
<!-- Profile Details Section (Asymmetric) -->
</main>
<!-- BottomNavBar Shell (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-slate-50/80 backdrop-blur-xl shadow-[0px_-8px_24px_rgba(11,28,48,0.05)] rounded-t-xl">
<a class="flex flex-col items-center justify-center text-slate-500 px-6 py-1 hover:text-blue-700" href="#">
<span class="material-symbols-outlined">trolley</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Home</span>
</a>
<a class="flex flex-col items-center justify-center text-slate-500 px-6 py-1 hover:text-blue-700" href="#">
<span class="material-symbols-outlined">shopping_cart</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Cart</span>
</a>
<a class="flex flex-col items-center justify-center bg-blue-100 text-blue-900 rounded-xl px-6 py-1 active:scale-90 transition-all duration-200" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
<span class="text-[10px] font-bold uppercase tracking-wider mt-1">Profile</span>
</a>
</nav>
</body></html>