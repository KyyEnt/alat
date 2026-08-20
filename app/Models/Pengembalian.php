<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'terlambat_hari',
        'denda',
        'kondisi_kembali',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'terlambat_hari' => 'integer',
        'denda' => 'decimal:2',
    ];

    /**
     * Pengembalian berkaitan dengan satu peminjaman.
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Menghitung denda berdasarkan jumlah hari keterlambatan.
     */
    public function hitungDenda(float $dendaPerHari = 5000): float
    {
        return $this->terlambat_hari * $dendaPerHari;
    }
}