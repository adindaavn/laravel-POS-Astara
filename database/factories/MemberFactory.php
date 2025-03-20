<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('id_ID');
        return [
            "nama"      => $faker->firstName() . ' ' . $faker->lastName(),
            "point"      => $faker->numberBetween(0, 500),
            "email"     => $faker->safeEmail(),
            "telp"      => $faker->phoneNumber(),
            "alamat"    => $faker->address(),
        ];
    }
}
