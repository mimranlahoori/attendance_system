<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classrooms = Classroom::all();

        foreach ($classrooms as $classroom) {
            for ($i = 1; $i <= 10; $i++) {
                Student::create([
                    'name' => 'Student ' . $i . ' - ' . $classroom->name,
                    'roll_number' => strtoupper($classroom->name[6]) . $i . rand(100, 999),
                    'classroom_id' => $classroom->id,
                ]);
            }
        }
    }
}
