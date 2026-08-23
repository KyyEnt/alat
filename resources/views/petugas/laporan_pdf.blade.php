<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Peminjaman Alat</title>

    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            background: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        .report-container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        /* =========================
           HEADER / KOP LAPORAN
        ========================== */

        .report-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 14px;
            border-bottom: 3px solid #4f46e5;
        }

        .logo {
            width: 58px;
            height: 58px;
            background: #4f46e5;
            color: white;
            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 28px;
            font-weight: bold;
        }

        .company-info {
            flex: 1;
        }

        .company-name {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: .3px;
        }

        .company-subtitle {
            margin: 3px 0 0;
            color: #64748b;
            font-size: 11px;
        }

        .report-code {
            text-align: right;
            font-size: 10px;
            color: #64748b;
        }

        .report-code strong {
            display: block;
            color: #1e293b;
            font-size: 12px;
        }

        /* =========================
           JUDUL
        ========================== */

        .report-title {
            text-align: center;
            margin: 22px 0 18px;
        }

        .report-title h1 {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #0f172a;
        }

        .report-title p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 11px;
        }

        /* =========================
           INFORMASI LAPORAN
        ========================== */

        .report-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;

            margin-bottom: 18px;
            padding: 12px 14px;

            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .info-label {
            color: #64748b;
        }

        .info-value {
            font-weight: 700;
            color: #334155;
            text-align: right;
        }

        /* =========================
           TABLE
        ========================== */

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
        }

        thead th {
            background: #4f46e5;
            color: #ffffff;

            padding: 10px 9px;

            font-size: 10px;
            font-weight: 700;

            text-align: left;
            text-transform: uppercase;
            letter-spacing: .4px;

            border-right: 1px solid rgba(255,255,255,.2);
        }

        thead th:last-child {
            border-right: none;
        }

        tbody td {
            padding: 9px;

            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;

            vertical-align: middle;
            color: #334155;
        }

        tbody td:last-child {
            border-right: none;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        tbody tr {
            page-break-inside: avoid;
        }

        .number {
            width: 40px;
            text-align: center;
            font-weight: 700;
            color: #64748b;
        }

        .borrower {
            font-weight: 600;
            color: #1e293b;
        }

        .tool-name {
            font-weight: 600;
            color: #334155;
        }

        .date {
            font-family: "Courier New", monospace;
            font-size: 10px;
            white-space: nowrap;
            color: #475569;
        }

        /* =========================
           STATUS
        ========================== */

        .status {
            display: inline-block;

            padding: 4px 9px;

            border-radius: 999px;

            font-size: 9px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .status-disetujui,
        .status-selesai {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .status-menunggu,
        .status-pending {
            color: #92400e;
            background: #fef3c7;
            border: 1px solid #fde68a;
        }

        .status-ditolak,
        .status-batal {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .status-default {
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        /* =========================
           EMPTY DATA
        ========================== */

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }

        /* =========================
           FOOTER
        ========================== */

        .report-footer {
            margin-top: 20px;
            padding-top: 10px;

            border-top: 1px solid #e2e8f0;

            display: flex;
            justify-content: space-between;

            color: #94a3b8;
            font-size: 9px;
        }

        /* =========================
           TANDA TANGAN
        ========================== */

        .signature {
            margin-top: 35px;

            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            width: 220px;
            text-align: center;
        }

        .signature-date {
            margin-bottom: 55px;
            color: #475569;
        }

        .signature-line {
            border-top: 1px solid #334155;
            padding-top: 5px;
            font-weight: 700;
        }

        .signature-role {
            margin-top: 3px;
            font-size: 10px;
            color: #64748b;
        }

        /* =========================
           PRINT
        ========================== */

        @media print {

            body {
                background: white;
            }

            .report-container {
                max-width: none;
            }

            .report-header {
                break-inside: avoid;
            }

            .report-title {
                break-inside: avoid;
            }

            .report-info {
                break-inside: avoid;
            }

            table {
                page-break-inside: auto;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

            .signature {
                break-inside: avoid;
            }

            .report-footer {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="report-container">

        <!-- =========================
             KOP LAPORAN
        ========================== -->

        <header class="report-header">

            <div class="logo">
                S
            </div>

            <div class="company-info">

                <h2 class="company-name">
                    {{ config('app.name', 'SiAlatKu') }}
                </h2>

                <p class="company-subtitle">
                    Sistem Informasi Peminjaman dan Pengelolaan Alat
                </p>

            </div>

            <div class="report-code">

                <span>Dokumen</span>

                <strong>
                    LAP-PEMINJAMAN
                </strong>

            </div>

        </header>


        <!-- =========================
             JUDUL LAPORAN
        ========================== -->

        <section class="report-title">

            <h1>
                Laporan Rekapitulasi Peminjaman Alat
            </h1>

            <p>
                Rekap data peminjaman alat yang tercatat dalam sistem
            </p>

        </section>


        <!-- =========================
             INFORMASI LAPORAN
        ========================== -->

        <section class="report-info">

            <div class="info-item">

                <span class="info-label">
                    Tanggal Cetak
                </span>

                <span class="info-value">
                    {{ now()->format('d-m-Y H:i') }}
                </span>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Total Peminjaman
                </span>

                <span class="info-value">
                    {{ $laporans->count() }} Data
                </span>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Periode
                </span>

                <span class="info-value">
                    Seluruh Data
                </span>

            </div>

            <div class="info-item">

                <span class="info-label">
                    Status Laporan
                </span>

                <span class="info-value">
                    Resmi
                </span>

            </div>

        </section>


        <!-- =========================
             TABEL LAPORAN
        ========================== -->

        <table>

            <thead>

                <tr>
                    <th class="number">No</th>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse($laporans as $key => $item)

                    @php
                        $statusKey = strtolower($item->status ?? '');

                        $statusClass = match ($statusKey) {
                            'disetujui' => 'status-disetujui',
                            'selesai' => 'status-selesai',
                            'menunggu' => 'status-menunggu',
                            'pending' => 'status-pending',
                            'ditolak' => 'status-ditolak',
                            'batal' => 'status-batal',
                            default => 'status-default',
                        };
                    @endphp

                    <tr>

                        <td class="number">
                            {{ $key + 1 }}
                        </td>

                        <td class="borrower">
                            {{ $item->user->name ?? $item->user->nama ?? '-' }}
                        </td>

                        <td class="tool-name">
                            {{ $item->alat->nama_alat ?? '-' }}
                        </td>

                        <td class="date">
                            {{ $item->created_at ? $item->created_at->format('d-m-Y H:i') : '-' }}
                        </td>

                        <td>
                            <span class="status {{ $statusClass }}">
                                {{ $item->status ?? '-' }}
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="empty">
                            Tidak ada data peminjaman yang tersedia.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


        <!-- =========================
             TANDA TANGAN
        ========================== -->

        <div class="signature">

            <div class="signature-box">

                <div class="signature-date">
                    {{ now()->translatedFormat('d F Y') }}
                </div>

                <div class="signature-line">
                    Petugas Sarana
                </div>

                <div class="signature-role">
                    Pengelola Peminjaman Alat
                </div>

            </div>

        </div>


        <!-- =========================
             FOOTER
        ========================== -->

        <footer class="report-footer">

            <span>
                {{ config('app.name', 'SiAlatKu') }}
            </span>

            <span>
                Dokumen dicetak secara otomatis oleh sistem
            </span>

            <span>
                v1.0
            </span>

        </footer>

    </div>

</body>

</html>