<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel:Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Fake();

        $tipe = $faker->randomElement(['persen', 'nominal']);
        if ($tipe == 'persen') {
            $diskon = $faker->numberBetween(5, 50);
            $max_diskon = $faker->randomElement([5000, 10000, 15000, 20000, 25000, 30000]);
        } else {
            $diskon = $faker->randomElement([1000, 5000, 10000, 15000, 20000, 25000, 30000]);
            $max_diskon = $diskon;
        }

        return [
            'diskon' =>  $diskon,
            'tipe' => $tipe,
            'min_beli' => $faker->randomElement([50000, 75000, 100000, 125000, 150000]),
            'max_diskon' => $max_diskon,
            'kuota' => $faker->optional()->numberBetween(1, 100),
            'point' => $faker->optional()->randomElement([100, 200, 300, 400]),
            'kadaluarsa' => $faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
