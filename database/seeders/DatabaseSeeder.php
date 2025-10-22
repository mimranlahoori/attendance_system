<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $this->call([
            ClassroomSeeder::class,
            StudentSeeder::class,
            HolidaySeeder::class,
            LeaveRequestSeeder::class,
            AttendanceSeeder::class,
        ]);
    }
}
