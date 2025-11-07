<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = [
            [
                'nama_produk' => 'Laptop HP',
                'price' => 7000000,
                'satuan' => 'pcs',
                'jenis' => 'Elektronik',
                'stock' => 50
            ],
            [
                'nama_produk' => 'Sofa',
                'price' => 10000000,
                'satuan' => 'pcs',
                'jenis' => 'Furniture',
                'stock' => 30
            ],
            [
                'nama_produk' => 'Vitamin C 50 MG KF 10 Tablet',
                'price' => 2500,
                'satuan' => 'strip',
                'jenis' => 'Suplemen',
                'stock' => 100
            ],
            [
                'nama_produk' => 'Chitato',
                'price' => 9000,
                'satuan' => 'pcs',
                'jenis' => 'Makanan',
                'stock' => 200
            ],
            [
                'nama_produk' => 'Erigo',
                'price' => 200000,
                'satuan' => 'pcs',
                'jenis' => 'Pakaian',
                'stock' => 80
            ],
        ];

        Produk::insert($produks);
    }
}
