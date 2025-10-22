<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holidaysData = [
            // Public Holidays (Type: public) - Allowed in ENUM
            [
                'title' => 'Pakistan Day',
                'date' => '2025-03-23',
                'type' => 'public',
                'description' => 'National holiday in Pakistan.',
                'is_holiday' => true,
            ],
            [
                'title' => 'Eid ul Fitr',
                'date' => '2025-04-10',
                'type' => 'public',
                'description' => 'Religious holiday marking the end of Ramadan.',
                'is_holiday' => true,
            ],
            // Weekend/Special/Others Days (Modified to fit ENUM)
            [
                // Dynamically finds the next Sunday for testing purposes
                // Type changed from 'other' to 'others' (to match ENUM) or 'weekend'
                'title' => 'Weekly Off (Sunday)',
                'date' => Carbon::now()->next(Carbon::SUNDAY)->format('Y-m-d'),
                'type' => 'weekend', // Using 'weekend' from your schema
                'description' => 'A dynamic test entry for a weekly off.',
                'is_holiday' => true,
            ],
            [
                'title' => 'Teacher Training Day',
                'date' => '2025-01-20',
                'type' => 'special', // Using 'special' from your schema
                'description' => 'School-specific closure for staff training.',
                'is_holiday' => true,
            ],
        ];

        // Fetch all students once outside the loop for efficiency
        $students = Student::all();

        foreach ($holidaysData as $holidayData) {
            // 1. Create the official Holiday record
            $holiday = Holiday::create($holidayData);

            // 2. Create 'holiday' attendance records for all students for this day
            if ($holiday->is_holiday) {
                foreach ($students as $student) {
                    Attendance::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'date' => $holiday->date,
                        ],
                        [
                            'status' => 'holiday',
                            'remarks' => $holiday->title,
                        ]
                    );
                }
            }
        }
    }
}
