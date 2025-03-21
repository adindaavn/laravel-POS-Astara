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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('isbn', 20)->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit')->nullable();
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->nullOnDelete()->cascadeOnUpdate();
            $table->double('harga');
            $table->year('thn_terbit')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
