<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel header pemasukan harian toko sembako.
     */
    public function up(): void
    {
        Schema::create('pemasukan_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->index()->comment('Tanggal pemasukan dicatat');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()
                ->comment('Pemilik toko yang mencatat pemasukan');
            $table->string('metode_bayar', 50)->default('tunai')->comment('tunai | transfer | qris');
            $table->decimal('total_pemasukan', 15, 2)->default(0)->comment('Total subtotal dari detail_pemasukan');
            $table->text('catatan')->nullable()->comment('Catatan tambahan opsional');
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel pemasukan_harian jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukan_harian');
    }
};