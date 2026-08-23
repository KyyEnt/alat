<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    // ==========================================
    // HALAMAN PERSETUJUAN PEMINJAMAN
    // ==========================================
    public function menyetujuiPeminjaman()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
        ->whereRaw('LOWER(status) = ?', ['menunggu'])
        ->latest()
        ->get();

        return view('petugas.persetujuan', [
            'peminjamans' => $peminjamans
        ]);
    }


    // ==========================================
    // PROSES PERSETUJUAN
    // ==========================================
    public function prosesPersetujuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => strtolower($request->status),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status pengajuan peminjaman berhasil diperbarui.');
    }


    public function showPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        return view('petugas.peminjaman-detail', compact('peminjaman'));
    }

    // ==========================================
    // HALAMAN PEMANTAUAN
    // ==========================================
    public function memantauPengembalian()
    {
        $peminjamans = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
        ->latest()
        ->get();

        return view('petugas.pemantauan')
            ->with('peminjamans', $peminjamans);
    }


    // ==========================================
    // LAPORAN
    // ==========================================
    public function cetakLaporan()
    {
        $laporans = Peminjaman::with([
            'user',
            'detailPeminjamans.alat'
        ])
        ->latest()
        ->get();

        return view('petugas.laporan_pdf', [
            'laporans' => $laporans
        ]);
    }
}