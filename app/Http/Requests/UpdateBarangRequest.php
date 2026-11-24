<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
        $barangId = $this->route('barang')->id;

        return [
            'kategori_satuan_id' => 'required|exists:kategori_satuans,id',
            'kode_barang'        => 'required|string|max:30|unique:barangs,kode_barang,' . $barangId,
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
            'kode_barang.required'        => 'Kode barang wajib diisi.',
            'kode_barang.unique'          => 'Kode barang sudah digunakan oleh barang lain.',
            'nama_barang.required'        => 'Nama barang wajib diisi.',
            'harga_beli.integer'          => 'Harga beli harus berupa bilangan bulat.',
            'harga_jual.integer'          => 'Harga jual harus berupa bilangan bulat.',
            'harga_jual.gte'              => 'Harga jual tidak boleh lebih rendah dari harga beli.',
            'stok.min'                    => 'Stok tidak boleh negatif.',
        ];
    }
}