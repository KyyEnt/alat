<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');

        .register-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 16px;
            box-sizing: border-box;
            font-family: 'IBM Plex Mono', monospace;
        }

        .register-card {
            width: 100%;
            max-width: 380px;
            background-color: #0f172a; /* Slate 900 */
            border: 1px solid #14b8a6; /* Subtle Teal Border */
            border-radius: 8px;
            padding: 28px 24px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4);
            box-sizing: border-box;
            color: #f8fafc;
        }

        .back-link-wrapper {
            margin-bottom: 16px;
        }

        .back-link {
            font-size: 11px;
            color: #14b8a6;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #2dd4bf;
        }

        .register-title {
            font-size: 18px;
            font-weight: 600;
            color: #2dd4bf; /* Teal 400 */
            margin: 0 0 4px 0;
            text-align: center;
        }

        .register-subtitle {
            font-size: 12px;
            color: #94a3b8;
            margin: 0 0 24px 0;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #ccfbf1; /* Teal light */
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            height: 40px;
            box-sizing: border-box;
            background-color: #020617; /* Slate 950 */
            border: 1px solid #334155;
            color: #f8fafc;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            padding: 0 12px;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #f59e0b; /* Amber */
        }

        .btn-submit {
            width: 100%;
            height: 40px;
            background-color: #14b8a6; /* Teal */
            color: #020617;
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
            font-size: 13px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 8px;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #2dd4bf;
        }

        .login-link-wrapper {
            margin-top: 16px;
            text-align: center;
        }

        .login-link {
            font-size: 12px;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-link:hover {
            color: #fbbf24; /* Amber light */
        }

        .login-highlight {
            color: #f59e0b;
            font-weight: 500;
        }

        .login-highlight:hover {
            color: #fbbf24;
            text-decoration: underline;
        }
    </style>

    <div class="register-wrapper">
        <div class="register-card">
            
            <div class="back-link-wrapper">
                <a href="{{ url('/') }}" class="back-link">
                    &larr; Beranda
                </a>
            </div>

            <h2 class="register-title">Daftar SiAlat</h2>
            <p class="register-subtitle">Buat akun peminjam baru</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama Anda" autocomplete="name">
                    @error('name')
                        <span style="color: #f43f5e; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" autocomplete="username">
                    @error('email')
                        <span style="color: #f43f5e; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required placeholder="••••••••" autocomplete="new-password">
                    @error('password')
                        <span style="color: #f43f5e; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required placeholder="••••••••" autocomplete="new-password">
                    @error('password_confirmation')
                        <span style="color: #f43f5e; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Daftar Sekarang
                </button>

                <div class="login-link-wrapper">
                    <span style="font-size: 12px; color: #94a3b8;">Sudah punya akun?</span>
                    <a class="login-link login-highlight" href="{{ route('login') }}">
                        Masuk
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>