<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - SiAlat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background-color: #020617; color: #f8fafc; font-family: 'IBM Plex Mono', monospace; min-height: 100vh; }
        .container { max-width: 600px; margin: 24px auto; padding: 0 16px; }
        .form-card { background-color: #0f172a; border: 1px solid #1e293b; border-radius: 6px; padding: 24px; }
        .form-title { font-size: 18px; color: #2dd4bf; margin-bottom: 20px; font-weight: 600; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 12px; color: #94a3b8; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 10px 12px; background-color: #020617; border: 1px solid #334155; border-radius: 4px; color: #f8fafc; font-family: 'IBM Plex Mono', monospace; font-size: 13px; }
        .form-control:focus { outline: none; border-color: #14b8a6; }
        .error-text { color: #f43f5e; font-size: 11px; margin-top: 4px; }
        .help-text { color: #64748b; font-size: 11px; margin-top: 4px; }
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
        .btn { padding: 8px 16px; font-size: 12px; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; font-family: 'IBM Plex Mono', monospace; }
        .btn-secondary { background: #334155; color: #f8fafc; }
        .btn-primary { background: #14b8a6; color: #020617; font-weight: 600; }
    </style>
</head>
<body>

    @include('layouts.navbar-admin')

    <div class="container">
        <div class="form-card">
            <h1 class="form-title">Edit Data User</h1>

            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Name -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <!-- Input Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <!-- Input Password (Opsional) -->
                <div class="form-group">
                    <label for="password">Password (Opsional)</label>
                    <input type="password" id="password" name="password" class="form-control">
                    <div class="help-text">Kosongkan jika tidak ingin mengubah password.</div>
                    @error('password') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <!-- Select Role -->
                <div class="form-group">
                    <label for="role_id">Role / Hak Akses</label>
                    <select id="role_id" name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->nama_role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui User</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>