<?php

use App\Models\User;
use App\Models\Perusahaan;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    $this->perusahaanData = [
        'nama_perusahaan' => 'PT. Test Perusahaan',
        'alamat' => 'Jl. Test Perusahaan No. 123',
        'no_telp' => '021-123456',
        'fax' => '021-123457'
    ];
});

test('can view perusahaan index page', function () {
    $response = $this->get(route('perusahaan.index'));
    $response->assertStatus(200);
    $response->assertSee('Data Perusahaan');
});

test('can create perusahaan', function () {
    $response = $this->post(route('perusahaan.store'), $this->perusahaanData);

    $response->assertRedirect(route('perusahaan.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('perusahaan', $this->perusahaanData);
});

test('can view create perusahaan page', function () {
    $response = $this->get(route('perusahaan.create'));
    $response->assertStatus(200);
    $response->assertSee('Tambah Data Perusahaan');
});

test('can view edit perusahaan page', function () {
    $perusahaan = Perusahaan::factory()->create();

    $response = $this->get(route('perusahaan.edit', $perusahaan->id_perusahaan));
    $response->assertStatus(200);
    $response->assertSee('Edit Data Perusahaan');
});

test('can update perusahaan', function () {
    $perusahaan = Perusahaan::factory()->create();

    $updatedData = [
        'nama_perusahaan' => 'PT. Updated Perusahaan',
        'alamat' => 'Jl. Updated Perusahaan No. 456',
        'no_telp' => '021-654321',
        'fax' => '021-654322'
    ];

    $response = $this->put(route('perusahaan.update', $perusahaan->id_perusahaan), $updatedData);

    $response->assertRedirect(route('perusahaan.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('perusahaan', $updatedData);
});

test('can delete perusahaan', function () {
    $perusahaan = Perusahaan::factory()->create();

    $response = $this->delete(route('perusahaan.destroy', $perusahaan->id_perusahaan));

    $response->assertRedirect(route('perusahaan.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('perusahaan', ['id_perusahaan' => $perusahaan->id_perusahaan]);
});

test('perusahaan validation works', function () {
    // Test required fields
    $response = $this->post(route('perusahaan.store'), []);

    $response->assertSessionHasErrors(['nama_perusahaan', 'alamat', 'no_telp', 'fax']);
});

test('perusahaan unique name validation', function () {
    Perusahaan::factory()->create(['nama_perusahaan' => 'PT. Duplicate']);

    $response = $this->post(route('perusahaan.store'), [
        'nama_perusahaan' => 'PT. Duplicate',
        'alamat' => 'Jl. Test',
        'no_telp' => '021-111111',
        'fax' => '021-111112'
    ]);

    $response->assertSessionHasErrors(['nama_perusahaan']);
});
