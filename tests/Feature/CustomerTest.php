<?php

use App\Models\User;
use App\Models\Customer;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    \App\Models\Perusahaan::factory()->create([
        'nama_perusahaan' => 'PT. Test Customer'
    ]);

    \App\Models\Perusahaan::factory()->create([
        'nama_perusahaan' => 'PT. Updated Customer'
    ]);

    $this->customerData = [
        'nama_customer' => 'Customer Test',
        'perusahaan_cust' => 'PT. Test Customer',
        'alamat' => 'Jl. Test Customer No. 123'
    ];
});

test('can view customer index page', function () {
    $response = $this->get(route('customer.index'));
    $response->assertStatus(200);
    $response->assertSee('Data Customer');
});

test('can create customer', function () {
    $response = $this->post(route('customer.store'), $this->customerData);

    $response->assertRedirect(route('customer.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('customer', $this->customerData);
});

test('can view create customer page', function () {
    $response = $this->get(route('customer.create'));
    $response->assertStatus(200);
    $response->assertSee('Tambah Data Customer');
});

test('can view edit customer page', function () {
    $customer = Customer::factory()->create();

    $response = $this->get(route('customer.edit', $customer->id_customer));
    $response->assertStatus(200);
    $response->assertSee('Edit Data Customer');
});

test('can update customer', function () {
    $customer = Customer::factory()->create();

    $updatedData = [
        'nama_customer' => 'Customer Updated',
        'perusahaan_cust' => 'PT. Updated Customer',
        'alamat' => 'Jl. Updated Customer No. 456'
    ];

    $response = $this->put(route('customer.update', $customer->id_customer), $updatedData);

    $response->assertRedirect(route('customer.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('customer', $updatedData);
});

test('can delete customer', function () {
    $customer = Customer::factory()->create();

    $response = $this->delete(route('customer.destroy', $customer->id_customer));

    $response->assertRedirect(route('customer.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('customer', ['id_customer' => $customer->id_customer]);
});

test('customer validation works', function () {
    // Test required fields
    $response = $this->post(route('customer.store'), []);

    $response->assertSessionHasErrors(['nama_customer', 'perusahaan_cust', 'alamat']);
});

test('can preview customer data', function () {
    Customer::factory()->count(3)->create();

    $response = $this->get(route('customer.preview'));
    $response->assertStatus(200);
    $response->assertSee('Preview Data Customer');
});

test('can download customer PDF', function () {
    Customer::factory()->count(2)->create();

    $response = $this->get(route('customer.pdf'));
    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});
