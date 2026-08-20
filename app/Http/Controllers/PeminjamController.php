<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class PeminjamController extends Controller
{
    /**
     * Tarif denda per hari keterlambatan.
     * TODO: sesuaikan/pindahkan ke config('app.tarif_denda') kalau mau lebih fleksibel.
     */
    private const TARIF_DENDA_PER_HARI = 5000;

    /**
     * Daftar peminjaman milik peminjam yang sedang login.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['detailPeminjamans.alat'])
            ->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->paginate(10);

        return view('peminjam.index', compact('peminjamans'));
    }

    /**
     * Daftar semua alat yang tersedia (fitur "Melihat daftar alat").
     */
    public function daftarAlat()
    {
        $alats = Alat::where('stok', '>', 0)->get();

        return view('peminjam.alat.index', compact('alats'));
    }

    /**
     * Form pengajuan peminjaman baru.
     */
    public function create()
    {
        $alats = Alat::where('stok', '>', 0)->get();

        return view('peminjam.create', compact('alats'));
    }

    /**
     * Menyimpan pengajuan peminjaman baru (mendukung banyak alat sekaligus).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_pinjam'           => 'required|date|after_or_equal:today',
            'tanggal_rencana_kembali'  => 'required|date|after:tanggal_pinjam',
            'keterangan'               => 'nullable|string|max:255',
            'items'                    => 'required|array|min:1',
            'items.*.alat_id'          => 'required|exists:alats,id',
            'items.*.jumlah'           => 'required|integer|min:1',
        ]);

        try {
            $peminjaman = DB::transaction(function () use ($validated) {

                // Validasi stok untuk setiap alat SEBELUM menyimpan apa pun
                foreach ($validated['items'] as $item) {
                    $alat = Alat::lockForUpdate()->findOrFail($item['alat_id']);

                    if ($alat->stok < $item['jumlah']) {
                        throw ValidationException::withMessages([
                            'items' => "Stok {$alat->nama_alat} tidak mencukupi. Sisa stok: {$alat->stok}.",
                        ]);
                    }
                }

                $peminjaman = Peminjaman::create([
                    'user_id'                 => Auth::id(),
                    'kode_peminjaman'          => 'PJM-' . strtoupper(Str::random(8)),
                    'tanggal_pinjam'           => $validated['tanggal_pinjam'],
                    'tanggal_rencana_kembali'  => $validated['tanggal_rencana_kembali'],
                    'status'                   => 'menunggu',
                    'keterangan'               => $validated['keterangan'] ?? null,
                ]);

                // Stok BELUM dikurangi di sini — baru dikurangi saat petugas approve
                foreach ($validated['items'] as $item) {
                    DetailPeminjaman::create([
                        'peminjaman_id' => $peminjaman->id,
                        'alat_id'       => $item['alat_id'],
                        'jumlah'        => $item['jumlah'],
                    ]);
                }

                return $peminjaman;
            });

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        return redirect()
            ->route('peminjam.peminjaman.show', $peminjaman->id)
            ->with('success', 'Pengajuan peminjaman berhasil dikirim, menunggu persetujuan petugas.');
    }

    /**
     * Detail satu peminjaman milik peminjam yang login.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['detailPeminjamans.alat', 'pengembalian'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('peminjam.show', compact('peminjaman'));
    }

    /**
     * Peminjam mengembalikan alat + sistem menghitung denda otomatis.
     * Hanya bisa dilakukan kalau status peminjaman = "dipinjam" dan
     * peminjaman ini memang milik user yang login.
     */
    public function kembalikanAlat(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $peminjaman = Peminjaman::with('detailPeminjamans')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Alat ini tidak sedang berstatus dipinjam.');
        }

        if ($peminjaman->pengembalian()->exists()) {
            return back()->with('error', 'Peminjaman ini sudah pernah dikembalikan.');
        }

        DB::transaction(function () use ($peminjaman, $validated) {
            $tanggalKembali  = Carbon::parse($validated['tanggal_kembali']);
            $rencanaKembali  = Carbon::parse($peminjaman->tanggal_rencana_kembali);

            $terlambatHari = $tanggalKembali->gt($rencanaKembali)
                ? $rencanaKembali->diffInDays($tanggalKembali)
                : 0;

            $denda = $terlambatHari * self::TARIF_DENDA_PER_HARI;

            Pengembalian::create([
                'peminjaman_id'   => $peminjaman->id,
                'tanggal_kembali' => $tanggalKembali,
                'terlambat_hari'  => $terlambatHari,
                'denda'           => $denda,
            ]);

            // Kembalikan stok — pasangan dari pengurangan stok saat approve()
            foreach ($peminjaman->detailPeminjamans as $detail) {
                Alat::where('id', $detail->alat_id)->increment('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dikembalikan']);
        });

        return redirect()
            ->route('peminjam.peminjaman.show', $peminjaman->id)
            ->with('success', 'Alat berhasil dikembalikan.');
    }
}