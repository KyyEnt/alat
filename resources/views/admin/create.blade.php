<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - SiAlat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');

        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-focus: #0f172a;
            
            --text-main: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            
            --btn-dark: #0f172a;
            --btn-dark-hover: #334155;
            --accent-subtle: #f1f5f9;
            --danger: #e11d48;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body { 
            background-color: var(--bg-body); 
            color: var(--text-main); 
            font-family: 'IBM Plex Mono', monospace; 
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .container { max-width: 560px; margin: 40px auto; padding: 0 20px; }

        .form-card { 
            background-color: var(--bg-card); 
            border: 1px solid var(--border-color); 
            border-radius: 12px; 
            padding: 32px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
        }

        .form-header { margin-bottom: 24px; }

        .form-title { 
            font-size: 20px; 
            color: var(--text-main); 
            font-weight: 600; 
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label { 
            display: block; 
            font-size: 12px; 
            font-weight: 500;
            color: var(--text-main); 
            margin-bottom: 8px; 
        }

        .form-control { 
            width: 100%; 
            padding: 10px 14px; 
            background-color: var(--bg-card); 
            border: 1px solid var(--border-color); 
            border-radius: 8px; 
            color: var(--text-main); 
            font-family: 'IBM Plex Mono', monospace; 
            font-size: 13px; 
            transition: all 0.2s ease;
        }

        .form-control:focus { 
            outline: none; 
            border-color: var(--border-focus); 
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.05);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2064748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 36px;
        }

        .error-text { 
            color: var(--danger); 
            font-size: 11px; 
            margin-top: 6px; 
        }

        .form-actions { 
            display: flex; 
            justify-content: flex-end; 
            gap: 10px; 
            margin-top: 28px; 
            padding-top: 20px;
            border-top: 1px solid var(--accent-subtle);
        }

        .btn { 
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 18px; 
            font-size: 12px; 
            font-weight: 500;
            border-radius: 8px; 
            text-decoration: none; 
            border: 1px solid transparent; 
            cursor: pointer; 
            font-family: 'IBM Plex Mono', monospace; 
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-secondary { 
            background: var(--bg-card); 
            border-color: var(--border-color);
            color: var(--text-main); 
        }
        .btn-secondary:hover {
            background-color: var(--accent-subtle);
        }

        .btn-primary { 
            background: var(--btn-dark); 
            color: #ffffff; 
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .btn-primary:hover {
            background-color: var(--btn-dark-hover);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    @include('layouts.navbar-admin')

    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="form-title">Tambah User Baru</h1>
                <p class="form-subtitle">Isi formulir di bawah untuk membuat akun baru</p>
            </div>

            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf

                <!-- Input Name -->
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    @error('name') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <!-- Input Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    @error('email') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <!-- Input Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    @error('password') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <!-- Select Role -->
                <div class="form-group">
                    <label for="role_id">Role / Hak Akses</label>
                    <select id="role_id" name="role_id" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->nama_role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>