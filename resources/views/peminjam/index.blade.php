<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya - SiAlat</title>
    
    {{-- CDN CSS Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light min-vh-100">

    {{-- Custom Navbar Component --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4">
        <div class="container-fluid">
            <a href="{{ route('peminjam.index') }}" class="navbar-brand font-weight-bold text-dark d-flex align-items-center gap-2">
                SiAlat 
                <span class="badge rounded-pill bg-light text-primary border border-info uppercase px-2 py-1" style="font-size: 11px;">
                    PEMINJAM
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPeminjam">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarPeminjam">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a href="{{ route('peminjam.index') }}" class="nav-link">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Daftar Alat</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjam.index') }}" class="nav-link active font-weight-bold text-primary">Pinjaman Saya</a>
                    </li>
                    
                    <li class="nav-item d-flex align-items-center gap-3 ps-3 border-start">
                        <span class="small font-weight-bold text-secondary">
                            {{ auth()->user()->name ?? 'Peminjam' }}
                        </span>
                        
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content Container --}}
    <div class="py-4">
        <div class="container">

            {{-- Header & Action Button --}}
            <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                <div class="text-start">
                    <h3 class="h4 font-weight-bold text-dark mb-1">Peminjaman Saya</h3>
                    <p class="text-muted small mb-0">Kelola dan pantau status riwayat pengajuan peminjaman alat Anda.</p>
                </div>
                
                <div>
                    <a href="{{ route('peminjam.create') }}" class="btn btn-primary font-weight-semibold btn-sm px-3 py-2">
                        + Ajukan Peminjaman
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-sm mb-4" role="alert">
                    <strong>[SUCCESS]</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-sm mb-4" role="alert">
                    <strong>[ERROR]</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Filter Section --}}
            <div class="bg-white p-3 rounded border shadow-sm d-flex align-items-center justify-content-between mb-4">
                <form method="GET" class="d-flex align-items-center gap-2 m-0">
                    <label for="status" class="small font-weight-bold text-uppercase text-secondary mb-0">Filter Status:</label>
                    <select id="status" name="status" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                        <option value="">Semua Status</option>
                        <option value="menunggu" @selected(request('status') === 'menunggu')>Menunggu</option>
                        <option value="disetujui" @selected(request('status') === 'disetujui')>Disetujui</option>
                        <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>Ditolak</option>
                        <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
                    </select>
                </form>
            </div>

            {{-- Data Table --}}
            <div class="bg-white rounded border shadow-sm overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-light text-uppercase text-secondary small font-weight-bold">
                            <tr>
                                <th scope="col" class="px-4 py-3">Kode</th>
                                <th scope="col" class="px-4 py-3">Alat</th>
                                <th scope="col" class="px-4 py-3">Tgl Pinjam</th>
                                <th scope="col" class="px-4 py-3">Rencana Kembali</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td class="px-4 py-3 font-weight-bold text-primary text-nowrap">
                                        {{ $peminjaman->kode_peminjaman }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column gap-1">
                                            @foreach ($peminjaman->detailPeminjamans as $detail)
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-dark font-weight-medium">
                                                        {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                                    </span>
                                                    <span class="badge bg-light text-dark border">
                                                        x{{ $detail->jumlah }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-nowrap text-secondary">
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-nowrap text-secondary">
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-nowrap">
                                        @php
                                            $status = strtolower($peminjaman->status);
                                            $badgeStyle = match($status) {
                                                'menunggu'     => 'bg-warning text-dark',
                                                'disetujui'    => 'bg-info text-white',
                                                'dipinjam'     => 'bg-primary text-white',
                                                'dikembalikan' => 'bg-success text-white',
                                                'ditolak'      => 'bg-danger text-white',
                                                default        => 'bg-secondary text-white',
                                            };
                                        @endphp
                                        <span class="badge rounded-pill uppercase px-2 py-1 {{ $badgeStyle }}">
                                            {{ $peminjaman->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-nowrap text-end">
                                        <a href="{{ route('peminjam.show', $peminjaman->id) }}" class="btn btn-outline-secondary btn-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-5 text-center text-muted">
                                        Belum ada pengajuan peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end">
                {{ $peminjamans->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

    {{-- CDN JS Bootstrap 5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>