<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriBeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kategori_berita = $this->route('kategori_berita');

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_berita', 'nama')
                    ->ignore($kategori_berita?->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ];
    }
}