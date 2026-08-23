<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data peminjaman beserta relasinya
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])->latest()->get();

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'detailPeminjaman.alat'])->findOrFail($id);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }
}