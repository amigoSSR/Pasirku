<!-- TopNavBar (User Portal) — konsisten dengan topbarStore -->
<header
  class="bg-surface fixed top-0 w-full h-[60px] border-b border-outline-variant z-[100] transition-transform duration-150 flex justify-center">
  <div class="flex justify-between items-center w-full px-6 max-w-full">

    <!-- Brand / Logo -->
    <div class="flex items-center w-64 shrink-0">
      <a href="{{ route('MenuUtama') }}" class="font-headline text-xl font-bold text-primary uppercase tracking-tighter">Pasir Ku</a>
    </div>

    <!-- Center & Right Side: Search and Profile -->
    <div class="flex items-center justify-between flex-1 gap-4 pl-4">

      <!-- Search Input -->
      <div class="hidden sm:flex relative w-full max-w-md">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
        <input
          id="search-input"
          class="w-full bg-surface-container-low border-none rounded-lg pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary/20 transition-all"
          placeholder="Cari toko atau produk pasir..." type="text" autocomplete="off" />
      </div>

      <!-- Spacer for mobile if search is hidden -->
      <div class="sm:hidden flex-1"></div>

      <!-- Actions & Profile -->
      <div class="flex items-center gap-2">

        <!-- Cart Button -->
        <a href="{{ route('keranjang') }}" class="relative text-on-surface-variant hover:bg-surface-container-high p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined">shopping_cart</span>
        </a>

        <!-- Notifications -->
        <button class="relative text-on-surface-variant hover:bg-surface-container-high p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined">notifications</span>
          <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span>
        </button>

        <!-- Chat -->
        <a href="{{ route('Pesan') }}" class="relative text-on-surface-variant hover:bg-surface-container-high p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined">chat_bubble</span>
        </a>

        <!-- Profile Avatar -->
        <a href="{{ route('Profil') }}" class="flex items-center gap-2 ml-2 cursor-pointer hover:bg-surface-container-high p-1 pr-3 rounded-full transition-colors">
          <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm shrink-0">
            {{ strtoupper(substr(Auth::user()->Username ?? 'U', 0, 1)) }}
          </div>
          <span class="hidden md:block text-sm font-medium text-on-surface-variant">{{ Auth::user()->Username ?? 'Profile' }}</span>
        </a>
      </div>

    </div>
  </div>
</header>
