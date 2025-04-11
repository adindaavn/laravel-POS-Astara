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
        Schema::create('pengajuan_buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('member')->nullOnDelete()->cascadeOnUpdate();
            $table->string('judul');
            $table->string('penulis')->nullable();
            $table->string('nama_pengaju')->nullable();
            $table->string('no_telp')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('qty')->nullable();
            $table->enum('status', [0, 1])->nullable();
            $table->date('tgl')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_buku');
    }
};
