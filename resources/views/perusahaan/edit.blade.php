@extends('layouts.app')

@section('title', 'Edit Perusahaan - Sistem Faktur Penjualan')

@section('content')
    <div class="p-6">
        <!-- Header Content -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Perusahaan</h1>
                <p class="text-gray-600 mt-1">Edit data perusahaan: {{ $perusahaan->nama_perusahaan }}</p>
            </div>
            <a href="{{ route('perusahaan.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <form action="{{ route('perusahaan.update', $perusahaan->id_perusahaan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <!-- Nama Perusahaan Field -->
                    <div>
                        <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_perusahaan" id="nama_perusahaan"
                            value="{{ old('nama_perusahaan', $perusahaan->nama_perusahaan) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_perusahaan') border-red-500 @enderror"
                            placeholder="Masukkan nama perusahaan">
                        @error('nama_perusahaan')
                            <div class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Alamat Field -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-500 @enderror"
                            placeholder="Masukkan alamat perusahaan">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                        @error('alamat')
                            <div class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- No Telepon Field -->
                    <div>
                        <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="no_telp" id="no_telp"
                            value="{{ old('no_telp', $perusahaan->no_telp) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_telp') border-red-500 @enderror"
                            placeholder="Masukkan nomor telepon">
                        @error('no_telp')
                            <div class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Fax Field -->
                    <div>
                        <label for="fax" class="block text-sm font-medium text-gray-700 mb-2">
                            Fax <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="fax" id="fax" value="{{ old('fax', $perusahaan->fax) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('fax') border-red-500 @enderror"
                            placeholder="Masukkan fax perusahaan">
                        @error('fax')
                            <div class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('perusahaan.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg flex items-center cursor-pointer">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 ml-3 rounded-lg flex items-center cursor-pointer">
                            <i class="fas fa-save mr-2"></i>
                            Update Perusahaan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection
