<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - SiAlat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');

        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;

            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;

            --btn-dark: #0f172a;
            --btn-dark-hover: #334155;
            --accent-subtle: #f1f5f9;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'IBM Plex Mono', monospace;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 1040px; margin: 40px auto; padding: 0 20px; }

        .header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title h1 {
            font-size: 22px;
            font-weight: 600;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .page-title p {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 16px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-family: 'IBM Plex Mono', monospace;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--btn-dark);
            color: #ffffff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .btn-primary:hover {
            background-color: var(--btn-dark-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-main);
        }
        .btn-secondary:hover {
            background-color: var(--accent-subtle);
            border-color: var(--border-hover);
        }

        .btn-danger {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-muted);
        }
        .btn-danger:hover {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .alert-success {
            display: flex;
            align-items: center;
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            border-left: 3px solid var(--text-main);
        }

        .alert-error {
            display: flex;
            align-items: center;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 24px;
            border-left: 3px solid #dc2626;
        }

        .table-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
        }

        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }

        th {
            background-color: var(--accent-subtle);
            color: var(--text-muted);
            padding: 14px 20px;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tbody tr { transition: background-color 0.15s ease; }
        tbody tr:hover { background-color: #f1f5f950; }

        .action-cell { display: flex; gap: 8px; align-items: center; }
        .pagination-wrapper { margin-top: 24px; }
    </style>
</head>
<body>

    @include('layouts.navbar-admin')

    <div class="container">
        <div class="header-action">
            <div class="page-title">
                <h1>Data Kategori</h1>
                <p>Kelola kategori alat yang tersedia untuk dipinjam</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th style="width: 90px;">Jml Alat</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $index => $item)
                        <tr>
                            <td style="color: var(--text-light);">{{ $kategori->firstItem() + $index }}</td>
                            <td><strong>{{ $item->nama_kategori }}</strong></td>
                            <td style="color: var(--text-muted);">{{ $item->keterangan ?? '-' }}</td>
                            <td style="color: var(--text-muted);">{{ $item->alats_count ?? $item->alats()->count() }}</td>
                            <td class="action-cell">
                                <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-secondary">Edit</a>

                                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-light); padding: 32px;">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $kategori->links() }}
        </div>
    </div>

</body>
</html>
