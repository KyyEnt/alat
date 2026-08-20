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
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a href="{{ route('peminjam.index') }}" class="nav-link text-light">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-light">Daftar Alat</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peminjam.index') }}" class="nav-link active fw-bold text-info">Pinjaman Saya</a>
                    </li>
                    
                    <li class="nav-item d-flex align-items-center gap-3 ps-3 border-start border-secondary">
                        <span class="small text-secondary fw-bold">
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
    <div class="bg-dark text-white min-vh-100 py-4">
        <div class="container" style="max-width: 900px;">

            {{-- Header --}}
            <div class="pb-3 mb-4 border-bottom border-secondary">
                <h1 class="h4 fw-bold text-info mb-1">Pengajuan Peminjaman Alat</h1>
                <p class="text-secondary small mb-0">Lengkapi formulir di bawah ini untuk mengajukan peminjaman alat.</p>
            </div>

            {{-- Alert Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show text-sm mb-4" role="alert">
                    <strong class="d-block mb-1">[ERROR VALIDASI]</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form Pengajuan --}}
            <form method="POST" action="{{ route('peminjam.store') }}" id="form-peminjaman">
                @csrf

                {{-- Card 1: Informasi Peminjaman --}}
                <div class="card bg-secondary bg-opacity-10 border-secondary text-white shadow mb-4">
                    <div class="card-header bg-transparent border-secondary text-info fw-bold text-uppercase small py-3">
                        Informasi Peminjaman
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase small text-secondary fw-bold">
                                    Tanggal Pinjam <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_pinjam" 
                                       class="form-control form-control-sm bg-dark text-white border-secondary"
                                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                                @error('tanggal_pinjam')
                                    <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-uppercase small text-secondary fw-bold">
                                    Rencana Tanggal Kembali <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal_rencana_kembali" 
                                       class="form-control form-control-sm bg-dark text-white border-secondary"
                                       value="{{ old('tanggal_rencana_kembali') }}" required>
                                @error('tanggal_rencana_kembali')
                                    <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-uppercase small text-secondary fw-bold">
                                Keterangan / Keperluan (Opsional)
                            </label>
                            <textarea name="keterangan" rows="3" 
                                      placeholder="Contoh: Untuk keperluan praktikum jaringan"
                                      class="form-control form-control-sm bg-dark text-white border-secondary">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Card 2: Daftar Alat Yang Dipinjam --}}
                <div class="card bg-secondary bg-opacity-10 border-secondary text-white shadow mb-4">
                    <div class="card-header bg-transparent border-secondary d-flex justify-content-between align-items-center py-2">
                        <span class="text-info fw-bold text-uppercase small">Daftar Alat Yang Dipinjam</span>
                        <button type="button" id="btn-tambah-item" class="btn btn-outline-info btn-sm fw-bold text-uppercase" style="font-size: 11px;">
                            + Tambah Alat
                        </button>
                    </div>

                    <div class="card-body">
                        <div id="container-items" class="d-flex flex-column gap-3">
                            {{-- Default Row Item 1 --}}
                            <div class="row g-2 align-items-end item-row p-3 rounded border border-secondary bg-dark">
                                <div class="col-12 col-md-7">
                                    <label class="form-label text-uppercase small text-secondary fw-bold" style="font-size: 11px;">Pilih Alat</label>
                                    <select name="items[0][alat_id]" class="form-select form-select-sm bg-dark text-info border-secondary" required>
                                        <option value="">-- Pilih Alat --</option>
                                        @foreach($alats as $alat)
                                            <option value="{{ $alat->id }}">
                                                {{ $alat->nama_alat }} (Stok: {{ $alat->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8 col-md-3">
                                    <label class="form-label text-uppercase small text-secondary fw-bold" style="font-size: 11px;">Jumlah</label>
                                    <input type="number" name="items[0][jumlah]" min="1" value="1" 
                                           class="form-control form-control-sm bg-dark text-white border-secondary" required>
                                </div>
                                <div class="col-4 col-md-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100 btn-hapus-item" disabled>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-end gap-2 pt-2">
                    <a href="{{ route('peminjam.index') }}" class="btn btn-outline-secondary btn-sm text-uppercase fw-bold px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-info btn-sm text-dark fw-bold text-uppercase px-4 shadow">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Script Tambah / Hapus Form Alat Secara Dinamis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let itemIndex = 1;
            const container = document.getElementById('container-items');
            const btnTambah = document.getElementById('btn-tambah-item');

            btnTambah.addEventListener('click', function () {
                const firstRow = container.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true);

                const selectElement = newRow.querySelector('select');
                selectElement.name = `items[${itemIndex}][alat_id]`;
                selectElement.value = '';

                const inputElement = newRow.querySelector('input[type="number"]');
                inputElement.name = `items[${itemIndex}][jumlah]`;
                inputElement.value = 1;

                const btnHapus = newRow.querySelector('.btn-hapus-item');
                btnHapus.removeAttribute('disabled');
                btnHapus.addEventListener('click', function () {
                    newRow.remove();
                    updateHapusButtons();
                });

                container.appendChild(newRow);
                itemIndex++;
                updateHapusButtons();
            });

            function updateHapusButtons() {
                const rows = container.querySelectorAll('.item-row');
                rows.forEach((row) => {
                    const btnHapus = row.querySelector('.btn-hapus-item');
                    if (rows.length === 1) {
                        btnHapus.setAttribute('disabled', 'disabled');
                    } else {
                        btnHapus.removeAttribute('disabled');
                    }
                });
            }
        });
    </script>
</x-app-layout>