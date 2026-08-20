<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tambahkan Role (Ubah 'name' menjadi 'nama_role')
        $admin = Role::create(['nama_role' => 'admin']);
        $petugas = Role::create(['nama_role' => 'petugas']);
        $peminjam = Role::create(['nama_role' => 'peminjam']);

        // 2. Tambahkan User Default
        User::create([
            'role_id'  => $admin->id,
            'name'     => 'Admin Sialatku',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id'  => $petugas->id,
            'name'     => 'Petugas Lab',
            'email'    => 'petugas@gmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id'  => $peminjam->id,
            'name'     => 'Siswa Peminjam',
            'email'    => 'peminjam@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}