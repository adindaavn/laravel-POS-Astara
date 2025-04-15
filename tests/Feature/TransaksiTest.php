<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransaksiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testStoreTransaksiBerhasil()
    {
        $this->withoutExceptionHandling(); // biar error muncul jelas pas development

        // Arrange: buat user dan login
        $user = User::factory()->create();
        $this->actingAs($user);

        // Buat buku dummy
        Kategori::factory()->create();
        $buku = Buku::factory()->create();

        $jumlah = 2;
        $subtotal = $buku->harga * $jumlah;

        $bukuJson = json_encode([
            [
                'buku_id' => $buku->id,
                'harga_jual' => $buku->harga,
                'jumlah' => $jumlah,
            ]
        ]);

        $data = [
            'buku' => $bukuJson,
            'total_bayar' => $subtotal,
            'total_bersih' => $subtotal,
            'diskon' => 0,
            'metode_bayar' => 'cash',
            'bayar' => $subtotal,
            'kembali' => 0,
            'user_id' => $user->id,
        ];

        // Act: kirim request ke endpoint

        $response = $this->post(route('penjualan.store'), $data); // sesuaikan dengan route kamu

        // Assert: redirect berhasil
        $response->assertStatus(302);

        // Assert: cek data tersimpan di database
        $this->assertDatabaseHas('penjualan', [
            'user_id' => $user->id,
            'total_bayar' => $subtotal,
        ]);

        $this->assertDatabaseHas('detail_penjualan', [
            'buku_id' => $buku->id,
            'jumlah' => $jumlah,
            'harga_jual' => $buku->harga,
        ]);
    }
}
