<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'kode_peminjaman',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_rencana_kembali' => 'date',
    ];

    /**
     * Peminjaman dimiliki oleh satu user/peminjam.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu peminjaman memiliki banyak detail alat.
     */
    public function detailPeminjamans(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }

    /**
     * Satu peminjaman memiliki satu pengembalian.
     */
    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    /**
     * Helper status peminjaman.
     */
    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isDisetujui(): bool
    {
        return $this->status === 'disetujui';
    }

    public function isDipinjam(): bool
    {
        return $this->status === 'dipinjam';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }
}