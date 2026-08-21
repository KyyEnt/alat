@extends('layouts.petugas')

@section('title', 'Pemantauan Peminjaman')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="font-bold text-xl text-slate-100 tracking-tight">
                Pemantauan Peminjaman
            </h2>
            <p class="text-xs text-slate-400 mt-1">
                Kelola dan pantau seluruh status pengajuan serta pengembalian alat.
            </p>
        </div>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-800/80 border border-slate-700/60 rounded-lg text-xs font-mono text-slate-300 w-fit">
            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
            Total Data: {{ $peminjamans->count() }}
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Card Container Utama -->
        <div class="bg-slate-900/80 border border-slate-800/80 rounded-xl shadow-xl overflow-hidden backdrop-blur-md">
            
            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/60 text-slate-400 font-mono text-xs uppercase tracking-wider border-b border-slate-800/80">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 font-semibold">ID</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Kode Peminjaman</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold">Status</th>
                            <th scope="col" class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($peminjamans as $peminjaman)
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-4 font-mono text-slate-400 text-xs">
                                    #{{ $peminjaman->id }}
                                </td>
                                <td class="py-4 px-4 font-mono font-medium text-indigo-400">
                                    {{ $peminjaman->kode_peminjaman }}
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $statusClass = match(strtolower($peminjaman->status)) {
                                            'disetujui', 'selesai' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                            'menunggu', 'pending'  => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                            'ditolak', 'batal'     => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                            default               => 'bg-slate-500/10 text-slate-400 border-slate-500/20',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border uppercase tracking-wider {{ $statusClass }}">
                                        {{ $peminjaman->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 border border-slate-700/80 rounded-md transition-all">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-500">
                                    <svg class="mx-auto h-8 w-8 text-slate-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm font-medium">Belum ada data peminjaman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection