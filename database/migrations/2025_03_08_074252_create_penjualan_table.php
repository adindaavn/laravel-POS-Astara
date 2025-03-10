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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('member_id')->nullable()->constrained('member')->nullOnDelete()->cascadeOnUpdate();
            $table->date('tgl');
            $table->double('total_bayar');
            $table->enum('metode_bayar', ['cash', 'transfer', 'e-wallet', 'debit'])->default('cash');
            $table->string('no_rekening', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
