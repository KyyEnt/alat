@extends('layouts.petugas')

@section('title', 'Detail Peminjaman')

@section('header')

<div>
    <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 mb-1">
        Buku Registrasi · Bag. Peralatan
    </p>

    <h2 class="font-extrabold text-2xl sm:text-3xl tracking-tight">
        Detail Peminjaman
    </h2>

    <p class="text-sm mt-1.5 text-slate-500">
        Informasi lengkap pengajuan peminjaman
    </p>
</div>

@endsection


@section('content')

<div class="light-monitor space-y-6">

    <div class="monitor-card rounded-2xl overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">

            <div>
                <p class="text-xs uppercase tracking-wider text-slate-400">
                    Kode Peminjaman
                </p>

                <h3 class="text-xl font-bold text-slate-800">
                    {{ $peminjaman->kode_peminjaman }}
                </h3>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                {{ $peminjaman->status }}
            </span>

        </div>


        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        ID Peminjaman
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        #{{ str_pad($peminjaman->id, 3, '0', STR_PAD_LEFT) }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Status
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $peminjaman->status }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Dibuat
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $peminjaman->created_at?->format('d-m-Y H:i') }}
                    </p>
                </div>


                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Terakhir Diperbarui
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $peminjaman->updated_at?->format('d-m-Y H:i') }}
                    </p>
                </div>

            </div>


            {{-- BERKAS --}}

            <div class="mt-8 pt-6 border-t border-slate-200">

                <h3 class="text-lg font-bold text-slate-800 mb-4">
                    Berkas Peminjaman
                </h3>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">

                    @if($peminjaman->berkas)

                        <div class="flex items-center justify-between">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">

                                    <svg class="w-5 h-5 text-indigo-600"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M7 21h10a2 2 0 002-2V9.414
                                                 a2 2 0 00-.586-1.414l-4.414-4.414
                                                 A2 2 0 0012.586 3H7a2 2 0 00-2 2v14
                                                 a2 2 0 002 2z" />

                                    </svg>

                                </div>

                                <div>

                                    <p class="font-semibold text-slate-700">
                                        {{ basename($peminjaman->berkas) }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        Dokumen peminjaman
                                    </p>

                                </div>

                            </div>


                            <a href="{{ asset('storage/' . $peminjaman->berkas) }}"
                               target="_blank"
                               class="px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition">

                                Buka Berkas

                            </a>

                        </div>

                    @else

                        <div class="text-center py-6">

                            <p class="text-sm font-semibold text-slate-500">
                                Tidak ada berkas yang diunggah
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                Peminjam belum mengunggah dokumen.
                            </p>

                        </div>

                    @endif

                </div>

            </div>


            {{-- BUTTON KEMBALI --}}

            <div class="mt-8 pt-6 border-t border-slate-200">

                <a href="{{ route('petugas.pemantauan') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200">

                    ← Kembali

                </a>

            </div>

        </div>

    </div>

</div>

@endsection