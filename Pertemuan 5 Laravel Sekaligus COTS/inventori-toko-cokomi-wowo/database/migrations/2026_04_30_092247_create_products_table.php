<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel products untuk menyimpan data inventari toko Cokomi & Wowo
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Nama produk
            $table->string('category');         // Kategori produk
            $table->text('description')->nullable(); // Deskripsi produk
            $table->decimal('price', 12, 2);    // Harga jual (Rp)
            $table->decimal('cost_price', 12, 2)->nullable(); // Harga modal (Rp)
            $table->integer('stock');           // Jumlah stok
            $table->string('unit')->default('pcs'); // Satuan (pcs, kg, liter, dll)
            $table->string('sku')->unique()->nullable(); // Kode SKU produk
            $table->string('image')->nullable(); // Nama file gambar
            $table->boolean('is_active')->default(true); // Status produk aktif/nonaktif
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
