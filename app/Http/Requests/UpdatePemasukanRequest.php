<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePemasukanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('pemilik_toko') ?? false;
    }

    public function rules(): array
    {
        return [
            'tanggal'                => ['required', 'date', 'date_format:Y-m-d'],
            'metode_bayar'           => ['required', 'in:tunai,transfer,qris'],
            'catatan'                => ['nullable', 'string', 'max:1000'],

            'details'                => ['required', 'array', 'min:1'],
            'details.*.nama_barang'  => ['required', 'string', 'max:255'],
            'details.*.satuan'       => ['required', 'string', 'max:50'],
            'details.*.qty'          => ['required', 'numeric', 'min:0.01'],
            'details.*.harga_satuan' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required'                => 'Tanggal pemasukan wajib diisi.',
            'tanggal.date'                    => 'Format tanggal tidak valid.',
            'metode_bayar.required'           => 'Metode bayar wajib dipilih.',
            'metode_bayar.in'                 => 'Metode bayar harus Tunai, Transfer, atau QRIS.',
            'details.required'                => 'Minimal harus ada satu baris barang.',
            'details.min'                     => 'Minimal harus ada satu baris barang.',
            'details.*.nama_barang.required'  => 'Nama barang wajib diisi pada baris :position.',
            'details.*.satuan.required'       => 'Satuan wajib diisi pada baris :position.',
            'details.*.qty.required'          => 'Jumlah (qty) wajib diisi pada baris :position.',
            'details.*.qty.numeric'           => 'Jumlah (qty) harus berupa angka pada baris :position.',
            'details.*.qty.min'               => 'Jumlah (qty) minimal 0.01 pada baris :position.',
            'details.*.harga_satuan.required' => 'Harga satuan wajib diisi pada baris :position.',
            'details.*.harga_satuan.numeric'  => 'Harga satuan harus berupa angka pada baris :position.',
            'details.*.harga_satuan.min'      => 'Harga satuan tidak boleh negatif pada baris :position.',
        ];
    }
}