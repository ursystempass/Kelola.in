<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRorisRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Akses sudah dijaga oleh middleware role:pemilik_toko di routes/web.php
        return $this->user()?->hasRole('pemilik_toko') ?? false;
    }

    public function rules(): array
    {
        return [
            'tanggal'                      => ['required', 'date', 'date_format:Y-m-d'],
            'catatan'                      => ['nullable', 'string', 'max:1000'],

            // Detail baris-baris barang
            'details'                      => ['required', 'array', 'min:1'],
            'details.*.kode_barang'        => ['required', 'string', 'max:100'],
            'details.*.nama_barang'        => ['required', 'string', 'max:255'],
            'details.*.satuan'             => ['required', 'string', 'max:50'],
            'details.*.qty_fisik'          => ['required', 'numeric', 'min:0'],
            'details.*.harga_modal'        => ['required', 'numeric', 'min:0'],
            'details.*.harga_jual'         => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required'                   => 'Tanggal RORIS wajib diisi.',
            'tanggal.date'                        => 'Format tanggal tidak valid.',
            'details.required'                   => 'Minimal harus ada satu baris barang.',
            'details.min'                        => 'Minimal harus ada satu baris barang.',
            'details.*.kode_barang.required'     => 'Kode barang wajib diisi pada baris :position.',
            'details.*.nama_barang.required'     => 'Nama barang wajib diisi pada baris :position.',
            'details.*.satuan.required'          => 'Satuan wajib diisi pada baris :position.',
            'details.*.qty_fisik.required'       => 'Qty fisik wajib diisi pada baris :position.',
            'details.*.qty_fisik.numeric'        => 'Qty fisik harus berupa angka pada baris :position.',
            'details.*.qty_fisik.min'            => 'Qty fisik tidak boleh negatif pada baris :position.',
            'details.*.harga_modal.required'     => 'Harga modal wajib diisi pada baris :position.',
            'details.*.harga_modal.min'          => 'Harga modal tidak boleh negatif pada baris :position.',
            'details.*.harga_jual.required'      => 'Harga jual wajib diisi pada baris :position.',
            'details.*.harga_jual.min'           => 'Harga jual tidak boleh negatif pada baris :position.',
        ];
    }

    /**
     * Validasi tambahan: tidak boleh ada kode barang yang dobel dalam satu RORIS.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $kodes = collect($this->input('details', []))->pluck('kode_barang')->filter();
            $duplicates = $kodes->duplicates();

            if ($duplicates->isNotEmpty()) {
                $validator->errors()->add(
                    'details',
                    'Terdapat barang yang diinput lebih dari satu kali: ' . $duplicates->unique()->implode(', ') . '.'
                );
            }
        });
    }
}
