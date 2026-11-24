<?php

namespace App\Http\Requests;

use App\Models\KategoriSatuan;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriSatuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama_satuan' => trim((string) $this->nama_satuan),
            'deskripsi'   => $this->deskripsi ? trim((string) $this->deskripsi) : null,
        ]);
    }

    public function rules(): array
    {
        $satuanId = $this->route('kategori_satuan')->id;

        return [
            'nama_satuan' => [
                'required',
                'string',
                'max:50',
                'unique:kategori_satuans,nama_satuan,' . $satuanId,
                function (string $attribute, mixed $value, \Closure $fail) use ($satuanId) {
                    $exists = KategoriSatuan::whereRaw('LOWER(nama_satuan) = ?', [mb_strtolower((string) $value)])
                        ->where('id', '!=', $satuanId)
                        ->exists();

                    if ($exists) {
                        $fail("Kategori satuan \"{$value}\" sudah digunakan oleh data lain.");
                    }
                },
            ],
            'deskripsi' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_satuan.required' => 'Nama satuan wajib diisi.',
            'nama_satuan.max'      => 'Nama satuan maksimal 50 karakter.',
            'nama_satuan.unique'   => 'Kategori satuan sudah digunakan oleh data lain.',
        ];
    }
}