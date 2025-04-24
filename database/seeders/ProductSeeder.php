<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Produk A', 'description' => 'Deskripsi produk A', 'price' => 10000],
            ['name' => 'Produk B', 'description' => 'Deskripsi produk B', 'price' => 15000],
            ['name' => 'Produk C', 'description' => 'Deskripsi produk C', 'price' => 12000],
            ['name' => 'Produk D', 'description' => 'Deskripsi produk D', 'price' => 18000],
            ['name' => 'Produk E', 'description' => 'Deskripsi produk E', 'price' => 14000],
            ['name' => 'Produk F', 'description' => 'Deskripsi produk F', 'price' => 20000],
            ['name' => 'Produk G', 'description' => 'Deskripsi produk G', 'price' => 17000],
            ['name' => 'Produk H', 'description' => 'Deskripsi produk H', 'price' => 11000],
            ['name' => 'Produk I', 'description' => 'Deskripsi produk I', 'price' => 9000],
            ['name' => 'Produk J', 'description' => 'Deskripsi produk J', 'price' => 16000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
