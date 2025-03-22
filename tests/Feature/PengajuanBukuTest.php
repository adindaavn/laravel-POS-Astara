<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Member;
use App\Models\PengajuanBuku;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PengajuanBukuTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_create_pengajuan_buku()
    {
        $user = User::factory()->create(); // Kasir/Owner login
        $member = Member::factory()->create(); // Member yang request buku

        $response = $this->actingAs($user)->post(route('pengajuan.store'), [
            'member_id' => $member->id,
            'tgl'       => now()->format('Y-m-d'),
            'nama'      => 'Buku Testing Laravel',
            'qty'       => 2,
            'status'    => 0,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('pengajuan_barang', [
            'member_id' => $member->id,
            'nama'      => 'Buku Testing Laravel'
        ]);
    }

    public function test_user_can_update_status_pengajuan()
    {
        $user = User::factory()->create(); // Kasir/Owner login
        $member = Member::factory()->create();
        $pengajuan = PengajuanBuku::factory()->create(['member_id' => $member->id]);

        $response = $this->actingAs($user)->post(route('pengajuan.updateStatus'), [
            'id' => $pengajuan->id,
            'status' => '1'
        ]);

        $response->assertJson(['message' => 'Status berhasil diperbarui!']);
        $this->assertDatabaseHas('pengajuan_barang', ['id' => $pengajuan->id, 'status' => '1']);
    }

    public function test_user_can_delete_pengajuan()
    {
        $user = User::factory()->create(); 
        $member = Member::factory()->create();
        $pengajuan = PengajuanBuku::factory()->create(['member_id' => $member->id]);

        $response = $this->actingAs($user)->delete(route('pengajuan.destroy', $pengajuan->id));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('pengajuan_barang', ['id' => $pengajuan->id]);
    }
}
