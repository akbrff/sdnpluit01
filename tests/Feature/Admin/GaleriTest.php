<?php

use App\Models\Admin;
use App\Models\FotoGaleri;
use App\Models\Galeri;
use App\Models\ProfilSekolah;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    ProfilSekolah::create([
        'nama_sekolah' => 'SDN Pluit 01',
    ]);

    $this->admin = Admin::create([
        'nama' => 'Admin Test',
        'email' => 'admin@test.com',
        'kata_sandi' => Hash::make('password'),
        'peran' => 'superadmin',
    ]);
});

test('guest cannot access galeri admin page', function () {
    $this->get(
        route('admin.galeri.index')
    )->assertRedirect(route('login'));
});

test('album can be created with multiple photos', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $response = $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Kegiatan Sekolah',
            'deskripsi' => 'Dokumentasi kegiatan sekolah.',
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('foto1.jpg'),
                UploadedFile::fake()->image('foto2.jpg'),
                UploadedFile::fake()->image('foto3.jpg'),
            ],
        ]
    );

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.galeri.index'));

    $galeri = Galeri::where(
        'judul',
        'Kegiatan Sekolah'
    )->firstOrFail();

    expect($galeri->foto()->count())->toBe(3);

    foreach ($galeri->foto as $foto) {
        Storage::disk('public')
            ->assertExists($foto->lokasi_gambar);
    }
});

test('adding photos while editing does not delete old photos', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Album Lama',
            'deskripsi' => 'Album awal.',
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('lama1.jpg'),
                UploadedFile::fake()->image('lama2.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $galeri = Galeri::where(
        'judul',
        'Album Lama'
    )->firstOrFail();

    $fotoLama = $galeri->foto
        ->pluck('lokasi_gambar')
        ->all();

    $this->put(
        route('admin.galeri.update', $galeri),
        [
            'judul' => 'Album Diperbarui',
            'deskripsi' => 'Album sudah diperbarui.',
            'tanggal_kegiatan' => '2026-10-10',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('baru1.jpg'),
                UploadedFile::fake()->image('baru2.jpg'),
            ],
        ]
    )
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.galeri.index'));

    $galeri->refresh();

    expect($galeri->foto()->count())->toBe(4);

    foreach ($fotoLama as $path) {
        Storage::disk('public')
            ->assertExists($path);
    }

    expect($galeri->judul)
        ->toBe('Album Diperbarui');
});

test('deleting one photo does not delete other photos', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Album Hapus Foto',
            'deskripsi' => null,
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('satu.jpg'),
                UploadedFile::fake()->image('dua.jpg'),
                UploadedFile::fake()->image('tiga.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $galeri = Galeri::where(
        'judul',
        'Album Hapus Foto'
    )->firstOrFail();

    $fotoDihapus = $galeri->foto()->firstOrFail();

    $fotoLain = $galeri->foto()
        ->where('id', '!=', $fotoDihapus->id)
        ->get();

    $pathDihapus = $fotoDihapus->lokasi_gambar;

    $this->delete(
        route(
            'admin.galeri.foto.destroy',
            $fotoDihapus
        )
    )->assertSessionHasNoErrors();

    $this->assertDatabaseMissing(
        'foto_galeri',
        [
            'id' => $fotoDihapus->id,
        ]
    );

    Storage::disk('public')
        ->assertMissing($pathDihapus);

    expect(
        FotoGaleri::where(
            'id_galeri',
            $galeri->id
        )->count()
    )->toBe(2);

    foreach ($fotoLain as $foto) {
        $this->assertDatabaseHas(
            'foto_galeri',
            [
                'id' => $foto->id,
            ]
        );

        Storage::disk('public')
            ->assertExists(
                $foto->lokasi_gambar
            );
    }
});

