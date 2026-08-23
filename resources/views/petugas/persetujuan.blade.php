@extends('layouts.petugas')

@section('title', 'Persetujuan Peminjaman')

@section('header')
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 w-full">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-mono font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 uppercase tracking-wider">
                    Panel Petugas
                </span>
                <span class="text-xs text-slate-400 font-mono">•</span>
                <span class="text-xs text-slate-400 font-mono">Persetujuan Real-time</span>
            </div>
            <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight mt-1">
                Persetujuan Peminjaman Alat
            </h2>
            <p class="text-xs sm:text-sm text-slate-400 mt-0.5">
                Kelola, verifikasi, dan tinjau pengajuan peminjaman barang dari pengguna secara digital.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('petugas.pemantauan') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 text-xs font-semibold transition-all duration-200 shadow-md hover:border-slate-600">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span>Pemantauan Status</span>
            </a>

            <a href="{{ route('petugas.laporan.cetak') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-slate-900 text-xs font-semibold transition-all duration-200 shadow-lg shadow-indigo-600/25 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                <span>Cetak Laporan</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div x-data="{ 
            search: '', 
            showRejectModal: false, 
            rejectUrl: '', 
            rejectItemName: '',
            openRejectModal(url, name) {
                this.rejectUrl = url;
                this.rejectItemName = name;
                this.showRejectModal = true;
            }
         }" 
         class="space-y-6">

        <!-- Flash Alert Success -->
        @if(session('success'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-transition
                 class="flex items-center justify-between p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 shadow-lg backdrop-blur-md">
                <div class="flex items-center space-x-3">
                    <div class="p-1.5 rounded-lg bg-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-200 p-1 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Flash Alert Error -->
        @if(session('error'))
            <div x-data="{ show: true }" 
                 x-show="show" 
                 x-transition
                 class="flex items-center justify-between p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 shadow-lg backdrop-blur-md">
                <div class="flex items-center space-x-3">
                    <div class="p-1.5 rounded-lg bg-rose-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-400 hover:text-rose-200 p-1 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Statistik Ringkas & Search Toolbar -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Stat 1: Antrean -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between shadow-lg backdrop-blur-md">
                <div>
                    <p class="text-xs text-slate-400 font-medium">Menunggu Persetujuan</p>
                    <h3 class="text-2xl font-bold font-mono text-amber-400 mt-1">{{ $peminjamans->count() }}</h3>
                </div>
                <div class="p-3 bg-amber-500/10 border border-amber-500/20 rounded-xl text-amber-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Stat 2: Notifikasi Stok Aman -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between shadow-lg backdrop-blur-md">
                <div>
                    <p class="text-xs text-slate-400 font-medium">Pengajuan Stok Tersedia</p>
                    <h3 class="text-2xl font-bold font-mono text-emerald-400 mt-1">
                        {{ $peminjamans->filter(fn($item) => ($item->alat->stok ?? 0) > 0)->count() }}
                    </h3>
                </div>
                <div class="p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Stat 3: Alert Stok Habis -->
            <div class="bg-white border border-slate-200 rounded-xl p-4 flex items-center justify-between shadow-lg backdrop-blur-md">
                <div>
                    <p class="text-xs text-slate-400 font-medium">Terhalang Stok Habis</p>
                    <h3 class="text-2xl font-bold font-mono text-rose-400 mt-1">
                        {{ $peminjamans->filter(fn($item) => ($item->alat->stok ?? 0) <= 0)->count() }}
                    </h3>
                </div>
                <div class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Live Search Filter Input -->
        <div class="bg-white border border-slate-200 p-4 rounded-xl flex items-center justify-between backdrop-blur-md">
            <div class="relative w-full max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input x-model="search" type="text" placeholder="Cari nama peminjam, barang, atau kode..." 
                       class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <span class="text-xs font-mono text-slate-400 hidden sm:inline-block">
                Menampilkan <span class="text-indigo-400 font-bold">{{ $peminjamans->count() }}</span> entri
            </span>
        </div>

        <!-- Main Table Container -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden backdrop-blur-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-mono font-semibold text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">Peminjam</th>
                            <th class="py-4 px-6">Alat / Barang</th>
                            <th class="py-4 px-6 text-center">Ketersediaan</th>
                            <th class="py-4 px-6">Waktu Pengajuan</th>
                            <th class="py-4 px-6 text-center">Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($peminjamans as $key => $item)
                            @php
                                $userName = $item->user->name ?? $item->user->nama ?? 'Peminjam';
                                $alatName = $item->alat->nama_alat ?? 'Alat';
                                $searchTarget = strtolower($userName . ' ' . $alatName . ' ' . ($item->kode_peminjaman ?? ''));
                            @endphp
                            <tr x-show="!search || '{{ $searchTarget }}'.includes(search.toLowerCase())" 
                                class="hover:bg-slate-100/40 transition-colors duration-150">
                                
                                <!-- No -->
                                <td class="py-4 px-6 text-center font-mono text-xs text-slate-400">
                                    {{ $key + 1 }}
                                </td>

                                <!-- Peminjam -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-300 flex items-center justify-center text-xs font-bold font-mono text-indigo-400 shrink-0 shadow-inner">
                                            {{ strtoupper(substr($userName, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">{{ $userName }}</div>
                                            <div class="text-xs text-slate-400 font-mono">{{ $item->kode_peminjaman ?? 'NO-CODE' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Alat -->
                                <td class="py-4 px-6">
                                    <span class="font-medium text-slate-700 block">{{ $alatName }}</span>
                                    <span class="text-xs text-slate-400">Jumlah: {{ $item->jumlah_pinjam ?? 1 }} unit</span>
                                </td>

                                <!-- Sisa Stok -->
                                <td class="py-4 px-6 text-center">
                                    @php $stok = $item->alat->stok ?? 0; @endphp
                                    @if($stok > 0)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Tersedia ({{ $stok }})
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Stok Habis
                                        </span>
                                    @endif
                                </td>

                                <!-- Waktu -->
                                <td class="py-4 px-6 font-mono text-xs text-slate-400">
                                    <div>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</div>
                                    <div class="text-slate-400">{{ $item->created_at ? $item->created_at->format('H:i') : '' }} WIB</div>
                                </td>

                                <!-- Aksis -->
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        
                                        <!-- Form Setujui -->
                                        <form action="{{ route('petugas.persetujuan.proses', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Disetujui">
                                            <button type="submit" 
                                                    @if($stok <= 0) disabled @endif
                                                    onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI peminjaman {{ $alatName }} untuk {{ $userName }}?')"
                                                    class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-400 border border-emerald-500/30 text-xs font-semibold transition-all duration-150 disabled:opacity-40 disabled:cursor-not-allowed">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>

                                        <!-- Form Tolak (Via Modal Trigger) -->
                                        <button type="button" 
                                                @click="openRejectModal('{{ route('petugas.persetujuan.proses', $item->id) }}', '{{ $alatName }} oleh {{ $userName }}')"
                                                class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-rose-600/20 hover:bg-rose-600/30 text-rose-400 border border-rose-500/30 text-xs font-semibold transition-all duration-150">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Tolak</span>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="p-3 bg-slate-100 rounded-full border border-slate-200">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-400">Tidak ada pengajuan peminjaman yang menunggu keputusan.</p>
                                        <p class="text-xs text-slate-400">Seluruh pengajuan telah diproses atau belum ada pengajuan baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Optional Pagination Footer -->
            @if(method_exists($peminjamans, 'hasPages') && $peminjamans->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $peminjamans->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Alasan Penolakan -->
        <div x-show="showRejectModal" 
             x-transition 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-50 backdrop-blur-sm"
             style="display: none;">
            
            <div @click.away="showRejectModal = false" class="bg-white border border-slate-200 rounded-2xl w-full max-w-md p-6 shadow-2xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="text-lg font-bold text-slate-900">Tolak Pengajuan Peminjaman</h3>
                    <button @click="showRejectModal = false" class="text-slate-400 hover:text-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <p class="text-xs text-slate-400">
                    Anda akan menolak pengajuan untuk <span x-text="rejectItemName" class="font-semibold text-slate-700"></span>.
                </p>

                <form :action="rejectUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Ditolak">
                    
                    <div>
                        <label class="block text-xs font-mono text-slate-400 mb-1">Catatan / Alasan Penolakan (Opsional)</label>
                        <textarea name="catatan" rows="3" 
                                  placeholder="Contoh: Stok alat sedang dalam perbaikan / Kurang persyaratan..." 
                                  class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-xs text-slate-700 focus:outline-none focus:border-rose-500 transition-colors"></textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-2">
                        <button type="button" @click="showRejectModal = false" 
                                class="px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-700 text-xs font-semibold">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-lg bg-rose-600 hover:bg-rose-500 text-slate-900 text-xs font-semibold shadow-lg shadow-rose-600/30">
                            Konfirmasi Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection