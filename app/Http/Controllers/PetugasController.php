<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // Fitur 1: Menyetujui Peminjaman (Tampilan Halaman Utama / Index Petugas)
    public function menyetujuiPeminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'Menunggu')
            ->latest()
            ->get();

        return view('petugas.persetujuan', compact('peminjamans'));
    }

    // Proses Aksi Persetujuan / Penolakan
    public function prosesPersetujuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($request->status === 'Disetujui') {
            if ($peminjaman->alat->stok < 1) {
                return redirect()->back()->with('error', 'Stok alat tidak mencukupi untuk disetujui.');
            }
            // Kurangi stok alat secara otomatis
            $peminjaman->alat->decrement('stok');
        }

        $peminjaman->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pengajuan peminjaman berhasil diperbarui.');
    }

    // Fitur 2: Memantau Pengembalian
    public function memantauPengembalian()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['Disetujui', 'Dikembalikan'])
            ->latest()
            ->get();

        return view('petugas.pemantauan', compact('peminjamans'));
    }

    // Fitur 3: Mencetak Laporan Peminjaman
    public function cetakLaporan()
    {
        $laporans = Peminjaman::with(['user', 'alat'])->latest()->get();

        return view('petugas.laporan_pdf', compact('laporans'));
    }
}