<?php

use App\Http\Controllers\Pemilik\DashboardRorisController;
use App\Http\Controllers\Pemilik\LaporanRorisController;
use App\Http\Controllers\Pemilik\RorisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul RORIS — Nadrina (Kelompok 5D)
|--------------------------------------------------------------------------
| Semua route di sini dilindungi oleh middleware role:pemilik_toko
| yang sudah didaftarkan di routes/web.php (grup pemilik).
|
| File ini di-require oleh routes/web.php di dalam grup
| middleware(['auth', 'role:pemilik_toko']) prefix('pemilik') name('pemilik.').
*/

// ── Riwayat & Input RORIS (SKPL-F-12, F-13) ──────────────────────────────────
Route::get('/roris', [RorisController::class, 'index'])->name('roris.index');
Route::get('/roris/tambah', [RorisController::class, 'create'])->name('roris.create');
Route::post('/roris', [RorisController::class, 'store'])->name('roris.store');
Route::get('/roris/{roris}', [RorisController::class, 'show'])->name('roris.show');

// ── Laporan RORIS (SKPL-F-14) ─────────────────────────────────────────────────
Route::get('/laporan-roris', [LaporanRorisController::class, 'index'])->name('roris.laporan');
Route::get('/laporan-roris/pdf', [LaporanRorisController::class, 'pdf'])->name('roris.laporan.pdf');
Route::get('/laporan-roris/excel', [LaporanRorisController::class, 'excel'])->name('roris.laporan.excel');

// ── Endpoint Grafik RORIS untuk Dashboard Pemilik (SKPL-F-19) ────────────────
Route::get('/dashboard/grafik-roris', [DashboardRorisController::class, 'grafik'])->name('grafik.roris');
