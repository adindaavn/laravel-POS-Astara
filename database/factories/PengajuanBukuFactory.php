<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengajuanBuku>
 */
class PengajuanBukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $member = Member::factory()->create();

        return [
            'member_id' => $member->id,
            'nama_pengaju' => $member->nama,
            'no_telp' => $member->no_telp,
            'tgl' => $this->faker->date(),
            "judul"         => $this->faker->sentence(1),
            "penulis"       =>  $this->faker->firstName(),
            'qty' => $this->faker->numberBetween(1, 15),
            'status' => $this->faker->randomElement(['1','0']),
        ];
    }
}
