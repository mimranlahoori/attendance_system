<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'Class 6', 'section' => 'A'],
            ['name' => 'Class 7', 'section' => 'B'],
            ['name' => 'Class 8', 'section' => 'A'],
            ['name' => 'Class 9', 'section' => 'C'],
        ];

        foreach ($classes as $class) {
            Classroom::create($class);
        }
    }
}
