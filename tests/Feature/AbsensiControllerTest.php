<?php

namespace Tests\Feature;

use App\Models\Absensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AbsensiControllerTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testStoreValidationError()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => 0,
            'jam_masuk' => '09:09',
            'jam_selesai' => 'SELESAI',
            'status' => '1',
        ];

        $response = $this->post('absensi', $invalidData);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('absensi', $invalidData);
    }

    public function testStoreSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => '2025-04-16',
            'jam_masuk' => '09:09',
            'jam_selesai' => '15:09',
            'status' => 'masuk',
        ];

        $response = $this->post('/absensi', $data);
        $response->assertStatus(302);
        $response->assertRedirect();

        $this->assertDatabaseHas('absensi', $data);
    }

    public function testUpdateSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $absensi = Absensi::create([
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => '2025-04-16',
            'jam_masuk' => '09:09',
            'jam_selesai' => '15:09',
            'status' => 'masuk',
        ]);

        $update = [
            'id' => $absensi->id,
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => '2025-04-16',
            'jam_masuk' => '09:09',
            'jam_selesai' => '15:09',
            'status' => 'masuk',
        ];

        $response = $this->put(route('absensi.update', $absensi->id), $update);
        $response->assertStatus(302);
        $response->assertRedirect();

        $this->assertDatabaseHas('absensi', $update);
    }

    public function testDeleteSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $absensi = Absensi::create([
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => '2025-04-16',
            'jam_masuk' => '09:09',
            'jam_selesai' => '15:09',
            'status' => 'masuk',
        ]);

        $data = [
            'id' => $absensi->id
        ];

        $response = $this->delete(route('absensi.destroy', $absensi->id), $data);
        $response->assertStatus(302);
        $response->assertRedirect();

        $this->assertDatabaseMissing('absensi', $data);
    }

    public function testUpdateStatus()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $absensi = Absensi::create([
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => '2025-04-16',
            'jam_masuk' => '09:09',
            'jam_selesai' => '15:09',
            'status' => 'masuk',
        ]);

        $data = [
            'id'    => $absensi->id,
            'status' => 'cuti'
        ];

        $response = $this->post(route('absensi.updateStatus', $data));
        $response->assertStatus(200);

        $this->assertDatabaseHas('absensi', $data);
    }

    public function testSelesaiKerja()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $absensi = Absensi::create([
            'nama_karyawan' => 'Hanni',
            'tgl_masuk' => '2025-04-16',
            'jam_masuk' => '09:09',
            'jam_selesai' => '15:09',
            'status' => 'masuk',
        ]);

        $data = [
            'id' => $absensi->id
        ];

        $response = $this->post(route('absensi.selesaiKerja', $data));
        $response->assertStatus(200);

        $this->assertDatabaseHas('absensi', $data);
    }
}
