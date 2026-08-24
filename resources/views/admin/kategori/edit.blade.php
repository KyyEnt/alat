<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - SiAlat</title>
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

        textarea.form-control { resize: vertical; min-height: 90px; }

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
                <h1 class="form-title">Edit Kategori</h1>
                <p class="form-subtitle">Perbarui data kategori alat</p>
            </div>

            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required maxlength="50">
                    @error('nama_kategori') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan (Opsional)</label>
                    <textarea id="keterangan" name="keterangan" class="form-control">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                    @error('keterangan') <div class="error-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui Kategori</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
