<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = \App\Models\Equipment::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word() . ' Device',
            'serialNumber' => strtoupper($this->faker->bothify('SN-#####')),
            'classroom_id' => \App\Models\Classroom::factory(),
            'model' => $this->faker->word(),
            'installationDate' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'lastMaintenanceDate' => $this->faker->dateTimeBetween('-2 year', 'now'),
            'status' => $this->faker->randomElement(['Pending', 'In progress', 'Completed']),
        ];
    }
}

