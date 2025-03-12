<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kategori::factory()->createMany([
        //     ['nama' => 'Novel'],
        //     ['nama' => 'Komik'],
        //     ['nama' => 'Majalah'],
        //     ['nama' => 'Ensiklopedia'],
        //     ['nama' => 'Biografi'],
        //     ['nama' => 'Pelajaran'],
        //     ['nama' => 'Dongeng'],
        //     ['nama' => 'Sains'],
        //     ['nama' => 'Agama'],
        // ]);
        // Buku::factory()->count(50)->create();
        // User::factory()->create([
        //     'id' => '1',
        //     'name' => 'Sakai Moka',
        //     'username' => 'mokamoka',
        //     'password' => Hash::make('moka!'),
        //     'role' => 'owner',
        // ]);
        Pemasok::factory()->count(20)->create();
    }
}
