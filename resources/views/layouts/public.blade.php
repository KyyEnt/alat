<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiAlat') — Sistem Informasi Peminjaman Alat</title>
    <meta name="description" content="@yield('meta_description', 'SiAlat adalah sistem informasi peminjaman alat untuk mengelola permintaan, persetujuan, dan pengembalian alat secara digital.')">

    {{-- Fonts: IBM Plex Mono untuk elemen "tag/inventaris", Public Sans untuk teks baca --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Public+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2216%22 fill=%22%232F6E68%22/><text x=%2250%22 y=%2266%22 font-size=%2254%22 text-anchor=%22middle%22 fill=%22%23F6F5F1%22 font-family=%22monospace%22>S</text></svg>">

    <style>
        /* ==========================================================
           SiAlat — Design Tokens
           Konsep: kartu tag inventaris alat (bukan tema korporat generik)
           ========================================================== */
        :root{
            --sa-paper:      #F6F5F1;   /* latar utama, netral hangat, bukan krem penuh */
            --sa-paper-dim:  #EFEDE6;
            --sa-ink:        #17302D;   /* teks utama, hijau-tinta gelap */
            --sa-ink-soft:   #4B5C58;
            --sa-teal:       #2F6E68;   /* warna primer */
            --sa-teal-dark:  #15302D;   /* seksi gelap */
            --sa-amber:      #D98A2B;   /* aksen stempel */
            --sa-tag:        #EADFBB;   /* permukaan "kartu tag" manila */
            --sa-line:       #C9C2AE;   /* garis tipis ala kartu fisik */
            --sa-line-dark:  rgba(246,245,241,.18);

            --font-mono: 'IBM Plex Mono', ui-monospace, monospace;
            --font-body: 'Public Sans', system-ui, sans-serif;
        }

        html{ scroll-behavior: smooth; }
        @media (prefers-reduced-motion: reduce){
            html{ scroll-behavior: auto; }
            *{ animation-duration: .001ms !important; animation-iteration-count: 1 !important; transition-duration: .001ms !important; }
        }

        body{
            font-family: var(--font-body);
            background: var(--sa-paper);
            color: var(--sa-ink);
        }

        .font-mono{ font-family: var(--font-mono); }

        .eyebrow{
            font-family: var(--font-mono);
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--sa-teal);
        }
        .eyebrow.on-dark{ color: #9FC7C2; }

        a{ color: var(--sa-teal); }
        a:hover{ color: var(--sa-ink); }

        .btn-sa-primary{
            background: var(--sa-teal);
            border: 1px solid var(--sa-teal);
            color: #fff;
            font-weight: 600;
            padding: .65rem 1.4rem;
            border-radius: .4rem;
            transition: transform .15s ease, background .15s ease;
        }
        .btn-sa-primary:hover{
            background: var(--sa-ink);
            border-color: var(--sa-ink);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-sa-outline{
            background: transparent;
            border: 1px solid var(--sa-line);
            color: var(--sa-ink);
            font-weight: 600;
            padding: .65rem 1.4rem;
            border-radius: .4rem;
            transition: border-color .15s ease, transform .15s ease;
        }
        .btn-sa-outline:hover{
            border-color: var(--sa-teal);
            color: var(--sa-teal);
            transform: translateY(-1px);
        }

        /* Fokus keyboard tetap terlihat jelas */
        a:focus-visible, button:focus-visible, .btn-sa-primary:focus-visible, .btn-sa-outline:focus-visible{
            outline: 2px solid var(--sa-amber);
            outline-offset: 3px;
        }

        /* ---------- Navbar ---------- */
        .sa-navbar{
            background: rgba(246,245,241,.9);
            backdrop-filter: saturate(140%) blur(6px);
            border-bottom: 1px solid var(--sa-line);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .sa-navbar .navbar-brand{
            font-family: var(--font-mono);
            font-weight: 700;
            letter-spacing: .02em;
            color: var(--sa-ink);
        }
        .sa-navbar .navbar-brand span{ color: var(--sa-teal); }
        .sa-navbar .nav-link{
            font-weight: 600;
            font-size: .92rem;
            color: var(--sa-ink-soft);
        }
        .sa-navbar .nav-link:hover,
        .sa-navbar .nav-link.active{ color: var(--sa-teal); }

        /* ---------- Footer ---------- */
        .sa-footer{
            background: var(--sa-teal-dark);
            color: #DCE7E5;
            border-top: 4px solid var(--sa-amber);
        }
        .sa-footer a{ color: #DCE7E5; }
        .sa-footer a:hover{ color: var(--sa-amber); }
        .sa-footer .footer-brand{
            font-family: var(--font-mono);
            font-weight: 700;
            color: #fff;
        }
        .sa-footer hr{ border-color: var(--sa-line-dark); }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ================= NAVBAR ================= --}}
    <nav class="sa-navbar navbar navbar-expand-lg py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.home') }}">
                SI<span>ALAT</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#saNavbarNav"
                    aria-controls="saNavbarNav" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="saNavbarNav">
                <ul class="navbar-nav mx-auto my-3 my-lg-0 gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.home') }}#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.home') }}#alur">Alur Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.home') }}#tentang">Tentang</a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sa-outline btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sa-primary btn-sm">Daftar Akun</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="sa-footer pt-5 pb-4 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="footer-brand font-mono fs-5 mb-2">SIALAT</div>
                    <p class="small mb-0" style="max-width: 32ch; opacity:.85;">
                        Sistem informasi peminjaman alat — mencatat setiap pengajuan, persetujuan,
                        dan pengembalian alat secara digital dan tertelusur.
                    </p>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="eyebrow on-dark mb-3">Navigasi</div>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('public.home') }}#fitur" class="text-decoration-none">Fitur</a></li>
                        <li><a href="{{ route('public.home') }}#alur" class="text-decoration-none">Alur Peminjaman</a></li>
                        <li><a href="{{ route('public.home') }}#tentang" class="text-decoration-none">Tentang</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="eyebrow on-dark mb-3">Akun</div>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('login') }}" class="text-decoration-none">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="text-decoration-none">Daftar</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <div class="eyebrow on-dark mb-3">Status Sistem</div>
                    <p class="small mb-0" style="opacity:.85;">
                        Dikembangkan sebagai proyek Uji Kompetensi Keahlian — Rekayasa Perangkat Lunak.
                        Untuk kendala akses, hubungi petugas pengelola alat di sekolah Anda.
                    </p>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small" style="opacity:.75;">
                <span>&copy; {{ date('Y') }} SiAlat. Seluruh hak cipta dilindungi.</span>
                <span class="font-mono">v1.0 — sistem-informasi-peminjaman-alat</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>