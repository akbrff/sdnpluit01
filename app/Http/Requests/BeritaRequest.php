<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('berita');
        $rules = [
            'judul' => 'required|string|max:255|unique:berita_pengumuman,judul,' . $id,
            'isi' => 'required|string',
            'status' => 'required|in:draft,terbit',
            'kategori' => 'required|array|min:1',
            'kategori.*' => 'exists:kategori_berita,id',
        ];

        if ($this->isMethod('POST')) {
            $rules['gambar_sampul'] = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
        } else {
            $rules['gambar_sampul'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul berita wajib diisi.',
            'isi.required' => 'Isi berita tidak boleh kosong.',
            'gambar_sampul.required' => 'Gambar sampul wajib diunggah.',
            'gambar_sampul.max' => 'Ukuran gambar maksimal 2MB.',
            'kategori.required' => 'Pilih minimal satu kategori.',
        ];
    }
}