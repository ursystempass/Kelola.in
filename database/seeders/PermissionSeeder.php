<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Kelola Pengguna', 'slug' => 'kelola-user'],
            ['name' => 'Kelola Hak Akses', 'slug' => 'kelola-role-permission'],

            ['name' => 'Kelola Kategori Barang', 'slug' => 'kelola-kategori'],
            ['name' => 'Kelola Satuan Barang', 'slug' => 'kelola-satuan'],
            ['name' => 'Kelola Barang', 'slug' => 'kelola-barang'],
            ['name' => 'Lihat Katalog Barang', 'slug' => 'lihat-barang'],

            ['name' => 'Kelola Pengadaan RORIS', 'slug' => 'kelola-roris'],
            ['name' => 'Lihat Laporan RORIS', 'slug' => 'lihat-laporan-roris'],

            ['name' => 'Input Transaksi Kasir', 'slug' => 'input-transaksi'],
            ['name' => 'Lihat Pemasukan Harian', 'slug' => 'lihat-pemasukan'],
            ['name' => 'Lihat Laporan Pemasukan', 'slug' => 'lihat-laporan-pemasukan'],
            ['name' => 'Lihat Dashboard', 'slug' => 'lihat-dashboard'],
        ];

        // PERBAIKAN: Menggunakan updateOrCreate agar nama permission ikut diperbarui jika slug sudah tersedia.
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }

        $adminRole = Role::where('slug', 'admin')->first();
        $pemilikRole = Role::where('slug', 'pemilik_toko')->first();
        $karyawanRole = Role::where('slug', 'karyawan')->first();

        // PERBAIKAN: Admin hanya mendapatkan akses untuk mengelola pengguna dan hak akses.
        if ($adminRole) {
            $adminPermissions = Permission::whereIn('slug', [
                'kelola-user',
                'kelola-role-permission',
            ])->pluck('id')->toArray();

            // PERBAIKAN: Menggunakan sync() agar permission lama yang tidak sesuai ikut dilepas.
            $adminRole->permissions()->sync($adminPermissions);
        }

        if ($pemilikRole) {
            $pemilikPermissions = Permission::whereIn('slug', [
                'lihat-dashboard',
                'lihat-pemasukan',
                'lihat-laporan-pemasukan',
                'lihat-barang',
                'kelola-roris',
                'lihat-laporan-roris',
            ])->pluck('id')->toArray();

            // PERBAIKAN: Menyamakan seluruh permission Pemilik Toko dengan hak akses yang ditentukan.
            $pemilikRole->permissions()->sync($pemilikPermissions);
        }

        if ($karyawanRole) {
            $karyawanPermissions = Permission::whereIn('slug', [
                'lihat-barang',
                'input-transaksi',
                'lihat-pemasukan',
            ])->pluck('id')->toArray();

            // PERBAIKAN: Menyamakan seluruh permission Karyawan dengan hak akses operasionalnya.
            $karyawanRole->permissions()->sync($karyawanPermissions);
        }
    }
}
