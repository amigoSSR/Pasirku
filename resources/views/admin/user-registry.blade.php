<x-layout-admin title="Daftar Pengguna">
    <div class="px-6 md:px-8 pb-24 md:pb-10 max-w-[1400px] mx-auto space-y-8">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-black text-primary uppercase tracking-[0.2em] flex items-center gap-1.5 mb-1">
                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings:'FILL' 1">group</span>
                    Manajemen Pengguna
                </span>
                <h1 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Daftar Pengguna</h1>
                <p class="text-sm text-on-surface-variant mt-1">Kelola data seluruh pengguna yang terdaftar di platform.</p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/20 overflow-hidden">
            <div class="px-6 py-5 border-b border-outline-variant/20 flex items-center justify-between">
                <h2 class="font-headline font-bold text-on-surface text-lg">Semua Pengguna</h2>
                <span class="text-xs text-on-surface-variant font-bold">{{ $users->count() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-outline-variant/20 bg-surface-container-low/50">
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">User</th>
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Kontak</th>
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Role</th>
                            <th class="px-6 py-3.5 text-xs font-bold uppercase tracking-wider text-on-surface-variant">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($users as $user)
                        <tr class="hover:bg-surface-container-low/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary font-bold text-xs flex items-center justify-center uppercase shrink-0">
                                        {{ strtoupper(substr($user->Username, 0, 2)) }}
                                    </div>
                                    <p class="font-semibold text-on-surface">{{ $user->Username }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs text-on-surface">{{ $user->Email }}</p>
                                <p class="text-xs text-on-surface-variant">{{ $user->Nomer_Telepon }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase 
                                    {{ $user->Role === 'admin' ? 'bg-primary/10 text-primary' : ($user->Role === 'store' ? 'bg-secondary/10 text-secondary' : 'bg-surface-container-high text-on-surface-variant') }}">
                                    {{ $user->Role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-on-surface-variant">
                                {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant text-sm">Belum ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout-admin>
