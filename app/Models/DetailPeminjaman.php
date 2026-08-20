<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjamans';

    protected $fillable = [
        'peminjaman_id',
        'alat_id',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    /**
     * Detail peminjaman milik satu peminjaman.
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Detail peminjaman berkaitan dengan satu alat.
     */
    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }
}