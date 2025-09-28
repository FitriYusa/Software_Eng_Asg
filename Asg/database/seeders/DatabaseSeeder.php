<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
// DatabaseSeeder.php
public function run()
{
    $this->call(UserSeeder::class);
    $this->call(ClassroomSeeder::class);
    
    $this->call(EquipmentSeeder::class);

    // // Create additional random users
    // \App\Models\User::factory(10)->create();
    // \App\Models\User::factory(5)->create(['role' => 'technician']);


        User::factory(10)->create(['role' => 'student']);
    User::factory(5)->create(['role' => 'technician']);
    $this->call(FaultReportSeeder::class);
    // Use existing equipments to seed faults
    $equipments = \App\Models\Equipment::all();

    $equipments->each(function ($equipment) {
        \App\Models\FaultReport::factory(5)->create([
            'equipment_id' => $equipment->id,
            'classroom_id' => $equipment->classroom_id,
        ]);
    });
}

}
