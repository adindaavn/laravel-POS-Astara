<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KategoriControllerTest extends TestCase
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
            'id' => '',
            'nama' => 'daatasalah'
        ];

        $response = $this->post('kategori', $invalidData);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('kategori', $invalidData);
    }

    public function testStoreSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'nama' => 'test kategori'
        ];

        $response = $this->post('/kategori', $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseHas('kategori', $data);
    }

    public function testUpdateSuccessfully()
    {
        $user = User::factory()->create();
        $kategori = Kategori::factory()->create();
        $this->actingAs($user);

        $data = [
            'id' => $kategori->id,
            'nama' => 'test kategori'
        ];

        $response = $this->put(route('kategori.update', $kategori->id), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseHas('kategori', $data);
    }

    public function testDeleteSuccessfully()
    {
        $user = User::factory()->create();
        $kategori = Kategori::factory()->create();
        $this->actingAs($user);

        $data = [
            'id' => $kategori->id
        ];

        $response = $this->delete(route('kategori.destroy', $kategori->id), $data);
        $response->assertStatus(302);
        $response->assertRedirect(route('kategori.index'));
        $this->assertDatabaseMissing('kategori', $data);
    }
}
