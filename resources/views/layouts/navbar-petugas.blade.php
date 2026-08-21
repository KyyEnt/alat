<nav x-data="{ open: false, profileDropdown: false }" 
     class="relative z-50 bg-slate-950/80 backdrop-blur-xl border-b border-slate-800/80 shadow-2xl transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Brand Logo & Main Links -->
            <div class="flex items-center space-x-8">
                <!-- Logo Brand -->
                <a href="{{ route('petugas.index') }}" class="flex items-center space-x-3 group">
                    <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-cyan-400 shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 group-hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 text-white transform group-hover:rotate-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold tracking-wider bg-gradient-to-r from-white via-slate-100 to-slate-400 bg-clip-text text-transparent">SiAlatKu</span>
                        <span class="block text-[10px] font-semibold tracking-widest text-indigo-400 uppercase -mt-0.5">Panel Petugas</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-1">
                    @php
                        $pendingCount = \App\Models\Peminjaman::where('status', 'Menunggu')->count();
                    @endphp

                    <!-- Persetujuan Link -->
                    <a href="{{ route('petugas.persetujuan') }}" 
                       class="relative px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 flex items-center space-x-2.5 group {{ request()->routeIs('petugas.persetujuan') || request()->routeIs('petugas.index') ? 'bg-indigo-500/10 text-indigo-300 border border-indigo-500/30 shadow-inner' : 'text-slate-300 hover:bg-slate-900 hover:text-white border border-transparent' }}">
                        <svg class="w-4 h-4 text-indigo-400 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Persetujuan</span>
                        
                        @if($pendingCount > 0)
                            <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-rose-500 rounded-full shadow-lg shadow-rose-500/50 animate-pulse">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Pemantauan Link -->
                    <a href="{{ route('petugas.pemantauan') }}" 
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 flex items-center space-x-2.5 group {{ request()->routeIs('petugas.pemantauan') ? 'bg-indigo-500/10 text-indigo-300 border border-indigo-500/30 shadow-inner' : 'text-slate-300 hover:bg-slate-900 hover:text-white border border-transparent' }}">
                        <svg class="w-4 h-4 text-cyan-400 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Pemantauan</span>
                    </a>

                    <!-- Cetak Laporan Link -->
                    <a href="{{ route('petugas.laporan.cetak') }}" target="_blank"
                       class="px-4 py-2 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-900 hover:text-white transition-all duration-200 flex items-center space-x-2.5 group border border-transparent hover:border-slate-800">
                        <svg class="w-4 h-4 text-emerald-400 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        <span>Cetak Laporan</span>
                    </a>
                </div>
            </div>

            <!-- Right Area: Duty Badge & Profile -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Status Badge -->
                <div class="flex items-center space-x-2 px-3 py-1.5 rounded-full bg-slate-900/90 border border-slate-800/80 text-xs text-slate-400 shadow-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="font-medium text-slate-300">Petugas Standby</span>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative" @click.away="profileDropdown = false">
                    <button @click="profileDropdown = !profileDropdown" 
                            class="flex items-center space-x-3 p-1.5 rounded-xl bg-slate-900/50 hover:bg-slate-900 transition-all duration-200 border border-slate-800/60 hover:border-slate-700 focus:outline-none">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-md">
                            {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nama ?? 'P', 0, 1)) }}
                        </div>
                        <div class="text-left hidden lg:block">
                            <span class="block text-xs font-semibold text-slate-200 leading-tight">{{ Auth::user()->name ?? Auth::user()->nama ?? 'Petugas' }}</span>
                            <span class="block text-[10px] text-slate-400">Petugas Lab</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': profileDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Floating Dropdown Menu -->
                    <div x-show="profileDropdown" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-2 w-56 rounded-2xl bg-slate-900/95 backdrop-blur-2xl border border-slate-800/90 shadow-2xl py-2 z-50 text-slate-300"
                         style="display: none;">
                        
                        <div class="px-4 py-2.5 border-b border-slate-800/80">
                            <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Login Sebagai</p>
                            <p class="text-sm font-bold text-white truncate mt-0.5">{{ Auth::user()->email ?? Auth::user()->username ?? '-' }}</p>
                        </div>

                        @if(Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2.5 px-4 py-2 text-sm hover:bg-slate-800/60 hover:text-white transition-colors">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Pengaturan Profil</span>
                            </a>
                            <div class="border-t border-slate-800/80 my-1"></div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-2.5 px-4 py-2 text-sm text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Keluar Sistem</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 focus:outline-none transition-colors border border-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden bg-slate-950 border-b border-slate-800/80 px-4 pt-3 pb-6 space-y-2 shadow-2xl"
         style="display: none;">
        
        <a href="{{ route('petugas.persetujuan') }}" class="px-3 py-2.5 rounded-xl text-base font-medium text-slate-200 hover:bg-slate-900 flex justify-between items-center">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Persetujuan Peminjaman</span>
            </span>
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="px-2.5 py-0.5 text-xs font-bold text-white bg-rose-500 rounded-full shadow-md shadow-rose-500/40">{{ $pendingCount }}</span>
            @endif
        </a>

        <a href="{{ route('petugas.pemantauan') }}" class="px-3 py-2.5 rounded-xl text-base font-medium text-slate-200 hover:bg-slate-900 flex items-center space-x-2">
            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            <span>Pemantauan Pengembalian</span>
        </a>

        <a href="{{ route('petugas.laporan.cetak') }}" target="_blank" class="px-3 py-2.5 rounded-xl text-base font-medium text-emerald-400 hover:bg-slate-900 flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            <span>Cetak Laporan</span>
        </a>

        <div class="pt-4 mt-2 border-t border-slate-800/80">
            <div class="flex items-center px-3 mb-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold mr-3 shadow-md">
                    {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nama ?? 'P', 0, 1)) }}
                </div>
                <div>
                    <div class="text-base font-medium text-white">{{ Auth::user()->name ?? Auth::user()->nama ?? 'Petugas' }}</div>
                    <div class="text-xs text-slate-400">{{ Auth::user()->email ?? Auth::user()->username ?? '-' }}</div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2.5 text-base font-medium text-rose-400 hover:bg-rose-500/10 rounded-xl transition-colors flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </div>
</nav>