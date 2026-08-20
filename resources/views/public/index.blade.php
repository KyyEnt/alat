@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_description', 'SiAlat membantu sekolah mengelola peminjaman alat laboratorium dan bengkel secara digital — mulai dari pengajuan, persetujuan petugas, hingga pengembalian.')

@push('styles')
<style>
    /* ================= Hero ================= */
    .hero{
        position: relative;
        overflow: hidden;
        padding: 5.5rem 0 6rem;
        background:
            radial-gradient(1100px 500px at 85% -10%, rgba(47,110,104,.10), transparent 60%),
            var(--sa-paper);
    }
    .hero h1{
        font-family: var(--font-mono);
        font-weight: 700;
        line-height: 1.08;
        letter-spacing: -.01em;
        font-size: clamp(2.1rem, 4.2vw, 3.4rem);
        color: var(--sa-ink);
    }
    .hero h1 em{
        font-style: normal;
        color: var(--sa-teal);
    }
    .hero p.lead-copy{
        font-size: 1.05rem;
        color: var(--sa-ink-soft);
        max-width: 46ch;
    }

    /* Kartu tag inventaris — elemen signature halaman ini */
    .equip-tag{
        --rot: -4deg;
        position: relative;
        background: var(--sa-tag);
        border: 1px solid #D8C99B;
        border-radius: .55rem;
        padding: 1.6rem 1.5rem 1.4rem;
        max-width: 340px;
        margin-left: auto;
        transform: rotate(var(--rot));
        box-shadow: 0 22px 40px -18px rgba(23,48,45,.35);
        animation: tag-float 6s ease-in-out infinite;
    }
    @keyframes tag-float{
        0%, 100%{ transform: rotate(var(--rot)) translateY(0); }
        50%{ transform: rotate(var(--rot)) translateY(-8px); }
    }
    .equip-tag::before{
        /* lubang tag, seperti kartu inventaris fisik */
        content: "";
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        width: 26px;
        height: 26px;
        background: var(--sa-paper);
        border: 3px solid var(--sa-ink);
        border-radius: 50%;
    }
    .equip-tag .tag-serial{
        font-family: var(--font-mono);
        font-size: .72rem;
        letter-spacing: .08em;
        color: var(--sa-ink-soft);
    }
    .equip-tag .tag-name{
        font-family: var(--font-mono);
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--sa-ink);
        margin: .35rem 0 1rem;
    }
    .equip-tag .tag-field{
        display: flex;
        justify-content: space-between;
        font-size: .78rem;
        padding: .4rem 0;
        border-top: 1px dashed #C9B989;
        color: var(--sa-ink-soft);
    }
    .equip-tag .tag-field b{ color: var(--sa-ink); font-weight: 600; }
    .equip-tag .stamp{
        position: absolute;
        right: -10px;
        bottom: -14px;
        font-family: var(--font-mono);
        font-weight: 700;
        font-size: .75rem;
        letter-spacing: .06em;
        color: var(--sa-amber);
        border: 2px dashed var(--sa-amber);
        border-radius: .35rem;
        padding: .3rem .55rem;
        transform: rotate(-8deg);
        background: rgba(217,138,43,.06);
    }

    /* ================= Stats ================= */
    .stats-strip{
        background: var(--sa-ink);
        border-top: 1px solid var(--sa-line-dark);
        border-bottom: 1px solid var(--sa-line-dark);
    }
    .stat-item .num{
        font-family: var(--font-mono);
        font-weight: 700;
        font-size: 1.9rem;
        color: #fff;
    }
    .stat-item .label{
        font-size: .8rem;
        color: #B9CBC8;
    }

    /* ================= Fitur (peran) ================= */
    .role-card{
        background: #fff;
        border: 1px solid var(--sa-line);
        border-radius: .6rem;
        padding: 1.75rem 1.5rem;
        height: 100%;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .role-card:hover{
        transform: translateY(-4px);
        box-shadow: 0 18px 30px -20px rgba(23,48,45,.35);
    }
    .role-chip{
        display: inline-block;
        font-family: var(--font-mono);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        color: var(--sa-teal);
        background: rgba(47,110,104,.09);
        border: 1px solid rgba(47,110,104,.25);
        border-radius: .3rem;
        padding: .25rem .55rem;
        margin-bottom: .9rem;
    }
    .role-card h3{
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--sa-ink);
    }
    .role-card p{
        color: var(--sa-ink-soft);
        font-size: .92rem;
        margin-bottom: 0;
    }

    /* ================= Alur peminjaman (proses nyata → boleh bernomor) ================= */
    .flow-step{
        position: relative;
        padding-left: 3.2rem;
    }
    .flow-step .step-num{
        position: absolute;
        left: 0;
        top: 0;
        width: 2.3rem;
        height: 2.3rem;
        border-radius: 50%;
        background: var(--sa-teal-dark);
        color: #fff;
        font-family: var(--font-mono);
        font-weight: 700;
        font-size: .85rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .flow-step:not(:last-child)::after{
        content: "";
        position: absolute;
        left: 1.15rem;
        top: 2.3rem;
        bottom: -1.9rem;
        width: 0;
        border-left: 2px dashed var(--sa-line);
    }
    .flow-step h4{
        font-size: 1rem;
        font-weight: 700;
        color: var(--sa-ink);
        margin-bottom: .25rem;
    }
    .flow-step p{
        color: var(--sa-ink-soft);
        font-size: .9rem;
        margin-bottom: 0;
    }

    /* ================= CTA & tentang ================= */
    .cta-band{
        background: var(--sa-teal-dark);
        color: #fff;
        border-radius: .75rem;
    }
    .about-card{
        background: var(--sa-paper-dim);
        border: 1px solid var(--sa-line);
        border-radius: .6rem;
        padding: 1.5rem;
        height: 100%;
    }
</style>
@endpush

@section('content')

    {{-- ================= HERO ================= --}}
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="eyebrow mb-3">Sistem Informasi Peminjaman Alat</div>
                    <h1 class="mb-3">Kelola peminjaman alat, <em>tanpa</em> catatan tercecer.</h1>
                    <p class="lead-copy mb-4">
                        SiAlat merapikan proses peminjaman alat laboratorium dan bengkel sekolah —
                        dari pengajuan oleh peminjam, verifikasi petugas, sampai alat kembali —
                        semuanya tercatat dan bisa ditelusuri kapan saja.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-sa-primary">Masuk ke Sistem</a>
                        <a href="#alur" class="btn btn-sa-outline">Lihat Alur Peminjaman</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="equip-tag">
                        <div class="tag-serial">NO. INVENTARIS · SA-0104</div>
                        <div class="tag-name">Multimeter Digital</div>

                        <div class="tag-field"><span>Kategori</span><b>Laboratorium RPL</b></div>
                        <div class="tag-field"><span>Dipegang oleh</span><b>Petugas Lab</b></div>
                        <div class="tag-field"><span>Jatuh tempo</span><b>3 hari lagi</b></div>

                        <div class="stamp">TERSEDIA</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= STATS ================= --}}
    <section class="stats-strip py-4">
        <div class="container">
            <div class="row text-center gy-3">
                <div class="col-6 col-md-3 stat-item">
                    <div class="num">150+</div>
                    <div class="label">Unit alat terdaftar</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="num">12</div>
                    <div class="label">Kategori ruang &amp; lab</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="num">3</div>
                    <div class="label">Peran pengguna</div>
                </div>
                <div class="col-6 col-md-3 stat-item">
                    <div class="num">24/7</div>
                    <div class="label">Pengajuan online</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= FITUR / PERAN ================= --}}
    <section id="fitur" class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row mb-5">
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">Fitur</div>
                    <h2 class="fw-bold" style="color:var(--sa-ink);">Satu sistem, tiga peran dengan tanggung jawabnya masing-masing</h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="role-card">
                        <span class="role-chip">ADMIN</span>
                        <h3>Kendali penuh data alat</h3>
                        <p>Mengelola data master alat, kategori, dan pengguna, serta memantau seluruh
                        riwayat peminjaman melalui dashboard ringkasan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-card">
                        <span class="role-chip">PETUGAS</span>
                        <h3>Verifikasi &amp; serah terima</h3>
                        <p>Meninjau setiap pengajuan peminjaman, menyetujui atau menolaknya, lalu
                        mencatat kondisi alat saat serah terima dan pengembalian.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-card">
                        <span class="role-chip">PEMINJAM</span>
                        <h3>Ajukan tanpa antre</h3>
                        <p>Mengajukan peminjaman alat langsung dari akun sendiri, dan memantau status
                        pengajuan serta jadwal pengembalian secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= ALUR PEMINJAMAN ================= --}}
    <section id="alur" class="py-5 py-lg-6" style="background: var(--sa-paper-dim);">
        <div class="container py-4">
            <div class="row mb-5">
                <div class="col-lg-7">
                    <div class="eyebrow mb-2">Alur Peminjaman</div>
                    <h2 class="fw-bold" style="color:var(--sa-ink);">Empat langkah, dari pengajuan sampai alat kembali</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-4">
                        <div class="flow-step">
                            <div class="step-num">1</div>
                            <h4>Ajukan peminjaman</h4>
                            <p>Peminjam memilih alat dan tanggal penggunaan, lalu mengirim pengajuan
                            melalui akunnya.</p>
                        </div>
                        <div class="flow-step">
                            <div class="step-num">2</div>
                            <h4>Diverifikasi petugas</h4>
                            <p>Petugas memeriksa ketersediaan alat dan menyetujui atau menolak
                            pengajuan tersebut.</p>
                        </div>
                        <div class="flow-step">
                            <div class="step-num">3</div>
                            <h4>Alat diserahkan</h4>
                            <p>Setelah disetujui, alat diserahkan dan statusnya berubah menjadi
                            sedang dipinjam.</p>
                        </div>
                        <div class="flow-step">
                            <div class="step-num">4</div>
                            <h4>Dikembalikan &amp; diverifikasi</h4>
                            <p>Alat dikembalikan, petugas mengecek kondisinya, dan status alat kembali
                            tersedia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= TENTANG ================= --}}
    <section id="tentang" class="py-5 py-lg-6">
        <div class="container py-4">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-5">
                    <div class="eyebrow mb-2">Tentang SiAlat</div>
                    <h2 class="fw-bold mb-3" style="color:var(--sa-ink);">Dibangun untuk kebutuhan sekolah</h2>
                    <p style="color:var(--sa-ink-soft);">
                        SiAlat dirancang agar pencatatan peminjaman alat laboratorium dan bengkel tidak
                        lagi bergantung pada buku catatan manual — setiap transaksi tersimpan rapi dan
                        mudah ditelusuri oleh admin maupun petugas.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="about-card">
                                <h3 class="h6 fw-bold" style="color:var(--sa-ink);">Tercatat digital</h3>
                                <p class="small mb-0" style="color:var(--sa-ink-soft);">Semua pengajuan dan riwayat peminjaman tersimpan dalam satu sistem.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="about-card">
                                <h3 class="h6 fw-bold" style="color:var(--sa-ink);">Peran yang jelas</h3>
                                <p class="small mb-0" style="color:var(--sa-ink-soft);">Admin, petugas, dan peminjam punya akses sesuai tanggung jawab masing-masing.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="about-card">
                                <h3 class="h6 fw-bold" style="color:var(--sa-ink);">Status real-time</h3>
                                <p class="small mb-0" style="color:var(--sa-ink-soft);">Ketersediaan alat selalu menunjukkan kondisi terkini.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="about-card">
                                <h3 class="h6 fw-bold" style="color:var(--sa-ink);">Mudah ditelusuri</h3>
                                <p class="small mb-0" style="color:var(--sa-ink-soft);">Riwayat peminjaman per alat maupun per pengguna dapat dicek kapan saja.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= CTA ================= --}}
    <section class="pb-5">
        <div class="container">
            <div class="cta-band p-4 p-lg-5 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <div class="eyebrow on-dark mb-2">Mulai sekarang</div>
                    <h2 class="fw-bold mb-0" style="font-size: 1.5rem;">Siap kelola peminjaman alat lebih rapi?</h2>
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ route('register') }}" class="btn btn-sa-primary">Daftar Akun</a>
                    <a href="{{ route('login') }}" class="btn btn-sa-outline" style="border-color:rgba(255,255,255,.35); color:#fff;">Masuk</a>
                </div>
            </div>
        </div>
    </section>

@endsection