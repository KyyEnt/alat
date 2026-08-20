<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - SiAlat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #020617; color: #f8fafc; font-family: 'IBM Plex Mono', monospace; min-height: 100vh; }
        .container { max-width: 1000px; margin: 24px auto; padding: 0 16px; }
        .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-title h1 { font-size: 20px; color: #2dd4bf; }
        
        .btn { padding: 8px 14px; font-size: 12px; font-weight: 600; border-radius: 6px; text-decoration: none; cursor: pointer; border: none; font-family: 'IBM Plex Mono', monospace; }
        .btn-primary { background-color: #14b8a6; color: #020617; }
        .btn-primary:hover { background-color: #2dd4bf; }
        .btn-warning { background-color: transparent; border: 1px solid #f59e0b; color: #fbbf24; }
        .btn-warning:hover { background-color: #f59e0b; color: #020617; }
        .btn-danger { background-color: transparent; border: 1px solid #f43f5e; color: #f43f5e; }
        .btn-danger:hover { background-color: #f43f5e; color: #ffffff; }

        .alert-success { background-color: rgba(20, 184, 166, 0.15); border: 1px solid #14b8a6; color: #2dd4bf; padding: 12px 16px; border-radius: 6px; font-size: 13px; margin-bottom: 20px; }
        .table-container { background-color: #0f172a; border: 1px solid #1e293b; border-radius: 6px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; }
        th { background-color: #1e293b; color: #94a3b8; padding: 12px 16px; font-weight: 600; }
        td { padding: 12px 16px; border-top: 1px solid #1e293b; color: #cbd5e1; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .badge-admin { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid #f59e0b; }
        .badge-petugas { background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid #3b82f6; }
        .badge-peminjam { background: rgba(20, 184, 166, 0.2); color: #2dd4bf; border: 1px solid #14b8a6; }

        .action-cell { display: flex; gap: 8px; }
        .pagination-wrapper { margin-top: 16px; }
    </style>
</head>
<body>

    @include('layouts.navbar-admin')

    <div class="container">
        <div class="header-action">
            <div class="page-title">
                <h1>Data Pengguna (User)</h1>
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
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
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
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                                
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #64748b;">Belum ada data user.</td>
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