<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');  // foreign key ke products
            $table->integer('jumlah');  // jumlah beli
            $table->decimal('harga_satuan', 10, 2);
            $table->integer('diskon')->default(0);
            $table->decimal('total_beli', 10, 2);
            $table->decimal('total_bayar', 10, 2);
            $table->timestamps();

            // Relasi ke tabel products
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
