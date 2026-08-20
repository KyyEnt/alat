<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap');

        .login-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 16px;
            box-sizing: border-box;
            font-family: 'IBM Plex Mono', monospace;
        }

        .login-card {
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

        .login-title {
            font-size: 18px;
            font-weight: 600;
            color: #2dd4bf; /* Teal 400 */
            margin: 0 0 4px 0;
            text-align: center;
        }

        .login-subtitle {
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

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox-input {
            accent-color: #f59e0b;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .checkbox-label {
            margin-left: 8px;
            font-size: 12px;
            color: #cbd5e1;
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
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #2dd4bf;
        }

        .extra-links-wrapper {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px dashed rgba(51, 65, 85, 0.8);
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .action-link {
            font-size: 12px;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .action-link:hover {
            color: #fbbf24; /* Amber light */
        }

        .register-highlight {
            color: #f59e0b;
            font-weight: 500;
        }

        .register-highlight:hover {
            color: #fbbf24;
            text-decoration: underline;
        }
    </style>

    <div class="login-wrapper">
        <div class="login-card">
            
            <div class="back-link-wrapper">
                <a href="{{ url('/') }}" class="back-link">
                    &larr; Beranda
                </a>
            </div>

            <h2 class="login-title">SiAlat Login</h2>
            <p class="login-subtitle">Masukkan akun untuk melanjutkan</p>

            @if (session('status'))
                <div style="color: #fbbf24; font-size: 12px; margin-bottom: 16px; background: rgba(245,158,11,0.1); padding: 8px; border-radius: 4px; border: 1px solid rgba(245,158,11,0.2);">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" autocomplete="username">
                    @error('email')
                        <span style="color: #f43f5e; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required placeholder="••••••••" autocomplete="current-password">
                    @error('password')
                        <span style="color: #f43f5e; font-size: 11px; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                    <label for="remember_me" class="checkbox-label">Ingat saya</label>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk
                </button>

                <div class="extra-links-wrapper">
                    @if (Route::has('register'))
                        <div>
                            <span style="font-size: 12px; color: #94a3b8;">Belum punya akun?</span>
                            <a class="action-link register-highlight" href="{{ route('register') }}">
                                Daftar
                            </a>
                        </div>
                    @endif

                    @if (Route::has('password.request'))
                        <div>
                            <a class="action-link" href="{{ route('password.request') }}">
                                Lupa kata sandi?
                            </a>
                        </div>
                    @endif
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>