<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $today = Carbon::today();

        foreach ($students as $student) {
            Attendance::create([
                'student_id' => $student->id,
                'date' => $today,
                'status' => collect(['present', 'absent', 'late', 'leave'])->random(),
                'remarks' => 'Auto generated',
            ]);
        }
    }
}
