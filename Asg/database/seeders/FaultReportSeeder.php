<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaultReport;
use Faker\Factory as Faker;

class FaultReportSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Generate 10 faults per month for the last 12 months
        for ($i = 0; $i < 12; $i++) {
            $monthDate = now()->subMonths($i);

            for ($j = 0; $j < 10; $j++) {
                FaultReport::factory()->create([
                    'created_at' => $faker->dateTimeBetween(
                        $monthDate->copy()->startOfMonth(),
                        $monthDate->copy()->endOfMonth()
                    ),
                    'updated_at' => $faker->dateTimeBetween(
                        $monthDate->copy()->startOfMonth(),
                        $monthDate->copy()->endOfMonth()
                    ),
                ]);
            }
        }
    }
}
