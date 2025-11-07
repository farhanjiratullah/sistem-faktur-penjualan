<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Perusahaan;
use App\Models\Produk;
use App\Models\Faktur;
use App\Models\DetailFaktur;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    $this->customer = Customer::factory()->create();
    $this->perusahaan = Perusahaan::factory()->create();
    $this->produk = Produk::factory()->create(['stock' => 100]);

    $this->penjualanData = [
        'no_faktur' => 'PJ' . date('ymd') . '0001',
        'tgl_faktur' => now()->format('Y-m-d'),
        'id_customer' => $this->customer->id_customer,
        'id_perusahaan' => $this->perusahaan->id_perusahaan,
        'due_date' => now()->addDays(7)->format('Y-m-d'),
        'metode_bayar' => 'TUNAI',
        'ppn' => 10,
        'dp' => 0,
        'grand_total' => 110000,
        'produk' => [
            [
                'id_produk' => $this->produk->id_produk,
                'qty' => 2,
                'price' => 50000
            ]
        ]
    ];
});

test('can view penjualan index page', function () {
    $response = $this->get(route('penjualan.index'));
    $response->assertStatus(200);
    $response->assertSee('Data Penjualan');
});

test('can create penjualan', function () {
    $response = $this->post(route('penjualan.store'), $this->penjualanData);

    $response->assertRedirect(route('penjualan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('faktur', [
        'no_faktur' => $this->penjualanData['no_faktur'],
        'grand_total' => 110000
    ]);

    $this->assertDatabaseHas('detail_faktur', [
        'id_produk' => $this->produk->id_produk,
        'qty' => 2
    ]);

    // Check stock decreased
    $this->assertDatabaseHas('produk', [
        'id_produk' => $this->produk->id_produk,
        'stock' => 98 // 100 - 2
    ]);
});

test('can view create penjualan page', function () {
    $response = $this->get(route('penjualan.create'));
    $response->assertStatus(200);
    $response->assertSee('Tambah Faktur Penjualan');
});

test('can view edit penjualan page', function () {
    $faktur = Faktur::factory()->create();
    DetailFaktur::factory()->create(['no_faktur' => $faktur->no_faktur]);

    $response = $this->get(route('penjualan.edit', $faktur->no_faktur));
    $response->assertStatus(200);
    $response->assertSee('Edit Faktur Penjualan');
});

test('can update penjualan', function () {
    $faktur = Faktur::factory()->create();
    $detail = DetailFaktur::factory()->create([
        'no_faktur' => $faktur->no_faktur,
        'id_produk' => $this->produk->id_produk,
        'qty' => 5
    ]);

    $detail->produk->stock = $this->produk->stock - $detail->qty; // Deduct initial stock for existing qty
    $detail->produk->save();

    $updatedData = [
        'no_faktur' => $faktur->no_faktur,
        'tgl_faktur' => now()->format('Y-m-d'),
        'id_customer' => $this->customer->id_customer,
        'id_perusahaan' => $this->perusahaan->id_perusahaan,
        'due_date' => now()->addDays(14)->format('Y-m-d'),
        'metode_bayar' => 'TRANSFER',
        'ppn' => 11,
        'dp' => 50000,
        'grand_total' => 155000,
        'produk' => [
            [
                'id_produk' => $this->produk->id_produk,
                'qty' => 3, // Changed from 5 to 3
                'price' => 50000
            ]
        ]
    ];

    $response = $this->put(route('penjualan.update', $faktur->no_faktur), $updatedData);

    $response->assertRedirect(route('penjualan.index'));
    $response->assertSessionHas('success');

    // Check stock was properly managed (5 returned, 3 deducted = net -2)
    $this->assertDatabaseHas('produk', [
        'id_produk' => $this->produk->id_produk,
        'stock' => 97 // 100 - 3 (net change)
    ]);
});

test('can delete penjualan', function () {
    $faktur = Faktur::factory()->create();
    $detail = DetailFaktur::factory()->create([
        'no_faktur' => $faktur->no_faktur,
        'id_produk' => $this->produk->id_produk,
        'qty' => 3
    ]);

    $initialStock = $this->produk->stock;

    $response = $this->delete(route('penjualan.destroy', $faktur->no_faktur));

    $response->assertRedirect(route('penjualan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('faktur', ['no_faktur' => $faktur->no_faktur]);
    $this->assertDatabaseMissing('detail_faktur', ['no_faktur' => $faktur->no_faktur]);

    // Check stock was returned
    $this->assertDatabaseHas('produk', [
        'id_produk' => $this->produk->id_produk,
        'stock' => $initialStock + 3
    ]);
});

test('penjualan validation works', function () {
    $response = $this->post(route('penjualan.store'), []);

    $response->assertSessionHasErrors([
        'no_faktur',
        'tgl_faktur',
        'id_customer',
        'id_perusahaan',
        'due_date',
        'metode_bayar',
        'ppn',
        'dp',
        'grand_total',
        'produk'
    ]);
});

test('can preview faktur', function () {
    $faktur = Faktur::factory()->create();
    DetailFaktur::factory()->create(['no_faktur' => $faktur->no_faktur]);

    $response = $this->get(route('penjualan.preview', $faktur->no_faktur));
    $response->assertStatus(200);
    $response->assertSee('Preview Faktur');
});

test('can download faktur PDF', function () {
    $faktur = Faktur::factory()->create();
    DetailFaktur::factory()->create(['no_faktur' => $faktur->no_faktur]);

    $response = $this->get(route('penjualan.pdf', $faktur->no_faktur));
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('stock validation prevents over-selling', function () {
    $lowStockProduk = Produk::factory()->create(['stock' => 1]);

    $invalidData = [
        'no_faktur' => 'PJ' . date('ymd') . '0002',
        'tgl_faktur' => now()->format('Y-m-d'),
        'id_customer' => $this->customer->id_customer,
        'id_perusahaan' => $this->perusahaan->id_perusahaan,
        'due_date' => now()->addDays(7)->format('Y-m-d'),
        'metode_bayar' => 'TUNAI',
        'ppn' => 10,
        'dp' => 0,
        'grand_total' => 220000,
        'produk' => [
            [
                'id_produk' => $lowStockProduk->id_produk,
                'qty' => 5, // More than available stock
                'price' => 50000
            ]
        ]
    ];

    $response = $this->post(route('penjualan.store'), $invalidData);

    // Should fail due to stock constraint (depending on how you handle this)
    // This test might need adjustment based on your actual stock validation
    $response->assertSessionHasErrors();
});
