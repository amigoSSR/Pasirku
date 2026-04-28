
<body class="bg-surface text-on-surface">

  @include('topbar')

  <main class="max-w-4xl mx-auto px-6 pt-24 pb-32">

    <!-- Hero Profile Section -->
    <section class="relative overflow-hidden rounded-xl bg-surface-container-low p-8 mb-8 flex flex-col md:flex-row items-center gap-8 shadow-sm">
      <div class="relative z-10 w-32 h-32 rounded-full overflow-hidden bg-surface-container-high ring-4 ring-white shadow-lg">
        <img alt="Guest User" class="w-full h-full object-cover"
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuBC7B34jIy7PFd-X_56HdgGJC0UAEY-CbQigZJAMMIKc752Kxqs-FSOEYrwA2dY3didkXrJeyTA1_25ucmJIAkP_j3oRYfnanCEzHVcX5FAXbFj9cNHxnpBMSwPJxYVHhwY1_MmvVVmgTw4G2LKz6UbwSMS-FOYdjE-5SIw9XBUDB2JuoMYxQ1OfzUfMTpl5VWUuPCrockvecnpoN9p6sEZbzjaNojH0qH7IDCgBnziHJDFfC59QIm1sGd7IY1nmbymGqVd5J52Aw" />
      </div>
      <div class="relative z-10 text-center md:text-left">
        <span class="inline-block px-3 py-1 bg-secondary-container text-on-secondary-container text-xs font-bold rounded-full mb-3 tracking-widest uppercase">Guest User</span>
        <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Welcome to Industrial Hub</h1>
        <p class="text-on-surface-variant max-w-md">Log in to your account to manage your materials, track shipments, and communicate with verified sellers.</p>
      </div>
      <!-- Aesthetic Monolith Background Element -->
      <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
    </section>

    <!-- Profile Actions: Strata Grid Style -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

      <!-- Primary Auth Column -->
      <div class="md:col-span-4 flex flex-col gap-6">
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm flex flex-col items-center text-center">
          <h3 class="font-headline font-bold text-lg mb-4 text-primary">Join the Network</h3>
          <p class="text-sm text-on-surface-variant mb-6">Access the largest marketplace for raw materials and quarry logistics.</p>
          <button class="w-full bg-gradient-to-br from-primary to-primary-container text-white font-bold py-4 rounded-xl hover:shadow-lg transition-all active:scale-95">
            Login
          </button>
          <button class="w-full mt-4 border-2 border-outline-variant text-on-surface font-semibold py-4 rounded-xl hover:bg-surface-container-low transition-colors">
            Sign Up
          </button>
        </div>
        <div class="bg-surface-container-low p-6 rounded-xl">
          <div class="flex items-center gap-3 text-secondary mb-2">
            <span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
            <span class="font-bold text-sm tracking-wide uppercase">Security Notice</span>
          </div>
          <p class="text-xs leading-relaxed text-on-surface-variant">Your transaction security is our priority. Always communicate via Pasir Ku to stay protected.</p>
        </div>
      </div>

      <!-- List Options Column -->
      <div class="md:col-span-8 flex flex-col gap-4">

        <!-- Communication Block -->
        <div class="group relative bg-surface-container-lowest p-6 rounded-xl flex items-center justify-between hover:bg-surface-container-low transition-all cursor-pointer border-l-4 border-transparent hover:border-primary">
          <div class="flex items-center gap-6">
            <div class="w-14 h-14 rounded-xl bg-surface-container-high flex items-center justify-center text-primary">
              <span class="material-symbols-outlined text-3xl" data-icon="chat_bubble">chat_bubble</span>
            </div>
            <div>
              <h4 class="font-headline font-bold text-on-surface">Chat</h4>
              <p class="text-sm text-on-surface-variant">Sign in to contact sellers and view messages</p>
            </div>
          </div>
          <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors" data-icon="chevron_right">chevron_right</span>
        </div>

        <!-- Seller Registration Block -->
        <div class="group relative bg-surface-container-lowest p-6 rounded-xl flex items-center justify-between hover:bg-surface-container-low transition-all cursor-pointer border-l-4 border-transparent hover:border-secondary">
          <div class="flex items-center gap-6">
            <div class="w-14 h-14 rounded-xl bg-secondary-container flex items-center justify-center text-on-secondary-container">
              <span class="material-symbols-outlined text-3xl" data-icon="storefront">storefront</span>
            </div>
            <div>
              <h4 class="font-headline font-bold text-on-surface">Daftar sebagai Penjual</h4>
              <p class="text-sm text-on-surface-variant">Start selling your materials to verified contractors</p>
            </div>
          </div>
          <span class="material-symbols-outlined text-outline-variant group-hover:text-secondary transition-colors" data-icon="chevron_right">chevron_right</span>
        </div>

        <!-- Seller Update Block (Locked) -->
        <div class="relative bg-surface-container-lowest p-6 rounded-xl flex items-center justify-between opacity-60 border-l-4 border-slate-300">
          <div class="flex items-center gap-6">
            <div class="w-14 h-14 rounded-xl bg-slate-200 flex items-center justify-center text-slate-500">
              <span class="material-symbols-outlined text-3xl" data-icon="inventory_2">inventory_2</span>
            </div>
            <div>
              <h4 class="font-headline font-bold text-slate-400">Update Isi Toko</h4>
              <p class="text-sm text-slate-400 italic">Seller access only</p>
            </div>
          </div>
          <span class="material-symbols-outlined text-slate-300" data-icon="lock">lock</span>
        </div>

        <!-- Support/Info Grid -->
        <div class="grid grid-cols-2 gap-4 mt-2">
          <div class="p-6 rounded-xl bg-surface-container-low flex flex-col gap-3 hover:bg-surface-container-high transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-primary" data-icon="help">help</span>
            <span class="font-bold text-sm text-on-surface">Pusat Bantuan</span>
          </div>
          <div class="p-6 rounded-xl bg-surface-container-low flex flex-col gap-3 hover:bg-surface-container-high transition-colors cursor-pointer">
            <span class="material-symbols-outlined text-primary" data-icon="policy">policy</span>
            <span class="font-bold text-sm text-on-surface">Syarat &amp; Ketentuan</span>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Bottom Navigation Bar (Mobile only) -->
  <nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-slate-50/80 backdrop-blur-xl shadow-[0px_-8px_24px_rgba(11,28,48,0.05)] rounded-t-xl">
    <a class="flex flex-col items-center justify-center text-slate-500 px-6 py-1" href="{{ route('home') }}">
      <span class="material-symbols-outlined" data-icon="trolley">trolley</span>
      <span class="text-[10px] font-medium tracking-wider mt-1 uppercase">Home</span>
    </a>
    <a class="flex flex-col items-center justify-center text-slate-500 px-6 py-1" href="#">
      <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>
      <span class="text-[10px] font-medium tracking-wider mt-1 uppercase">Cart</span>
    </a>
    <a class="flex flex-col items-center justify-center bg-blue-100 text-blue-900 rounded-xl px-6 py-1" href="">
      <span class="material-symbols-outlined" data-icon="person" style="font-variation-settings: 'FILL' 1;">person</span>
      <span class="text-[10px] font-bold tracking-wider mt-1 uppercase">Profile</span>
    </a>
  </nav>

  <!-- Footer (Desktop only) -->
  <footer class="hidden md:block py-12 bg-surface">
    <div class="max-w-7xl mx-auto px-6 border-t border-surface-container-high pt-12 flex justify-between items-center">
      <div class="text-sm text-on-surface-variant">
        © 2024 Pasir Ku. The Tectonic Standard in Materials.
      </div>
      <div class="flex gap-8 text-sm font-bold text-primary">
        <a class="hover:underline" href="#">Legal</a>
        <a class="hover:underline" href="#">API Docs</a>
        <a class="hover:underline" href="#">Fleet Logistics</a>
      </div>
    </div>
  </footer>

</body>
</html>