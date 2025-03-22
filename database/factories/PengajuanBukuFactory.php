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
        return [
            'member_id' => Member::factory()->create()->id,
            'tgl' => $this->faker->date(),
            'nama' => $this->faker->word(),
            'qty' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(['1','0']),
        ];
    }
}
