<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->latest()->paginate(10);
        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi' => 'nullable|string',
        ]);

        Alat::create([
            'kategori_id' => $request->kategori_id,
            'kode_alat' => $this->generateKodeAlat(),
            'nama_alat' => $request->nama_alat,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan');
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi' => 'nullable|string',
        ]);

        $alat->update($request->only(['kategori_id', 'nama_alat', 'stok', 'kondisi', 'deskripsi']));

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil diperbarui');
    }

    public function destroy(Alat $alat)
    {
        if ($alat->detailPeminjamans()->exists()) {
            return redirect()->route('admin.alat.index')
                ->with('error', 'Alat tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $alat->delete();
        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus');
    }

    /**
     * Generate kode_alat unik dengan format ALT-0001.
     */
    private function generateKodeAlat(): string
    {
        $last = Alat::orderByDesc('id')->first();
        $nextNumber = $last ? ((int) substr($last->kode_alat, 4)) + 1 : 1;

        return 'ALT-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}