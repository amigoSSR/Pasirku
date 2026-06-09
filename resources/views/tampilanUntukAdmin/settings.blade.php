<x-layout-admin title="Pengaturan Admin">
    <div class="px-6 md:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-on-surface-variant mb-6">
            <a href="{{ route('MenuUtamaAdmin') }}" class="hover:text-primary transition-colors">Dashboard</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="font-bold text-on-surface">Settings</span>
        </nav>

        <header class="mb-8">
            <h1 class="text-2xl md:text-3xl font-headline font-extrabold text-on-surface dark:text-zinc-100 tracking-tight">Pengaturan</h1>
            <p class="text-on-surface-variant dark:text-zinc-400 text-sm mt-1.5">Kelola preferensi administrator dan tampilan sistem.</p>
        </header>

        <div class="max-w-3xl space-y-6">
            {{-- Appearance Section --}}
            <section class="bg-surface-container-lowest dark:bg-zinc-900 rounded-2xl p-6 border border-outline-variant/30 dark:border-zinc-800 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-primary/10 dark:bg-primary/20 rounded-xl flex items-center justify-center text-primary dark:text-primary-fixed">
                        <span class="material-symbols-outlined text-[22px]" style="font-variation-settings:'FILL' 1">palette</span>
                    </div>
                    <div>
                        <h2 class="font-headline font-bold text-on-surface dark:text-zinc-100">Tampilan</h2>
                        <p class="text-on-surface-variant dark:text-zinc-400 text-xs">Sesuaikan visual antarmuka sistem.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Dark Mode Toggle --}}
                    <div class="flex items-center justify-between p-4 rounded-xl bg-surface-container-low dark:bg-zinc-800/50 border border-transparent hover:border-outline-variant/20 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container-highest dark:bg-zinc-800 text-on-surface dark:text-zinc-300">
                                <span class="material-symbols-outlined" x-show="!darkMode">light_mode</span>
                                <span class="material-symbols-outlined" x-show="darkMode" x-cloak>dark_mode</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-surface dark:text-zinc-200">Mode Gelap</p>
                                <p class="text-[11px] text-on-surface-variant dark:text-zinc-400">Gunakan tampilan bertema gelap untuk mengurangi kelelahan mata.</p>
                            </div>
                        </div>
                        
                        {{-- Toggle Switch --}}
                        <button 
                            @click="darkMode = !darkMode"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
                            :class="darkMode ? 'bg-primary' : 'bg-surface-container-highest dark:bg-zinc-700'"
                        >
                            <span
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                :class="darkMode ? 'translate-x-6' : 'translate-x-1'"
                            ></span>
                        </button>
                    </div>
                </div>
            </section>

            {{-- Logout Section --}}
            <section class="bg-surface-container-lowest dark:bg-zinc-900 rounded-2xl p-6 border border-outline-variant/30 dark:border-zinc-800 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-error/10 dark:bg-error/20 rounded-xl flex items-center justify-center text-error">
                        <span class="material-symbols-outlined text-[22px]">logout</span>
                    </div>
                    <div>
                        <h2 class="font-headline font-bold text-on-surface dark:text-zinc-100">Keamanan</h2>
                        <p class="text-on-surface-variant dark:text-zinc-400 text-xs">Kelola akses administrator Anda.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <form method="POST" action="{{ route('profil.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-between p-4 rounded-xl bg-error/5 hover:bg-error/10 transition-all border border-transparent">
                            <div class="flex items-center gap-4">
                                <p class="text-sm font-bold text-error">Keluar dari Akun</p>
                            </div>
                            <span class="material-symbols-outlined text-error">chevron_right</span>
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-layout-admin>
