<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::inRandomOrder()->take(5)->get();

        foreach ($students as $student) {
            LeaveRequest::create([
                'student_id' => $student->id,
                'from_date' => now()->subDays(rand(1, 5))->format('Y-m-d'),
                'to_date' => now()->addDays(rand(1, 3))->format('Y-m-d'),
                'reason_type' => 'sick',
                'reason' => 'Fever and rest',
                'status' => 'approved',
            ]);
        }
    }
}
