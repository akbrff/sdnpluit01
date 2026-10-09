<?php

use App\Models\Admin;
use App\Models\BeritaPengumuman;
use App\Models\KategoriBerita;
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

test('guest cannot access berita admin page', function () {
    $response = $this->get(
        route('admin.berita.index')
    );

    $response->assertRedirect(route('login'));
});

test('kategori creates unique slug when slug base collides', function () {
    $this->actingAs($this->admin);

    $this->post(
        route('admin.kategori-berita.store'),
        [
            'nama' => 'Info Sekolah',
        ]
    )->assertSessionHasNoErrors();

    $this->post(
        route('admin.kategori-berita.store'),
        [
            'nama' => 'Info-Sekolah',
        ]
    )->assertSessionHasNoErrors();

    $this->assertDatabaseHas('kategori_berita', [
        'nama' => 'Info Sekolah',
        'slug' => 'info-sekolah',
    ]);

    $this->assertDatabaseHas('kategori_berita', [
        'nama' => 'Info-Sekolah',
        'slug' => 'info-sekolah-1',
    ]);
});

test('duplicate kategori name is rejected', function () {
    $this->actingAs($this->admin);

    KategoriBerita::create([
        'nama' => 'Pengumuman',
        'slug' => 'pengumuman',
    ]);

    $response = $this
        ->from(route('admin.kategori-berita.create'))
        ->post(
            route('admin.kategori-berita.store'),
            [
                'nama' => 'Pengumuman',
            ]
        );

    $response
        ->assertSessionHasErrors('nama')
        ->assertRedirect(
            route('admin.kategori-berita.create')
        );

    expect(
        KategoriBerita::where(
            'nama',
            'Pengumuman'
        )->count()
    )->toBe(1);
});

test('berita can have multiple categories and draft is hidden from public', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $kategoriSatu = KategoriBerita::create([
        'nama' => 'Pengumuman',
        'slug' => 'pengumuman',
    ]);

    $kategoriDua = KategoriBerita::create([
        'nama' => 'Kegiatan',
        'slug' => 'kegiatan',
    ]);

    $response = $this->post(
        route('admin.berita.store'),
        [
            'judul' => 'Berita Draft Sekolah',
            'isi' => 'Isi berita draft sekolah.',
            'status' => 'draft',
            'kategori' => [
                $kategoriSatu->id,
                $kategoriDua->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'sampul.jpg'
                ),
        ]
    );

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(
            route('admin.berita.index')
        );

    $berita = BeritaPengumuman::where(
        'judul',
        'Berita Draft Sekolah'
    )->firstOrFail();

    expect(
        $berita->kategori()->count()
    )->toBe(2);

    Storage::disk('public')
        ->assertExists(
            $berita->gambar_sampul
        );

    $this->get(
        route('berita.public')
    )
        ->assertOk()
        ->assertDontSee(
            'Berita Draft Sekolah'
        );

    $this->get(
        route(
            'berita.detail.public',
            $berita->slug
        )
    )->assertNotFound();
});

test('published berita appears on public list and detail', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $kategori = KategoriBerita::create([
        'nama' => 'Kegiatan',
        'slug' => 'kegiatan',
    ]);

    $this->post(
        route('admin.berita.store'),
        [
            'judul' => 'Berita Terbit Sekolah',
            'isi' => 'Isi berita yang sudah diterbitkan.',
            'status' => 'terbit',
            'kategori' => [
                $kategori->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'terbit.jpg'
                ),
        ]
    )->assertSessionHasNoErrors();

    $berita = BeritaPengumuman::where(
        'judul',
        'Berita Terbit Sekolah'
    )->firstOrFail();

    $this->get(
        route('berita.public')
    )
        ->assertOk()
        ->assertSee(
            'Berita Terbit Sekolah'
        );

    $this->get(
        route(
            'berita.detail.public',
            $berita->slug
        )
    )
        ->assertOk()
        ->assertSee(
            'Berita Terbit Sekolah'
        );
});

test('berita creates unique slug when slug base collides', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $kategori = KategoriBerita::create([
        'nama' => 'Agenda',
        'slug' => 'agenda',
    ]);

    $this->post(
        route('admin.berita.store'),
        [
            'judul' => 'Agenda Sekolah',
            'isi' => 'Isi berita pertama.',
            'status' => 'terbit',
            'kategori' => [
                $kategori->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'satu.jpg'
                ),
        ]
    )->assertSessionHasNoErrors();

    $this->post(
        route('admin.berita.store'),
        [
            'judul' => 'Agenda-Sekolah',
            'isi' => 'Isi berita kedua.',
            'status' => 'terbit',
            'kategori' => [
                $kategori->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'dua.jpg'
                ),
        ]
    )->assertSessionHasNoErrors();

    $this->assertDatabaseHas(
        'berita_pengumuman',
        [
            'judul' => 'Agenda Sekolah',
            'slug' => 'agenda-sekolah',
        ]
    );

    $this->assertDatabaseHas(
        'berita_pengumuman',
        [
            'judul' => 'Agenda-Sekolah',
            'slug' => 'agenda-sekolah-1',
        ]
    );
});

