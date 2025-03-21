<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerFactory;

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
        $faker = FakerFactory::create('id_ID');
        $kategori = DB::table('kategori')
            ->inRandomOrder()
            ->select('id')
            ->first();

        return [
            "isbn"          => $faker->unique()->isbn13(),
            "judul"         => $faker->sentence(1),
            "penulis"       => $faker->firstName() . ' ' . $faker->lastName(),
            "penerbit"      =>$faker->company(),
            "kategori_id"   => $kategori->id,
            "harga"         => $faker->numberBetween(30000, 200000),
            "thn_terbit"    => $faker->year(),
            "gambar" => $faker->randomElement([
                "20250320225904.jpg",
                "2025032022608.jpg",
                "2025032022831.jpg"
            ]),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
