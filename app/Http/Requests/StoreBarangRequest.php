<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode_barang' => strtoupper(trim((string) $this->kode_barang)),
            'nama_barang' => trim((string) $this->nama_barang),
        ]);
    }

    public function rules(): array
    {
        return [
            'kategori_satuan_id' => 'required|exists:kategori_satuans,id',
            'kode_barang'        => 'required|string|max:30|unique:barangs,kode_barang',
            'nama_barang'        => 'required|string|max:150',
            'harga_beli'         => 'required|integer|min:0',
            'harga_jual'         => 'required|integer|min:0|gte:harga_beli',
            'stok'               => 'required|integer|min:0',
            'stok_minimum'       => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_satuan_id.required' => 'Kategori satuan wajib dipilih.',
            'kategori_satuan_id.exists'   => 'Kategori satuan tidak ditemukan.',
            'kode_barang.required'        => 'Kode barang wajib diisi.',
            'kode_barang.unique'          => 'Kode barang sudah terdaftar.',
            'nama_barang.required'        => 'Nama barang wajib diisi.',
            'harga_beli.required'         => 'Harga beli wajib diisi.',
            'harga_beli.integer'          => 'Harga beli harus berupa bilangan bulat.',
            'harga_jual.required'         => 'Harga jual wajib diisi.',
            'harga_jual.integer'          => 'Harga jual harus berupa bilangan bulat.',
            'harga_jual.gte'              => 'Harga jual tidak boleh lebih rendah dari harga beli.',
            'stok.required'               => 'Stok wajib diisi.',
            'stok.min'                    => 'Stok tidak boleh negatif.',
            'stok_minimum.required'       => 'Stok minimum wajib diisi.',
        ];
    }
}