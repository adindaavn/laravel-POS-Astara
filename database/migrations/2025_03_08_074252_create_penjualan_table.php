<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->foreignId('voucher_id')->nullable()->constrained('voucher')->nullOnDelete()->cascadeOnUpdate();
            $table->date('tgl');
            $table->double('total_bersih');
            $table->double('total_bayar')->nullable();
            $table->double('diskon')->nullable()->default(0);
            $table->enum('metode_bayar', ['cash', 'qris'])->default('cash')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));;
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
