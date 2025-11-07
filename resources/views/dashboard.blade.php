<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-blue-800">Total Perusahaan</h3>
                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Perusahaan::count() }}</p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-green-800">Total Customer</h3>
                <p class="text-2xl font-bold text-green-600">{{ \App\Models\Customer::count() }}</p>
            </div>

            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-purple-800">Total Faktur</h3>
                <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Faktur::count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('perusahaan.create') }}"
                        class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded hover:bg-blue-700 transition">Tambah
                        Perusahaan</a>
                    <a href="{{ route('customer.create') }}"
                        class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded hover:bg-green-700 transition">Tambah
                        Customer</a>
                    <a href="{{ route('penjualan.create') }}"
                        class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded hover:bg-purple-700 transition">Tambah
                        Penjualan</a>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Laporan</h3>
                <a href="{{ route('penjualan.index') }}"
                    class="block w-full bg-orange-600 text-white text-center py-2 px-4 rounded hover:bg-orange-700 transition">Lihat
                    Daftar Faktur</a>
            </div>
        </div>
    </div>
@endsection
