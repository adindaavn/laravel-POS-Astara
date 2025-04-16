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
        DB::statement("
            CREATE OR REPLACE VIEW view_buku_stok AS
            SELECT 
                b.id, 
                b.isbn, 
                b.judul, 
                b.penulis, 
                b.penerbit, 
                b.thn_terbit, 
                k.nama AS kategori, 
                k.id AS kategori_id, 
                b.harga, 
                b.gambar, 
                b.barcode, 
                (
                    COALESCE((SELECT SUM(jumlah) FROM detail_pembelian WHERE buku_id = b.id), 0) 
                    - COALESCE((SELECT SUM(jumlah) FROM detail_penjualan WHERE buku_id = b.id), 0)
                ) AS stok
            FROM buku b
            JOIN kategori k ON b.kategori_id = k.id;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_buku_stok");
    }
};
