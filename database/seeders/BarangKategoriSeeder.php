<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriSatuan;
use Illuminate\Database\Seeder;

class BarangKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $satuans = [
            ['nama_satuan' => 'Kg', 'deskripsi' => 'Satuan berat kilogram untuk beras, gula, dan telur'],
            ['nama_satuan' => 'Liter', 'deskripsi' => 'Satuan volume cair untuk minyak goreng dan sirup'],
            ['nama_satuan' => 'Pcs', 'deskripsi' => 'Satuan eceran per bungkus, botol, atau kaleng'],
            ['nama_satuan' => 'Dus', 'deskripsi' => 'Satuan karton grosir (mi instan, air mineral)'],
            ['nama_satuan' => 'Karung', 'deskripsi' => 'Satuan kemasan besar 25 kg atau 50 kg'],
            ['nama_satuan' => 'Renteng', 'deskripsi' => 'Satuan sachet rentengan kopi atau bumbu'],
        ];

        $satuanMap = [];
        foreach ($satuans as $item) {
            $satuan = KategoriSatuan::firstOrCreate(
                ['nama_satuan' => $item['nama_satuan']],
                ['deskripsi' => $item['deskripsi']]
            );
            $satuanMap[$item['nama_satuan']] = $satuan->id;
        }

        $barangs = [
            [
                'kode_barang' => 'BRG-001',
                'nama_barang' => 'Beras Ramos Setra 5 Kg',
                'kategori_satuan_id' => $satuanMap['Pcs'],
                'harga_beli' => 68000,
                'harga_jual' => 75000,
                'stok' => 24,
                'stok_minimum' => 5,
            ],
            [
                'kode_barang' => 'BRG-002',
                'nama_barang' => 'Gula Pasir Putih Curah',
                'kategori_satuan_id' => $satuanMap['Kg'],
                'harga_beli' => 15500,
                'harga_jual' => 17500,
                'stok' => 30,
                'stok_minimum' => 10,
            ],
            [
                'kode_barang' => 'BRG-003',
                'nama_barang' => 'Minyak Goreng Kita 1L',
                'kategori_satuan_id' => $satuanMap['Liter'],
                'harga_beli' => 14500,
                'harga_jual' => 16500,
                'stok' => 18,
                'stok_minimum' => 6,
            ],
            [
                'kode_barang' => 'BRG-004',
                'nama_barang' => 'Telur Ayam Negeri',
                'kategori_satuan_id' => $satuanMap['Kg'],
                'harga_beli' => 26000,
                'harga_jual' => 29000,
                'stok' => 4,
                'stok_minimum' => 5,
            ],
            [
                'kode_barang' => 'BRG-005',
                'nama_barang' => 'Indomie Goreng Original (1 Dus)',
                'kategori_satuan_id' => $satuanMap['Dus'],
                'harga_beli' => 112000,
                'harga_jual' => 122000,
                'stok' => 12,
                'stok_minimum' => 3,
            ],
            [
                'kode_barang' => 'BRG-006',
                'nama_barang' => 'Kopi Kapal Api Mix (10 Sachet)',
                'kategori_satuan_id' => $satuanMap['Renteng'],
                'harga_beli' => 13000,
                'harga_jual' => 15000,
                'stok' => 15,
                'stok_minimum' => 5,
            ],
        ];

        foreach ($barangs as $barang) {
            Barang::firstOrCreate(
                ['kode_barang' => $barang['kode_barang']],
                $barang
            );
        }
    }
}