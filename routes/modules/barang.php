<?php

use App\Http\Controllers\Admin\KategoriSatuanController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Modul Kelola Kategori Satuan (Khusus Admin)
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('kategori-satuan', KategoriSatuanController::class)
                ->except(['show']);
        });

    // Modul Kelola Data Barang (Karyawan & Pemilik Toko)
    Route::middleware(['role:pemilik,karyawan'])->group(function () {
        Route::resource('barang', BarangController::class)
            ->except(['show']);
    });
});