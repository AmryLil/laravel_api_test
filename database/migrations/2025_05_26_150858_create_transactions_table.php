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
            $table->uuid('id')->primary();
            $table->string('product_id');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->integer('diskon');
            $table->decimal('total_beli', 12, 2);
            $table->decimal('total_bayar', 12, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('kode_barang')->on('products')->onDelete('cascade');
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
