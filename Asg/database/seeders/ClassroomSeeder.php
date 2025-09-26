<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $classrooms = [
            [
                'building' => 'Main Block',
                'floor' => '1',
                'roomNumber' => '101',
                'capacity' => 30,
                'description' => 'Standard classroom with projector and whiteboard.',
            ],
            [
                'building' => 'Main Block',
                'floor' => '1',
                'roomNumber' => '102',
                'capacity' => 25,
                'description' => 'Classroom near admin office.',
            ],
            [
                'building' => 'Science Block',
                'floor' => '2',
                'roomNumber' => '201',
                'capacity' => 20,
                'description' => 'Lab room with computers and microscopes.',
            ],
            [
                'building' => 'Science Block',
                'floor' => '2',
                'roomNumber' => '202',
                'capacity' => 20,
                'description' => 'Physics lab room.',
            ],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::create($classroom);
        }
    }
}
