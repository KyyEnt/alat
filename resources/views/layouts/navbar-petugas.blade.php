<div x-data="{ open: false, sidebarProfile: false, mobileProfile: false }">

    @php
        $pendingCount = \App\Models\Peminjaman::where('status', 'Menunggu')->count();
    @endphp

    {{-- ============================= --}}
    {{-- DESKTOP — VERTICAL SIDEBAR    --}}
    {{-- ============================= --}}
    <aside class="hidden md:flex md:flex-col md:fixed md:inset-y-0 md:left-0 md:w-72 md:z-40
                  bg-slate-950/95 backdrop-blur-xl border-r border-slate-800/80">

        <!-- Brand crest -->
        <a href="{{ route('petugas.index') }}" class="flex items-center gap-3 px-5 py-5 group">
            <div class="relative flex items-center justify-center w-10 h-10 rounded-sm shrink-0"
                 style="background: linear-gradient(160deg, #C9A768, #8A6A2E); box-shadow: 0 0 0 1px rgba(217,188,133,0.4), 0 8px 20px -6px rgba(169,128,62,0.5);">
                <svg class="w-5 h-5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="leading-tight">
                <span class="block text-lg font-bold tracking-wide text-slate-100" style="font-family:'Playfair Display',Georgia,serif;">SiAlatKu</span>
                <span class="block text-[10px] font-medium tracking-[0.25em] uppercase mt-0.5" style="color:#C9A768; font-family:'Special Elite','Courier New',monospace;">Panel Petugas</span>
            </div>
        </a>

        <div class="mx-5 border-b border-dashed" style="border-color:rgba(217,188,133,0.25)"></div>

        <!-- Nav links -->
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
            <p class="px-3 mb-2 text-[10px] font-medium tracking-[0.25em] uppercase" style="color:#7C6A4E; font-family:'Special Elite','Courier New',monospace;">Menu Utama</p>

            @php
                $navActive = 'relative flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm font-medium border-l-2 transition-all duration-200';
            @endphp

            <a href="{{ route('petugas.persetujuan') }}"
               class="{{ $navActive }} {{ request()->routeIs('petugas.persetujuan') || request()->routeIs('petugas.index')
                    ? 'bg-slate-900/70 text-slate-100'
                    : 'text-slate-400 hover:bg-slate-900/40 hover:text-slate-200 border-transparent' }}"
               @if(request()->routeIs('petugas.persetujuan') || request()->routeIs('petugas.index')) style="border-color:#C9A768;" @endif>
                <svg class="w-4 h-4 shrink-0" style="color:#C9A768" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="flex-1">Persetujuan</span>
                @if($pendingCount > 0)
                    <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1 text-[10px] font-bold rounded-full text-slate-950"
                          style="background:#C9A768; font-family:'Courier Prime',monospace;">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <a href="{{ route('petugas.pemantauan') }}"
               class="{{ $navActive }} {{ request()->routeIs('petugas.pemantauan')
                    ? 'bg-slate-900/70 text-slate-100'
                    : 'text-slate-400 hover:bg-slate-900/40 hover:text-slate-200 border-transparent' }}"
               @if(request()->routeIs('petugas.pemantauan')) style="border-color:#C9A768;" @endif>
                <svg class="w-4 h-4 shrink-0" style="color:#C9A768" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="flex-1">Pemantauan</span>
            </a>

            <a href="{{ route('petugas.laporan.cetak') }}" target="_blank"
               class="{{ $navActive }} text-slate-400 hover:bg-slate-900/40 hover:text-slate-200 border-transparent">
                <svg class="w-4 h-4 shrink-0" style="color:#C9A768" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span class="flex-1">Cetak Laporan</span>
            </a>
        </nav>

        <div class="mx-5 border-b border-dashed" style="border-color:rgba(217,188,133,0.25)"></div>

        <!-- Status + profile (bottom, dropdown opens upward) -->
        <div class="p-4 space-y-3">
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-sm border" style="background:rgba(217,188,133,0.05); border-color:rgba(217,188,133,0.25);">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background:#7FA06E"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2" style="background:#7FA06E"></span>
                </span>
                <span class="text-xs font-medium text-slate-300">Petugas Standby</span>
            </div>

            <div class="relative" @click.away="sidebarProfile = false">
                <div x-show="sidebarProfile"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute bottom-full left-0 right-0 mb-2 rounded-sm bg-slate-900/95 backdrop-blur-2xl border shadow-2xl py-2 text-slate-300"
                     style="border-color:rgba(217,188,133,0.3); display:none;">

                    <div class="px-4 py-2 border-b" style="border-color:rgba(217,188,133,0.2)">
                        <p class="text-[10px] font-medium uppercase tracking-widest" style="color:#7C6A4E">Login Sebagai</p>
                        <p class="text-sm font-bold text-white truncate mt-0.5">{{ Auth::user()->email ?? Auth::user()->username ?? '-' }}</p>
                    </div>

                    @if(Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-slate-800/60 hover:text-white transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Pengaturan Profil</span>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Keluar Sistem</span>
                        </button>
                    </form>
                </div>

                <button @click="sidebarProfile = !sidebarProfile"
                        class="w-full flex items-center gap-3 p-2 rounded-sm bg-slate-900/50 hover:bg-slate-900 transition-all border hover:border-slate-700 focus:outline-none"
                        style="border-color:rgba(217,188,133,0.2)">
                    <div class="w-8 h-8 rounded-sm flex items-center justify-center text-slate-950 font-bold text-xs shrink-0"
                         style="background:linear-gradient(160deg,#D9BC85,#A9803E);">
                        {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nama ?? 'P', 0, 1)) }}
                    </div>
                    <div class="text-left flex-1 min-w-0">
                        <span class="block text-xs font-semibold text-slate-200 leading-tight truncate">{{ Auth::user()->name ?? Auth::user()->nama ?? 'Petugas' }}</span>
                        <span class="block text-[10px] text-slate-500">Petugas Lab</span>
                    </div>
                    <svg class="w-4 h-4 text-slate-500 transition-transform duration-200 shrink-0" :class="{'rotate-180': sidebarProfile}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    {{-- ============================= --}}
    {{-- MOBILE — TOP BAR + DRAWER     --}}
    {{-- ============================= --}}
    <nav class="md:hidden sticky top-0 z-50 bg-slate-950/80 backdrop-blur-xl border-b border-slate-800/80 shadow-2xl">
        <div class="px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">

                <a href="{{ route('petugas.index') }}" class="flex items-center gap-2.5">
                    <div class="flex items-center justify-center w-9 h-9 rounded-sm"
                         style="background: linear-gradient(160deg, #C9A768, #8A6A2E);">
                        <svg class="w-4.5 h-4.5 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <span class="text-base font-bold text-slate-100" style="font-family:'Playfair Display',Georgia,serif;">SiAlatKu</span>
                </a>

                <button @click="open = !open" class="p-2 rounded-sm text-slate-400 hover:text-white hover:bg-slate-900 focus:outline-none transition-colors border border-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="bg-slate-950 border-b border-slate-800/80 px-4 pt-3 pb-6 space-y-2 shadow-2xl"
             style="display: none;">

            <a href="{{ route('petugas.persetujuan') }}" class="px-3 py-2.5 rounded-sm text-base font-medium text-slate-200 hover:bg-slate-900 flex justify-between items-center">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" style="color:#C9A768" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Persetujuan Peminjaman</span>
                </span>
                @if($pendingCount > 0)
                    <span class="px-2.5 py-0.5 text-xs font-bold text-slate-950 rounded-full" style="background:#C9A768">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('petugas.pemantauan') }}" class="px-3 py-2.5 rounded-sm text-base font-medium text-slate-200 hover:bg-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5" style="color:#C9A768" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Pemantauan Pengembalian</span>
            </a>

            <a href="{{ route('petugas.laporan.cetak') }}" target="_blank" class="px-3 py-2.5 rounded-sm text-base font-medium text-slate-200 hover:bg-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5" style="color:#C9A768" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak Laporan</span>
            </a>

            <div class="pt-4 mt-2 border-t" style="border-color:rgba(217,188,133,0.2)">
                <div class="flex items-center px-3 mb-3">
                    <div class="w-9 h-9 rounded-sm flex items-center justify-center text-slate-950 font-bold mr-3"
                         style="background:linear-gradient(160deg,#D9BC85,#A9803E);">
                        {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nama ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-base font-medium text-white">{{ Auth::user()->name ?? Auth::user()->nama ?? 'Petugas' }}</div>
                        <div class="text-xs text-slate-400">{{ Auth::user()->email ?? Auth::user()->username ?? '-' }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2.5 text-base font-medium text-rose-400 hover:bg-rose-500/10 rounded-sm transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
</div>