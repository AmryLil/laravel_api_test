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
        Schema::create('products', function (Blueprint $table) {
            $table->string('kode_barang', 50)->primary();
            $table->string('nama_barang');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah');
            $table->integer('diskon')->nullable();
            $table->decimal('harga', 10, 2);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
