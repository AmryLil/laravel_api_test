<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Laptop Asus VivoBook 14',
                'jumlah'      => 10,
                'harga'       => 7500000.0,
                'diskon'      => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Smartphone Samsung Galaxy A14',
                'jumlah'      => 20,
                'harga'       => 2500000.0,
                'diskon'      => 5,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Headset Logitech H390 USB',
                'jumlah'      => 30,
                'harga'       => 450000.0,
                'diskon'      => 15,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kode_barang' => 'BRG004',
                'nama_barang' => 'Meja Belajar Kayu Minimalis',
                'jumlah'      => 5,
                'harga'       => 1200000.0,
                'diskon'      => 20,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kode_barang' => 'BRG005',
                'nama_barang' => 'Printer Canon PIXMA G2010',
                'jumlah'      => 8,
                'harga'       => 1850000.0,
                'diskon'      => 8,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
