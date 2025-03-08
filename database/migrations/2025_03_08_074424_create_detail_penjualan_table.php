<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->nullable()->constrained('penjualan')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('buku_id')->nullable()->constrained('buku')->nullOnDelete()->cascadeOnUpdate();
            $table->double('harga_jual');
            $table->integer('jumlah')->nullable();
            $table->double('subtotal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};
