<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GaleriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'tanggal_kegiatan' => [
                'required',
                'date',
            ],

            'aktif' => [
                'required',
                'boolean',
            ],
        ];

        if ($this->isMethod('POST')) {
            $rules['foto'] = [
                'required',
                'array',
                'min:1',
            ];

            $rules['foto.*'] = [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ];
        } else {
            $rules['foto'] = [
                'nullable',
                'array',
            ];

            $rules['foto.*'] = [
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
            'judul.required' => 'Judul album galeri wajib diisi.',
            'judul.string' => 'Judul album harus berupa teks.',
            'judul.max' => 'Judul album maksimal 255 karakter.',

            'deskripsi.string' => 'Deskripsi harus berupa teks.',

            'tanggal_kegiatan.required' => 'Tanggal kegiatan wajib diisi.',
            'tanggal_kegiatan.date' => 'Tanggal kegiatan tidak valid.',

            'aktif.required' => 'Status galeri wajib dipilih.',
            'aktif.boolean' => 'Status galeri tidak valid.',

            'foto.required' => 'Wajib mengunggah minimal satu foto album.',
            'foto.array' => 'Data foto tidak valid.',
            'foto.min' => 'Wajib mengunggah minimal satu foto album.',

            'foto.*.image' => 'File yang diunggah harus berupa gambar.',
            'foto.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran foto maksimal 2MB per file.',
        ];
    }
}