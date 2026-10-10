<?php

namespace App\Http\Requests;

use App\Models\BeritaPengumuman;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BeritaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $berita = $this->route('berita');

        $beritaId = $berita instanceof BeritaPengumuman
            ? $berita->id
            : $berita;

        $rules = [
            'judul' => [
                'required',
                'string',
                'max:255',
                Rule::unique('berita_pengumuman', 'judul')
                    ->ignore($beritaId),
            ],

            'isi' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'terbit']),
            ],

            'kategori' => [
                'required',
                'array',
                'min:1',
            ],

            'kategori.*' => [
                'required',
                'integer',
                'exists:kategori_berita,id',
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['gambar_sampul'] = [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ];
        } else {
            $rules['gambar_sampul'] = [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul berita wajib diisi.',
            'judul.string' => 'Judul berita harus berupa teks.',
            'judul.max' => 'Judul berita maksimal 255 karakter.',
            'judul.unique' => 'Judul berita sudah digunakan.',

            'isi.required' => 'Isi berita tidak boleh kosong.',
            'isi.string' => 'Isi berita harus berupa teks.',

            'status.required' => 'Status berita wajib dipilih.',
            'status.in' => 'Status berita harus draft atau terbit.',

            'kategori.required' => 'Pilih minimal satu kategori.',
            'kategori.array' => 'Kategori berita tidak valid.',
            'kategori.min' => 'Pilih minimal satu kategori.',
            'kategori.*.exists' => 'Kategori yang dipilih tidak ditemukan.',

            'gambar_sampul.required' => 'Gambar sampul wajib diunggah.',
            'gambar_sampul.image' => 'File sampul harus berupa gambar.',
            'gambar_sampul.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar_sampul.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}