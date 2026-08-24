<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<x-app-layout>
    {{-- Custom Navbar Component --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-info px-4 py-2">
        <div class="container-fluid">
            <a href="{{ route('peminjam.index') }}" class="navbar-brand fw-bold text-info d-flex align-items-center gap-2">
                SiAlat 
                <span class="badge rounded-pill bg-dark text-info border border-info uppercase px-2 py-1" style="font-size: 10px;">
                    PEMINJAM
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPeminjam">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarPeminjam">
                            <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-3">
                <li class="nav-item">
                    <a href="{{ route('peminjam.index') }}" class="nav-link text-light">Beranda</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-light">Daftar Alat</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('peminjam.index') }}" class="nav-link active fw-bold text-info">Pinjaman Saya</a>
                </li>

                {{-- Nama User --}}
                <li class="nav-item ps-lg-3 border-start-lg border-secondary">
                    <span class="small text-secondary fw-bold d-block py-2 py-lg-0">
                        {{ auth()->user()->name ?? 'Peminjam' }}
                    </span>
                </li>

                {{-- Tombol Logout terpisah di <li> tersendiri --}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="m-0 d-flex align-items-center">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 w-lg-auto">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content Container --}}
    <div class="bg-dark text-white min-vh-100 py-4">
        <div class="container">

            {{-- Header & Action Button --}}
            <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-secondary">
                <div class="text-start">
                    <h1 class="h4 fw-bold text-info mb-1">Peminjaman Saya</h1>
                    <p class="text-secondary small mb-0">Kelola dan pantau status riwayat pengajuan peminjaman alat Anda.</p>
                </div>
                
                <div>
                    <a href="{{ route('peminjam.create') }}" class="btn btn-info text-dark fw-bold btn-sm px-3 py-2 shadow">
                        + Ajukan Peminjaman
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show text-sm mb-4 bg-success bg-opacity-20 text-success border-success" role="alert">
                    <strong>[SUCCESS]</strong> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-sm mb-4 bg-danger bg-opacity-20 text-danger border-danger" role="alert">
                    <strong>[ERROR]</strong> {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Filter Section --}}
            <div class="bg-secondary bg-opacity-10 p-3 rounded border border-secondary shadow-sm d-flex align-items-center justify-content-between mb-4">
                <form method="GET" class="d-flex align-items-center gap-2 m-0">
                    <label for="status" class="small fw-bold text-uppercase text-secondary mb-0">Filter Status:</label>
                    <select id="status" name="status" onchange="this.form.submit()" class="form-select form-select-sm w-auto bg-dark text-info border-secondary">
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
            <div class="bg-secondary bg-opacity-10 rounded border border-secondary shadow overflow-hidden mb-4">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 text-sm">
                        <thead class="table-dark text-uppercase text-secondary small fw-bold border-bottom border-secondary">
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
                                <tr class="border-bottom border-secondary">
                                    <td class="px-4 py-3 fw-bold text-info text-nowrap">
                                        {{ $peminjaman->kode_peminjaman }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex flex-column gap-1">
                                            @foreach ($peminjaman->detailPeminjamans as $detail)
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-light fw-medium">
                                                        {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                                    </span>
                                                    <span class="badge bg-dark text-info border border-secondary">
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
                                                'disetujui'    => 'bg-info text-dark',
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
                                        <a href="{{ route('peminjam.show', $peminjaman->id) }}" class="btn btn-outline-info btn-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-5 text-center text-secondary">
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
</x-app-layout>