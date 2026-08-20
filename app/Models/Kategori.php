<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    /**
     * Satu kategori memiliki banyak alat.
     */
    public function alats(): HasMany
    {
        return $this->hasMany(Alat::class);
    }
}