test('deleting album removes database photos and physical files', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Album Akan Dihapus',
            'deskripsi' => 'Album sementara.',
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('hapus1.jpg'),
                UploadedFile::fake()->image('hapus2.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $galeri = Galeri::where(
        'judul',
        'Album Akan Dihapus'
    )->firstOrFail();

    $idGaleri = $galeri->id;

    $paths = $galeri->foto
        ->pluck('lokasi_gambar')
        ->all();

    $this->delete(
        route('admin.galeri.destroy', $galeri)
    )
        ->assertSessionHasNoErrors()
        ->assertRedirect(
            route('admin.galeri.index')
        );

    $this->assertDatabaseMissing(
        'galeri',
        ['id' => $idGaleri]
    );

    $this->assertDatabaseMissing(
        'foto_galeri',
        ['id_galeri' => $idGaleri]
    );

    foreach ($paths as $path) {
        Storage::disk('public')
            ->assertMissing($path);
    }
});

test('invalid gallery file is rejected', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $response = $this
        ->from(route('admin.galeri.create'))
        ->post(
            route('admin.galeri.store'),
            [
                'judul' => 'Album File Salah',
                'deskripsi' => 'Testing invalid file.',
                'tanggal_kegiatan' => '2026-10-09',
                'aktif' => '1',
                'foto' => [
                    UploadedFile::fake()->create(
                        'dokumen.pdf',
                        100,
                        'application/pdf'
                    ),
                ],
            ]
        );

    $response
        ->assertSessionHasErrors('foto.0')
        ->assertRedirect(
            route('admin.galeri.create')
        );

    $this->assertDatabaseMissing(
        'galeri',
        [
            'judul' => 'Album File Salah',
        ]
    );
});

test('oversized gallery image is rejected', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $response = $this
        ->from(route('admin.galeri.create'))
        ->post(
            route('admin.galeri.store'),
            [
                'judul' => 'Album Foto Besar',
                'deskripsi' => null,
                'tanggal_kegiatan' => '2026-10-09',
                'aktif' => '1',
                'foto' => [
                    UploadedFile::fake()
                        ->image('besar.jpg')
                        ->size(3000),
                ],
            ]
        );

    $response
        ->assertSessionHasErrors('foto.0')
        ->assertRedirect(
            route('admin.galeri.create')
        );

    $this->assertDatabaseMissing(
        'galeri',
        [
            'judul' => 'Album Foto Besar',
        ]
    );
});

test('gallery creates unique slug when slug base collides', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Wisuda Sekolah',
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('satu.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Wisuda-Sekolah',
            'tanggal_kegiatan' => '2026-10-10',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('dua.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $this->assertDatabaseHas(
        'galeri',
        [
            'judul' => 'Wisuda Sekolah',
            'slug' => 'wisuda-sekolah',
        ]
    );

    $this->assertDatabaseHas(
        'galeri',
        [
            'judul' => 'Wisuda-Sekolah',
            'slug' => 'wisuda-sekolah-1',
        ]
    );
});

test('inactive gallery is hidden from public pages', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Album Tidak Aktif',
            'deskripsi' => 'Album tersembunyi.',
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '0',
            'foto' => [
                UploadedFile::fake()->image('foto.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $galeri = Galeri::where(
        'judul',
        'Album Tidak Aktif'
    )->firstOrFail();

    $this->get(
        route('galeri.public')
    )
        ->assertOk()
        ->assertDontSee(
            'Album Tidak Aktif'
        );

    $this->get(
        route(
            'galeri.detail.public',
            $galeri->slug
        )
    )->assertNotFound();
});

test('active gallery appears on public list and detail', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $this->post(
        route('admin.galeri.store'),
        [
            'judul' => 'Album Publik',
            'deskripsi' => 'Album yang tampil di publik.',
            'tanggal_kegiatan' => '2026-10-09',
            'aktif' => '1',
            'foto' => [
                UploadedFile::fake()->image('publik.jpg'),
            ],
        ]
    )->assertSessionHasNoErrors();

    $galeri = Galeri::where(
        'judul',
        'Album Publik'
    )->firstOrFail();

    $this->get(
        route('galeri.public')
    )
        ->assertOk()
        ->assertSee('Album Publik');

    $this->get(
        route(
            'galeri.detail.public',
            $galeri->slug
        )
    )
        ->assertOk()
        ->assertSee('Album Publik');
});