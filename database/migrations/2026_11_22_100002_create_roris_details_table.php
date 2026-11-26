<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel rincian RORIS per barang (snapshot — tanpa FK ke barang,
     * siap di-upgrade dengan nullable barang_id saat tabel barang Rizki tersedia).
     */
    public function up(): void
    {
        Schema::create('roris_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roris_id')->constrained('roris')->cascadeOnDelete();

            // --- Snapshot identitas barang (tidak bergantung tabel barang Rizki) ---
            // Saat tabel barang sudah ada, tambahkan: $table->foreignId('barang_id')->nullable()->constrained('barang')->nullOnDelete();
            $table->string('kode_barang')->comment('Snapshot kode barang saat RORIS');
            $table->string('nama_barang')->comment('Snapshot nama barang saat RORIS');
            $table->string('satuan')->comment('Snapshot nama satuan saat RORIS');

            // --- Data pengecekan fisik ---
            $table->decimal('qty_fisik', 12, 2)->comment('Jumlah stok fisik yang dihitung');

            // --- Snapshot harga saat RORIS dilakukan ---
            $table->decimal('harga_modal', 15, 2)->comment('Harga beli per unit saat RORIS');
            $table->decimal('harga_jual', 15, 2)->comment('Harga jual per unit saat RORIS');

            // --- Kalkulasi (disimpan agar laporan historis tidak berubah) ---
            $table->decimal('subtotal_modal', 15, 2)->comment('qty_fisik × harga_modal');
            $table->decimal('subtotal_pendapatan', 15, 2)->comment('qty_fisik × harga_jual');

            $table->timestamps();

            // Satu barang (kode) tidak boleh dobel dalam satu RORIS
            $table->unique(['roris_id', 'kode_barang'], 'uq_roris_kode_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roris_details');
    }
};
