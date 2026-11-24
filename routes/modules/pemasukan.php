<?php

use App\Http\Controllers\Pemilik\PemasukanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul Pemasukan Harian — Immanuel
|--------------------------------------------------------------------------
| Semua route di sini dilindungi oleh middleware role:pemilik_toko
| yang sudah didaftarkan di routes/web.php (grup pemilik).
*/

Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
Route::get('/pemasukan/tambah', [PemasukanController::class, 'create'])->name('pemasukan.create');
Route::post('/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
Route::get('/pemasukan/riwayat', [PemasukanController::class, 'riwayat'])->name('pemasukan.riwayat');
Route::get('/pemasukan/{pemasukan}', [PemasukanController::class, 'show'])->name('pemasukan.show');
Route::get('/pemasukan/{pemasukan}/edit', [PemasukanController::class, 'edit'])->name('pemasukan.edit');
Route::put('/pemasukan/{pemasukan}', [PemasukanController::class, 'update'])->name('pemasukan.update');