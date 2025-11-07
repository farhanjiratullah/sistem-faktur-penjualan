<!-- resources/views/auth/login.blade.php -->
@extends('layouts.auth')

@section('title', 'Login - Aplikasi Penjualan')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Selamat Datang</h2>
                    <p class="text-gray-600 mt-2">Silakan login ke akun Anda</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">
                            Alamat Email
                        </label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="email@contoh.com">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">
                            Password
                        </label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password">
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition font-medium">
                        Masuk ke Akun
                    </button>
                </form>

                <!-- Divider -->
                <div class="my-6 flex items-center">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-gray-500 text-sm">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <span class="text-gray-600">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium transition">
                        Daftar di sini
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
