<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holidays = [
            ['title' => 'Pakistan Day', 'date' => '2025-03-23', 'type' => 'public', 'description' => 'National holiday'],
            ['title' => 'Eid ul Fitr', 'date' => '2025-04-10', 'type' => 'public', 'description' => 'Religious holiday'],
            ['title' => 'Sunday', 'date' => now()->startOfWeek()->addDays(6)->format('Y-m-d'), 'type' => 'weekend', 'description' => 'Weekly off'],
        ];

        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
