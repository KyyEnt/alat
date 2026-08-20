<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'role_id',
    'name',
    'email',
    'password',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * User memiliki banyak data peminjaman.
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * User memiliki banyak log aktivitas.
     */
    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class);
    }

    /**
     * Mengecek role user dengan penanganan Null-Safe.
     */
    public function hasRole(string $role): bool
    {
        // Menggunakan optional chaining (?->) agar tidak error jika role bernilai null
        return strtolower($this->role?->nama_role ?? '') === strtolower($role);
    }

    /**
     * Mengecek apakah user adalah Admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Mengecek apakah user adalah Petugas.
     */
    public function isPetugas(): bool
    {
        return $this->hasRole('petugas');
    }

    /**
     * Mengecek apakah user adalah Peminjam.
     */
    public function isPeminjam(): bool
    {
        return $this->hasRole('peminjam');
    }
}