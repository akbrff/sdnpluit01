<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use App\Models\StatistikSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilStatistikController extends Controller
{
    public function edit()
    {
        // Selalu panggil via ::current() sesuai instruksi
        $profil = ProfilSekolah::current();
        $statistik = StatistikSekolah::current();

        return view('admin.profil-statistik.edit', compact('profil', 'statistik'));
    }

    public function update(Request $request)
    {
        // Validasi data profil dan statistik
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_gedung' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'ringkasan_profil' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'jumlah_guru' => 'required|integer|min:0',
            'jumlah_siswa' => 'required|integer|min:0',
            'jumlah_kelas' => 'required|integer|min:0',
            'siswa_laki_laki' => 'required|integer|min:0',
            'siswa_perempuan' => 'required|integer|min:0',
        ]);

        $profil = ProfilSekolah::current();
        $statistik = StatistikSekolah::current();

        $dataProfil = $request->except(['_token', '_method', 'logo', 'foto_gedung', 'jumlah_guru', 'jumlah_siswa', 'jumlah_kelas', 'siswa_laki_laki', 'siswa_perempuan']);

        // Upload logo dan hapus file lama (mencegah sampah di server sesuai aturan Struktur Organisasi)
        if ($request->hasFile('logo')) {
            if ($profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }
            $dataProfil['logo'] = $request->file('logo')->store('profil', 'public');
        }

        // Upload foto gedung dan hapus file lama
        if ($request->hasFile('foto_gedung')) {
            if ($profil->foto_gedung) {
                Storage::disk('public')->delete($profil->foto_gedung);
            }
            $dataProfil['foto_gedung'] = $request->file('foto_gedung')->store('profil', 'public');
        }

        // Update menggunakan instans yang diambil dari ::current()
        $profil->update($dataProfil);

        // Update data statistik
        $statistik->update($request->only([
            'jumlah_guru', 'jumlah_siswa', 'jumlah_kelas', 'siswa_laki_laki', 'siswa_perempuan'
        ]));

        // Flash message menggunakan 'sukses' sesuai pola Struktur Organisasi
        return redirect()->back()->with('sukses', 'Data profil dan statistik berhasil diperbarui!');
    }
}