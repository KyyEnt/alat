@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Detail Peminjaman</h3>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3"><strong>Kode</strong></div>
                <div class="col-md-9">{{ $peminjaman->kode_peminjaman }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3"><strong>Peminjam</strong></div>
                <div class="col-md-9">{{ $peminjaman->user->name }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3"><strong>Tanggal Pinjam</strong></div>
                <div class="col-md-9">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3"><strong>Rencana Kembali</strong></div>
                <div class="col-md-9">{{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3"><strong>Status</strong></div>
                <div class="col-md-9">
                    @php
                        $badgeColor = match($peminjaman->status) {
                            'menunggu'      => 'warning',
                            'disetujui'     => 'info',
                            'dipinjam'      => 'primary',
                            'dikembalikan'  => 'success',
                            'ditolak'       => 'danger',
                            default         => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeColor }} text-uppercase">
                        {{ $peminjaman->status }}
                    </span>
                </div>
            </div>
            @if ($peminjaman->keterangan)
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Keterangan</strong></div>
                    <div class="col-md-9">{{ $peminjaman->keterangan }}</div>
                </div>
            @endif
        </div>
    </div>

    <h5>Daftar Alat</h5>
    <div class="table-responsive mb-3">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjaman->detailPeminjamans as $detail)
                    <tr>
                        <td>{{ $detail->alat->nama_alat }}</td>
                        <td>{{ $detail->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Info pengembalian + denda, jika sudah dikembalikan --}}
    @if ($peminjaman->pengembalian)
        <h5>Info Pengembalian</h5>
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Tanggal Kembali</strong></div>
                    <div class="col-md-9">
                        {{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali)->format('d M Y') }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3"><strong>Denda</strong></div>
                    <div class="col-md-9">
                        @if ($peminjaman->pengembalian->denda > 0)
                            <span class="text-danger fw-bold">
                                Rp{{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-success">Tidak ada denda</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection