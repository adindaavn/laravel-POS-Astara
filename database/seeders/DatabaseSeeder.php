<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
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
        $this->call(KategoriSeeder::class);
        $this->call(PemasokSeeder::class);

        User::factory()->create([
            'id'       => '1',
            'name'     => 'Sakai Moka',
            'username' => 'moka',
            'password' => Hash::make('moka!'),
            'role'     => 'owner',
        ]);

        User::factory()->create([
            'id'       => '2',
            'name'     => 'Naoi Rei',
            'username' => 'rei',
            'password' => Hash::make('naoi'),
            'role'     => 'kasir',
        ]);

        User::factory()->create([
            'id'       => '3',
            'name'     => 'Hanni Pham',
            'username' => 'hanni',
            'password' => Hash::make('pham:3'),
            'role'     => 'admin',
        ]);

        Buku::factory()->count(30)->create();
        Member::factory()->count(10)->create();
    }
}
