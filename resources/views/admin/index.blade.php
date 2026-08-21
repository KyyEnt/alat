<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - SiAlat</title>
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

        /* Alert Notification */
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

        /* Card & Table */
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

        /* Badges */
        .badge { 
            display: inline-flex;
            align-items: center;
            padding: 4px 10px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: 500; 
        }
        
        .badge-admin { 
            background: var(--btn-dark); 
            color: #ffffff; 
        }
        
        .badge-petugas { 
            background: var(--accent-subtle); 
            color: var(--text-main); 
            border: 1px solid var(--border-color); 
        }
        
        .badge-peminjam { 
            background: transparent; 
            color: var(--text-muted); 
            border: 1px dashed var(--border-hover); 
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
                <h1>Data Pengguna</h1>
                <p>Kelola hak akses dan akun pengguna sistem</p>
            </div>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">+ Tambah User</a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td style="color: var(--text-light);">{{ $users->firstItem() + $index }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td style="color: var(--text-muted);">{{ $user->email }}</td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge badge-admin">Admin</span>
                                @elseif($user->isPetugas())
                                    <span class="badge badge-petugas">Petugas</span>
                                @else
                                    <span class="badge badge-peminjam">Peminjam</span>
                                @endif
                            </td>
                            <td class="action-cell">
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-secondary">Edit</a>
                                
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-light); padding: 32px;">Belum ada data user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    </div>

</body>
</html>