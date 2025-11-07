<?php

use App\Models\User;
use App\Models\Customer;
use App\Models\Perusahaan;
use App\Models\Produk;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123')
    ]);
});

test('user can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'testregister@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'testregister@example.com'
    ]);
});

test('user can login', function () {
    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($this->user);
});

test('user can logout', function () {
    $this->actingAs($this->user);

    $response = $this->post('/logout');

    $response->assertRedirect('/login');
    $this->assertGuest();
});

test('protected routes require authentication', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');

    $response = $this->get('/customer');
    $response->assertRedirect('/login');

    $response = $this->get('/perusahaan');
    $response->assertRedirect('/login');

    $response = $this->get('/penjualan');
    $response->assertRedirect('/login');
});

test('authenticated user can access protected routes', function () {
    $this->actingAs($this->user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    $response = $this->get('/customer');
    $response->assertStatus(200);

    $response = $this->get('/perusahaan');
    $response->assertStatus(200);

    $response = $this->get('/penjualan');
    $response->assertStatus(200);
});
