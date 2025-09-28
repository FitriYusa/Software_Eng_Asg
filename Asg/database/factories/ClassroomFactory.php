<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    protected $model = \App\Models\Classroom::class;

    public function definition(): array
    {
        return [
            'building' => 'Building ' . $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'floor' => $this->faker->numberBetween(1, 5),
            'roomNumber' => $this->faker->unique()->numberBetween(100, 499),
            'capacity' => $this->faker->numberBetween(20, 100),
        ];
    }
}
