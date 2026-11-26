<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Tabel header RORIS (stok opname / pengecekan barang).
     */
    public function up(): void
    {
        Schema::create('roris', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->comment('Tanggal pelaksanaan RORIS');
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete()
                ->comment('Pemilik toko yang membuat RORIS');
            $table->decimal('total_modal', 15, 2)->default(0)->comment('Σ subtotal_modal semua detail');
            $table->decimal('total_pendapatan', 15, 2)->default(0)->comment('Σ subtotal_pendapatan semua detail');
            $table->decimal('nilai_roris', 15, 2)->default(0)->comment('total_pendapatan - total_modal');
            $table->text('catatan')->nullable()->comment('Catatan opsional dari Pemilik Toko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roris');
    }
};
