<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KurikulumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'       => ['required', 'string', 'max:255'],
            'deskripsi'   => ['nullable', 'string'],
            'url_dokumen' => ['nullable', 'url', 'max:255'],
            'aktif'       => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'  => 'Judul kurikulum wajib diisi.',
            'judul.max'       => 'Judul kurikulum maksimal 255 karakter.',
            'url_dokumen.url' => 'Format tautan dokumen tidak valid. Contoh: https://contoh.com/dokumen.pdf',
            'url_dokumen.max' => 'Tautan dokumen maksimal 255 karakter.',
        ];
    }
}