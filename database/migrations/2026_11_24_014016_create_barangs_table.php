<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_satuan_id')->constrained('kategori_satuans')->restrictOnDelete();
            $table->string('kode_barang', 30)->unique();
            $table->string('nama_barang', 150);
            $table->unsignedBigInteger('harga_beli')->default(0);
            $table->unsignedBigInteger('harga_jual');
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('stok_minimum')->default(5);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};