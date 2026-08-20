<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'kategori_id',
        'kode_alat',
        'nama_alat',
        'stok',
        'kondisi',
        'deskripsi',
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    /**
     * Alat dimiliki oleh satu kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Alat dapat muncul di banyak detail peminjaman.
     */
    public function detailPeminjamans(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class);
    }

    /**
     * Mengecek apakah stok alat mencukupi.
     */
    public function stokCukup(int $jumlah): bool
    {
        return $this->stok >= $jumlah;
    }
}