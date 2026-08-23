<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - SiAlat</title>
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

        /* Header Area */
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

        /* Buttons */
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

        /* Card & Table */
        .table-container { 
            background-color: var(--bg-card); 
            border: 1px solid var(--border-color); 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02); 
            margin-bottom: 24px;
        }

        /* Filter Section */
        .filter-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            padding: 9px 12px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--bg-body);
            color: var(--text-main);
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-control:focus {
            border-color: var(--text-main);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 18px 20px;
        }

        .stat-card .label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-main);
        }

        /* Table */
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

        /* Badges */
        .badge { 
            display: inline-flex;
            align-items: center;
            padding: 4px 10px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: 500; 
        }

        .badge-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-warning {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fef3c7;
        }

        .action-cell { display: flex; gap: 8px; align-items: center; }
        .pagination-wrapper { margin-top: 24px; }
    </style>
</head>
<body>

    @include('layouts.navbar-admin')

    <div class="container">
        <div class="header-action">
            <div class="page-title">
                <h1>Laporan Transaksi</h1>
                <p>Rekapitulasi dan ringkasan riwayat aktivitas sistem</p>
            </div>
            <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
        </div>

        @if(isset($statistik))
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="label">Total Transaksi</div>
                    <div class="value">{{ $statistik['total'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Selesai</div>
                    <div class="value">{{ $statistik['selesai'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <div class="label">Pending</div>
                    <div class="value">{{ $statistik['pending'] ?? 0 }}</div>
                </div>
            </div>
        @endif

        <div class="filter-card">
            <form method="GET" action="{{ url()->current() }}" class="filter-grid">
                <div class="form-group">
                    <label for="tanggal_dari">Dari Tanggal</label>
                    <input type="date" id="tanggal_dari" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="form-group">
                    <label for="tanggal_sampai">Sampai Tanggal</label>
                    <input type="date" id="tanggal_sampai" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="form-group" style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-secondary" style="flex: 1;">Filter</button>
                    <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Tanggal</th>
                        <th>Pengguna</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $index => $item)
                        <tr>
                            <td style="color: var(--text-light);">{{ method_exists($peminjaman, 'firstItem') ? $peminjaman->firstItem() + $index : $index + 1 }}</td>
                            <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i') }}</td>
                            <td><strong>{{ $item->user->name ?? $item->nama_pengguna ?? '-' }}</strong></td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                @if(($item->status ?? '') === 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-warning">{{ ucfirst($item->status ?? 'Pending') }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-light); padding: 32px;">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($peminjaman, 'links'))
            <div class="pagination-wrapper">
                {{ $peminjaman->links() }}
            </div>
        @endif
    </div>

</body>
</html>