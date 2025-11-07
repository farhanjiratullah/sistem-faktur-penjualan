<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Perusahaan;
use App\Models\Produk;
use App\Models\Faktur;
use App\Models\DetailFaktur;

test('customer model works', function () {
    $customer = Customer::factory()->create([
        'nama_customer' => 'Test Customer',
        'perusahaan_cust' => 'PT. Test',
        'alamat' => 'Jl. Test'
    ]);

    expect($customer->nama_customer)->toBe('Test Customer');
    expect($customer->perusahaan_cust)->toBe('PT. Test');
    expect($customer->alamat)->toBe('Jl. Test');
});

test('perusahaan model works', function () {
    $perusahaan = Perusahaan::factory()->create([
        'nama_perusahaan' => 'PT. Test Perusahaan',
        'alamat' => 'Jl. Perusahaan Test',
        'no_telp' => '021-123456',
        'fax' => '021-123457'
    ]);

    expect($perusahaan->nama_perusahaan)->toBe('PT. Test Perusahaan');
    expect($perusahaan->no_telp)->toBe('021-123456');
});

test('produk model works', function () {
    $produk = Produk::factory()->create([
        'nama_produk' => 'Produk Test',
        'price' => 100000,
        'stock' => 50
    ]);

    expect($produk->nama_produk)->toBe('Produk Test');
    expect($produk->price)->toBe(100000);
    expect($produk->stock)->toBe(50);
});

test('faktur model works', function () {
    $customer = Customer::factory()->create();
    $perusahaan = Perusahaan::factory()->create();

    $faktur = Faktur::factory()->create([
        'no_faktur' => 'PJ2501010001',
        'id_customer' => $customer->id_customer,
        'id_perusahaan' => $perusahaan->id_perusahaan,
        'grand_total' => 150000
    ]);

    expect($faktur->no_faktur)->toBe('PJ2501010001');
    expect($faktur->grand_total)->toBe(150000);
    expect($faktur->customer->id_customer)->toBe($customer->id_customer);
    expect($faktur->perusahaan->id_perusahaan)->toBe($perusahaan->id_perusahaan);
});

test('detail faktur model works', function () {
    $faktur = Faktur::factory()->create();
    $produk = Produk::factory()->create();

    $detail = DetailFaktur::factory()->create([
        'no_faktur' => $faktur->no_faktur,
        'id_produk' => $produk->id_produk,
        'qty' => 3,
        'price' => 50000
    ]);

    expect($detail->qty)->toBe(3);
    expect($detail->price)->toBe(50000);
    expect($detail->subtotal)->toBe(150000);
    expect($detail->faktur->no_faktur)->toBe($faktur->no_faktur);
    expect($detail->produk->id_produk)->toBe($produk->id_produk);
});

test('faktur generates correct no_faktur', function () {
    $noFaktur = Faktur::generateNoFaktur();

    expect($noFaktur)->toMatch('/^PJ\d{6}\d{4}$/');
});
