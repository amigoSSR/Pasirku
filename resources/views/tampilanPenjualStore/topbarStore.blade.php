<!-- TopNavBar (Shared Component for Store) -->
<header
  class="bg-surface dark:bg-zinc-900 fixed top-0 w-full h-[60px] border-b border-outline-variant dark:border-zinc-800 z-[100] transition-colors duration-300 flex justify-center shadow-sm">
  <div class="flex justify-between items-center w-full px-6 max-w-full">
    
    <!-- Brand / Logo -->
    <div class="flex items-center w-64 shrink-0">
      <img src="{{ asset('img/LogoWebsite.png') }}" alt="Pasirku" class="h-8 w-auto" />
    </div>

    <!-- Center & Right Side: Search and Profile -->
    <div class="flex items-center justify-between flex-1 gap-4 pl-4">
      
      <!-- Search Input -->
      <div class="hidden sm:flex relative w-full max-w-md">
        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant dark:text-zinc-400 text-[20px]"
          data-icon="search">search</span>
        <input
          id="search-input"
          class="w-full bg-surface-container-low dark:bg-zinc-800 border-none rounded-lg pl-10 pr-4 py-2 text-body-md text-on-surface dark:text-zinc-200 placeholder:dark:text-zinc-500 focus:ring-2 focus:ring-primary/20 transition-all"
          placeholder="Cari pesanan, material, atau toko..." type="text" autocomplete="off" />
      </div>

      <!-- Spacer for mobile if search is hidden -->
      <div class="sm:hidden flex-1"></div>

      <!-- Actions & Profile -->
      <div class="flex items-center gap-2">
        <button class="relative text-on-surface-variant dark:text-zinc-400 hover:bg-surface-container-high dark:hover:bg-zinc-800 p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
          <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full border border-surface dark:border-zinc-900"></span>
        </button>
        
        <a href="{{ route('PesanStore') }}" class="relative text-on-surface-variant dark:text-zinc-400 hover:bg-surface-container-high dark:hover:bg-zinc-800 p-2 rounded-full transition-colors">
          <span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
        </a>

        <a href="{{ route('ProfilStore') }}" class="flex items-center gap-2 ml-2 cursor-pointer hover:bg-surface-container-high dark:hover:bg-zinc-800 p-1 pr-3 rounded-full transition-colors">
          <img alt="User profile photo" class="w-8 h-8 rounded-full object-cover border border-outline-variant/30 dark:border-zinc-700"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCpBHj5IV2Kn3qm24UVsbcdYBYQ89XXfIj4YbvJKRLj6WLp8H4Q9ZVekGNFKZ2mwLQsDcn1OvQtqY4jNHVI93cihWqIsObwhQnAiTdtzu5A0WdbcexbKokX7JXWiplAzj1I6vFnPQJwdk0t8ogkH3hL9BhLYezo57n8tqRFVw9fTUW7umYAx-9XYNzsjHt6ai42pUtB71acUJ9pBjK4qW7plGWOx3tuinjqVZbbLMoKQaDk1Qnd7VhIgGYmoeFMdYk6EguMZpY7Nw" />
          <span class="hidden md:block font-label-md text-on-surface-variant dark:text-zinc-300">Profile</span>
        </a>
      </div>
      
    </div>
  </div>
</header>
