<?php

namespace Database\Seeders;

use App\Models\Pembelian;
use Faker\Provider\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Pembelian::truncate();
        Schema::enableForeignKeyConstraints();
        $file = File::get('database/data/smakzie/peserta_didik.json');
        $data = json_decode($file);
        foreach($data as $item) {
            Pembelian::create([
                'id' => $item->id
            ]);
        }
    }
}
