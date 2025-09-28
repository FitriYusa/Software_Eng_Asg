<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // 4 fixed equipment
        $equipments = [
            [
                'classroom_id' => 1, // Main Block 101
                'name' => 'Projector',
                'model' => 'Epson X123',
                'serialNumber' => 'P101-001',              // ✅ match DB column
                'installationDate' => '2023-01-15',
                'lastMaintenanceDate' => '2024-06-10',      // ✅ match model field
                'status' => 'working',
            ],
            [
                'classroom_id' => 1, // Main Block 101
                'name' => 'Whiteboard',
                'model' => 'WB-200',
                'serialNumber' => 'WB101-001',
                'installationDate' => '2022-09-10',
                'lastMaintenanceDate' => '2024-05-01',
                'status' => 'working',
            ],
            [
                'classroom_id' => 3, // Science Block 201
                'name' => 'Computer',
                'model' => 'Dell Optiplex 7090',
                'serialNumber' => 'C201-001',
                'installationDate' => '2023-02-20',
                'lastMaintenanceDate' => '2024-07-15',
                'status' => 'working',
            ],
            [
                'classroom_id' => 3, // Science Block 201
                'name' => 'Microscope',
                'model' => 'Nikon LabScope',
                'serialNumber' => 'M201-001',
                'installationDate' => '2023-03-05',
                'lastMaintenanceDate' => '2024-08-01',
                'status' => 'working',
            ],
        ];

        // Insert the fixed equipment
        foreach ($equipments as $equipment) {
            Equipment::create($equipment);
        }

        // Add some random equipment (adjust count as you like)
        Equipment::factory()->count(2)->create();

    }
}
