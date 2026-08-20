<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah dari 'detail_peminjamans' menjadi 'pengembalians'
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();

            // Menghubungkan ke tabel peminjamans
            $table->foreignId('peminjaman_id')
                ->constrained('peminjamans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('tanggal_pengembalian');
            $table->string('denda')->default(0);
            $table->enum('status', ['dikembalikan', 'terlambat'])->default('dikembalikan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Ubah dari 'detail_peminjamans' menjadi 'pengembalians'
        Schema::dropIfExists('pengembalians');
    }
};