test('invalid berita image is rejected', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $kategori = KategoriBerita::create([
        'nama' => 'Pengumuman',
        'slug' => 'pengumuman',
    ]);

    $response = $this
        ->from(
            route('admin.berita.create')
        )
        ->post(
            route('admin.berita.store'),
            [
                'judul' => 'Berita File Tidak Valid',
                'isi' => 'Isi berita.',
                'status' => 'draft',
                'kategori' => [
                    $kategori->id,
                ],
                'gambar_sampul' =>
                    UploadedFile::fake()->create(
                        'dokumen.pdf',
                        100,
                        'application/pdf'
                    ),
            ]
        );

    $response
        ->assertSessionHasErrors(
            'gambar_sampul'
        )
        ->assertRedirect(
            route('admin.berita.create')
        );

    $this->assertDatabaseMissing(
        'berita_pengumuman',
        [
            'judul' => 'Berita File Tidak Valid',
        ]
    );
});

test('replacing cover deletes old file after successful update', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $kategori = KategoriBerita::create([
        'nama' => 'Kegiatan',
        'slug' => 'kegiatan',
    ]);

    $this->post(
        route('admin.berita.store'),
        [
            'judul' => 'Berita Ganti Sampul',
            'isi' => 'Isi berita.',
            'status' => 'draft',
            'kategori' => [
                $kategori->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'lama.jpg'
                ),
        ]
    )->assertSessionHasNoErrors();

    $berita = BeritaPengumuman::where(
        'judul',
        'Berita Ganti Sampul'
    )->firstOrFail();

    $gambarLama =
        $berita->gambar_sampul;

    Storage::disk('public')
        ->assertExists(
            $gambarLama
        );

    $this->put(
        route(
            'admin.berita.update',
            $berita
        ),
        [
            'judul' => 'Berita Ganti Sampul',
            'isi' => 'Isi berita diperbarui.',
            'status' => 'terbit',
            'kategori' => [
                $kategori->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'baru.jpg'
                ),
        ]
    )->assertSessionHasNoErrors();

    $berita->refresh();

    Storage::disk('public')
        ->assertMissing(
            $gambarLama
        );

    Storage::disk('public')
        ->assertExists(
            $berita->gambar_sampul
        );

    expect(
        $berita->status
    )->toBe('terbit');
});

test('deleting berita removes its cover and relations', function () {
    Storage::fake('public');

    $this->actingAs($this->admin);

    $kategori = KategoriBerita::create([
        'nama' => 'Pengumuman',
        'slug' => 'pengumuman',
    ]);

    $this->post(
        route('admin.berita.store'),
        [
            'judul' => 'Berita Akan Dihapus',
            'isi' => 'Isi berita.',
            'status' => 'draft',
            'kategori' => [
                $kategori->id,
            ],
            'gambar_sampul' =>
                UploadedFile::fake()->image(
                    'hapus.jpg'
                ),
        ]
    )->assertSessionHasNoErrors();

    $berita = BeritaPengumuman::where(
        'judul',
        'Berita Akan Dihapus'
    )->firstOrFail();

    $idBerita =
        $berita->id;

    $gambar =
        $berita->gambar_sampul;

    $this->delete(
        route(
            'admin.berita.destroy',
            $berita
        )
    )
        ->assertSessionHasNoErrors()
        ->assertRedirect(
            route('admin.berita.index')
        );

    $this->assertDatabaseMissing(
        'berita_pengumuman',
        [
            'id' => $idBerita,
        ]
    );

    $this->assertDatabaseMissing(
        'berita_kategori',
        [
            'id_berita' => $idBerita,
        ]
    );

    Storage::disk('public')
        ->assertMissing(
            $gambar
        );
});

test('deleting category does not delete berita', function () {
    $this->actingAs($this->admin);

    $kategori = KategoriBerita::create([
        'nama' => 'Kategori Lama',
        'slug' => 'kategori-lama',
    ]);

    $berita = BeritaPengumuman::create([
        'judul' => 'Berita Tetap Ada',
        'slug' => 'berita-tetap-ada',
        'isi' => 'Isi berita.',
        'status' => 'draft',
    ]);

    $berita
        ->kategori()
        ->attach(
            $kategori->id
        );

    $this->delete(
        route(
            'admin.kategori-berita.destroy',
            $kategori
        )
    )
        ->assertSessionHasNoErrors()
        ->assertRedirect(
            route(
                'admin.kategori-berita.index'
            )
        );

    $this->assertDatabaseMissing(
        'kategori_berita',
        [
            'id' => $kategori->id,
        ]
    );

    $this->assertDatabaseHas(
        'berita_pengumuman',
        [
            'id' => $berita->id,
        ]
    );

    $this->assertDatabaseMissing(
        'berita_kategori',
        [
            'id_berita' =>
                $berita->id,
            'id_kategori' =>
                $kategori->id,
        ]
    );
});