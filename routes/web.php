<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FakturController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(
    function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('perusahaan', PerusahaanController::class)->scoped(['perusahaan' => 'id_perusahaan']);

        Route::get('/customer/pdf', [CustomerController::class, 'pdf'])->name('customer.pdf');
        Route::get('/customer/preview', [CustomerController::class, 'preview'])->name('customer.preview');
        Route::resource('customer', CustomerController::class)->scoped(['customer' => 'id_customer']);

        Route::get('/penjualan/{id}/preview', [FakturController::class, 'preview'])->name('penjualan.preview');
        Route::get('/penjualan/{id}/pdf', [FakturController::class, 'pdf'])->name('penjualan.pdf');
        Route::get('/penjualan', [FakturController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/create', [FakturController::class, 'create'])->name('penjualan.create');
        Route::post('/penjualan', [FakturController::class, 'store'])->name('penjualan.store');
        Route::get('/penjualan/{no_faktur}/edit', [FakturController::class, 'edit'])->name('penjualan.edit');
        Route::put('/penjualan/{no_faktur}', [FakturController::class, 'update'])->name('penjualan.update');
        Route::delete('/penjualan/{no_faktur}', [FakturController::class, 'destroy'])->name('penjualan.destroy');
    }
);
