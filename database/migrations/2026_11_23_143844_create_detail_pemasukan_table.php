<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel rincian item per pemasukan harian.
     * Kolom barang_id dibuat nullable tanpa foreign key dulu karena tabel barang
     * (modul Rizki) belum tersedia; siap ditambahkan constraint saat sudah merge.
     */
    public function up(): void
    {
        Schema::create('detail_pemasukan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemasukan_harian_id')->constrained('pemasukan_harian')->cascadeOnDelete();

            // Siap dihubungkan ke tabel barang saat branch barang sudah di-merge
            $table->unsignedBigInteger('barang_id')->nullable()->index()
                ->comment('Relasi opsional ke tabel barang');

            // Snapshot data barang agar riwayat pemasukan tetap akurat jika master barang berubah
            $table->string('nama_barang', 255)->comment('Nama barang saat transaksi');
            $table->string('satuan', 50)->comment('Satuan barang saat transaksi');
            $table->decimal('qty', 12, 2)->comment('Jumlah barang terjual');
            $table->decimal('harga_satuan', 15, 2)->comment('Harga jual per satuan saat transaksi');
            $table->decimal('subtotal', 15, 2)->comment('qty x harga_satuan');
            $table->timestamps();
        });
    }

    /**
     * Hapus tabel detail_pemasukan jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemasukan');
    }
};