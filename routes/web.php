<?php

use App\Http\Controllers\Admin\RoleAccessController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Kelola.in (Sistem Informasi Toko Sembako)
|--------------------------------------------------------------------------
*/

// Halaman utama: jika belum login arahkan ke login, jika sudah login arahkan sesuai role
Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $roleSlug = Auth::user()->role?->slug;

    return match ($roleSlug) {
        'admin' => redirect()->route('admin.dashboard'),
        'pemilik_toko' => redirect()->route('pemilik.dashboard'),
        'karyawan' => redirect()->route('karyawan.dashboard'),
        default => redirect()->route('login'),
    };
});

// 1. Modul Autentikasi & Hak Akses (Fadilah)
require __DIR__.'/modules/auth.php';

// 2. Rute Terproteksi Sesi (Harus Login)
Route::middleware(['auth'])->group(function () {

    // Modul Profil Pengguna (Dapat diakses oleh Admin, Pemilik Toko, dan Karyawan)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // -------------------------------------------------------------
    // RUTE KHUSUS ROLE ADMIN (Manajemen Pengguna, Otorisasi, & Sistem)
    // -------------------------------------------------------------
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $totalUsers = \App\Models\User::count();
            $activeUsers = \App\Models\User::where('is_active', true)->count();
            $inactiveUsers = \App\Models\User::where('is_active', false)->count();

            // Ringkasan sistem: jumlah user per peran (Admin, Pemilik Toko, Karyawan)
            $roleCounts = [
                'admin' => \App\Models\User::whereHas('role', fn ($q) => $q->where('slug', 'admin'))->count(),
                'pemilik_toko' => \App\Models\User::whereHas('role', fn ($q) => $q->where('slug', 'pemilik_toko'))->count(),
                'karyawan' => \App\Models\User::whereHas('role', fn ($q) => $q->where('slug', 'karyawan'))->count(),
            ];

            // Aktivitas terbaru: 5 user yang terakhir dibuat
            $recentUsers = \App\Models\User::with('role')->latest()->take(5)->get();

            return view('dashboard.admin', compact(
                'totalUsers',
                'activeUsers',
                'inactiveUsers',
                'roleCounts',
                'recentUsers'
            ));
        })->name('dashboard');

        // Modul 1: Kelola Data Pengguna (CRUD & Toggle Status)
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::resource('users', UserController::class);

        // Modul 2: Kelola Hak Akses Pengguna (Role Assignment)
        Route::get('/hak-akses', [RoleAccessController::class, 'index'])->name('hak-akses.index');
        Route::get('/hak-akses/{user}/edit', [RoleAccessController::class, 'edit'])->name('hak-akses.edit');
        Route::put('/hak-akses/{user}', [RoleAccessController::class, 'update'])->name('hak-akses.update');
    });

    // -------------------------------------------------------------
    // RUTE KHUSUS ROLE PEMILIK TOKO (Eksekutif & Laporan)
    // -------------------------------------------------------------
    Route::middleware(['role:pemilik_toko'])->prefix('pemilik')->name('pemilik.')->group(function () {
        Route::get('/dashboard', function () {
            // Data Pemasukan untuk Dashboard Pemilik (Immanuel)
            $pemasukanHariIni = \App\Models\Pemasukan::whereDate('tanggal', today())->sum('total_pemasukan');
            $totalTransaksiHariIni = \App\Models\Pemasukan::whereDate('tanggal', today())->count();
            $riwayatPemasukan = \App\Models\Pemasukan::with('user')
                ->withCount('details')
                ->orderByDesc('tanggal')
                ->orderByDesc('id')
                ->take(5)
                ->get();

            return view('dashboard.pemilik', compact(
                'pemasukanHariIni',
                'totalTransaksiHariIni',
                'riwayatPemasukan'
            ));
        })->name('dashboard');  

        // Modul RORIS (Nadrina)
        require __DIR__.'/modules/roris.php';

        // Modul Pemasukan Harian (Immanuel)
        require __DIR__.'/modules/pemasukan.php';
    });

    // -------------------------------------------------------------
    // RUTE KHUSUS ROLE KARYAWAN (Kasir & Operasional)
    // -------------------------------------------------------------
    Route::middleware(['role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.karyawan');
        })->name('dashboard');
    });

    require __DIR__.'/modules/barang.php';

});
