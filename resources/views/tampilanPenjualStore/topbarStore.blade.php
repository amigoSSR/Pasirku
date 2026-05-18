<!-- TopNavBar (Shared Component for Store) -->
<header
  class="bg-surface fixed top-0 w-full h-[60px] border-b border-outline-variant z-[100] transition-transform duration-150 flex justify-center">
  <div class="flex justify-between items-center w-full px-6 max-w-full">
    
    <!-- Brand / Logo -->
    <div class="flex items-center w-64 shrink-0">
      <span class="font-headline-md text-xl font-bold text-primary uppercase tracking-tighter">Pasir Ku</span>
    </div>

    <!-- Center & Right Side: Search and Profile -->
    <div class="flex items-center justify-between flex-1 gap-4 pl-4">
      
      <!-- Search Input -->
      <div class="hidden sm:flex relative w-full max-w-md">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]"
          data-icon="search">search</span>
        <input
          id="search-input"
          class="w-full bg-surface-container-low border-none rounded-lg pl-10 pr-4 py-2 text-body-md focus:ring-2 focus:ring-primary/20 transition-all"
          placeholder="Cari pesanan, material, atau toko..." type="text" autocomplete="off" />
      </div>

      <!-- Spacer for mobile if search is hidden -->
      <div class="sm:hidden flex-1"></div>

      <!-- Actions & Profile -->
      <div class="flex items-center gap-2">
        <button class="relative text-on-surface-variant hover:bg-surface-container-high p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
          <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span>
        </button>
        
        <a href="{{ route('PesanStore') }}" class="relative text-on-surface-variant hover:bg-surface-container-high p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
        </a>

        <a href="{{ route('ProfilStore') }}" class="flex items-center gap-2 ml-2 cursor-pointer hover:bg-surface-container-high p-1 pr-3 rounded-full transition-colors">
          <img alt="User profile photo" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpBHj5IV2Kn3qm24UVsbcdYBYQ89XXfIj4YbvJKRLj6WLp8H4Q9ZVekGNFKZ2mwLQsDcn1OvQtqY4jNHVI93cihWqIsObwhQnAiTdtzu5A0WdbcexbKokX7JXWiplAzj1I6vFnPQJwdk0t8ogkH3hL9BhLYezo57n8tqRFVw9fTUW7umYAx-9XYNzsjHt6ai42pUtB71acUJ9pBjK4qW7plGWOx3tuinjqVZbbLMoKQaDk1Qnd7VhIgGYmoeFMdYk6EguMZpY7Nw" />
          <span class="hidden md:block font-label-md text-on-surface-variant">Profile</span>
        </a>
      </div>
      
    </div>
  </div>
</header>
