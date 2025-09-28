<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FaultReport;
use App\Models\User;
use App\Models\Equipment;

class FaultReportFactory extends Factory
{
    protected $model = FaultReport::class;

    public function definition()
    {
        // Random student
        $student = User::where('role', 'student')->inRandomOrder()->first();

        // Random equipment
        $equipment = Equipment::inRandomOrder()->first() ?? Equipment::factory()->create();

        // Random technician (optional)
        $technician = User::where('role', 'technician')->inRandomOrder()->first();

        // Random creation date within last 12 months
        $createdAt = $this->faker->dateTimeBetween('-12 months', 'now');
        $updatedAt = $this->faker->dateTimeBetween($createdAt, 'now');

        return [
            'users_id'      => $student ? $student->id : null,
            'classroom_id'  => $equipment->classroom_id,
            'equipment_id'  => $equipment->id,
            'description'   => $this->faker->sentence(),
            'status'        => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'assigned_to'   => $technician ? $technician->id : null,
            'created_at'    => $createdAt,
            'updated_at'    => $updatedAt,
        ];
    }
}
