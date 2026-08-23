@extends('layouts.petugas')

@section('title', 'Pemantauan Peminjaman')

@section('header')
    <style>
        .ledger-scope {
            --parchment: #F1E7D0;
            --parchment-dark: #E4D5B0;
            --ink: #2E2118;
            --ink-soft: #5B4A3A;
            --brass: #A9803E;
            --brass-light: #C9A768;
            --sage: #52654A;
            --ochre: #A9762E;
            --brick: #8C3B31;
            --navy: #33465A;
        }
        .ledger-scope .font-display { font-family: 'Playfair Display', Georgia, serif; }
        .ledger-scope .font-stamp   { font-family: 'Special Elite', 'Courier New', monospace; }
        .ledger-scope .font-data    { font-family: 'Courier Prime', 'Courier New', monospace; }

        .ledger-scope .paper-texture {
            background-color: var(--parchment);
            background-image:
                repeating-linear-gradient(0deg, rgba(46,33,24,0.035) 0px, rgba(46,33,24,0.035) 1px, transparent 1px, transparent 34px),
                radial-gradient(circle at 15% 10%, rgba(169,128,62,0.08), transparent 45%),
                radial-gradient(circle at 85% 90%, rgba(140,59,49,0.06), transparent 45%);
        }

        .ledger-scope .punch-holes span {
            display: block;
            width: 11px;
            height: 11px;
            border-radius: 9999px;
            background: var(--parchment);
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.45), 0 1px 0 rgba(255,255,255,0.4);
        }

        .ledger-scope .stamp-badge {
            font-family: 'Special Elite', 'Courier New', monospace;
            border-style: double;
            border-width: 4px;
            letter-spacing: 0.12em;
            position: relative;
            mix-blend-mode: multiply;
        }
        .ledger-scope .stamp-badge::after {
            content: '';
            position: absolute;
            inset: -3px;
            border: 1px solid currentColor;
            opacity: 0.25;
            pointer-events: none;
        }

        .ledger-scope .row-dashed {
            border-bottom: 1px dashed rgba(46,33,24,0.25);
        }

        .ledger-scope .brass-corner {
            position: relative;
        }
        .ledger-scope .brass-corner::before,
        .ledger-scope .brass-corner::after {
            content: '';
            position: absolute;
            width: 14px;
            height: 14px;
            border: 2px solid var(--brass);
            opacity: 0.8;
        }
        .ledger-scope .brass-corner::before { top: -1px; left: -1px; border-right: none; border-bottom: none; }
        .ledger-scope .brass-corner::after  { bottom: -1px; right: -1px; border-left: none; border-top: none; }
    </style>

    <div class="light-monitor">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 mb-1">Buku Registrasi &middot; Bag. Peralatan</p>
                <h2 class="font-extrabold text-2xl sm:text-3xl tracking-tight monitor-title">
                    Pemantauan Peminjaman
                </h2>
                <p class="text-sm mt-1.5 monitor-muted">
                    Catatan pengajuan &amp; pengembalian peralatan
                </p>
            </div>
            <div class="inline-flex items-center gap-2 px-4 py-2 w-fit rounded-xl bg-indigo-50 border border-indigo-100">
                <span class="w-1.5 h-1.5 rounded-full" style="background:#4f46e5"></span>
                <span class="text-xs font-semibold tracking-wide text-indigo-700">
                    No. Entri &mdash; {{ str_pad($peminjamans->count(), 3, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="light-monitor space-y-6">

        <!-- Ledger Card -->
        <div class="monitor-card relative rounded-2xl overflow-hidden">

            <!-- Punch holes -->
            <div class="hidden sm:flex flex-col justify-around absolute left-2 top-6 bottom-6 gap-6 z-10 opacity-30">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
            </div>

            <div class="overflow-x-auto sm:pl-8">
                <table class="w-full text-left text-sm">
                    <thead class="monitor-table-head text-xs font-semibold uppercase tracking-wider">
                        <tr class="border-b border-slate-200">
                            <th scope="col" class="py-4 px-4 font-semibold">No.</th>
                            <th scope="col" class="py-4 px-4 font-semibold">Kode Peminjaman</th>
                            <th scope="col" class="py-4 px-4 font-semibold">Status</th>
                            <th scope="col" class="py-4 px-4 font-semibold text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $peminjaman)
                            @php
                                $statusKey = strtolower($peminjaman->status);
                                [$dot, $ink] = match($statusKey) {
                                    'disetujui', 'selesai' => ['#52654A', '#3F4E38'],
                                    'menunggu', 'pending'  => ['#A9762E', '#8A5F22'],
                                    'ditolak', 'batal'     => ['#8C3B31', '#712D25'],
                                    default                => ['#33465A', '#293849'],
                                };
                                $tilt = $loop->even ? '-rotate-1' : 'rotate-1';
                            @endphp
                            <tr class="monitor-row hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-4 text-xs font-medium text-slate-500">
                                    №&nbsp;{{ str_pad($peminjaman->id, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-4 px-4 font-mono font-semibold tracking-wide text-slate-800">
                                    {{ $peminjaman->kode_peminjaman }}
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] uppercase font-semibold {{ $tilt }}"
                                          style="color: {{ $ink }}; border-color: {{ $ink }}; background: rgba(255,255,255,.7);">
                                        {{ $peminjaman->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <a href="{{ route('petugas.peminjaman.show', $peminjaman->id) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold border border-slate-200 rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-all hover:-translate-y-0.5 shadow-sm">

                                        <svg class="w-3.5 h-3.5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                    c4.478 0 8.268 2.943 9.542 7
                                                    -1.274 4.057-5.064 7-9.542 7
                                                    -4.477 0-8.268-2.943-9.542-7z" />

                                        </svg>

                                        Lihat Berkas

                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center">
                                    <svg class="mx-auto h-9 w-9 mb-3 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-base font-semibold italic text-slate-600">Belum ada catatan dalam buku ini</p>
                                    <p class="text-xs uppercase tracking-widest mt-1 text-indigo-500">Halaman masih kosong</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer strip -->
            <div class="monitor-footer px-4 sm:px-8 py-3 flex items-center justify-between">
                <span class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Diarsipkan &middot; Bag. Sarana</span>
                <span class="text-[10px] font-mono text-slate-500">{{ now()->format('d.m.Y') }}</span>
            </div>
        </div>

    </div>
@endsection