<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = DB::table('kategori')
            ->inRandomOrder()
            ->select('id')
            ->first();

        return [
            "isbn"          => fake()->unique()->isbn13(),
            "judul"         => fake()->sentence(2),
            "penulis"       => fake()->name(),
            "penerbit"      => fake()->company(),
            "kategori_id"   => $kategori->id,
            "harga"         => fake()->numberBetween(30000, 200000),
            "thn_terbit"    => fake()->year(),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
