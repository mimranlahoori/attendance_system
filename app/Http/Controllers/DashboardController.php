<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $classCount = Classroom::count();
        $studentCount = Student::count();
        $todayAttendanceCount = Attendance::whereDate('date', Carbon::today())->count();
        $pendingLeaves = LeaveRequest::where('status', 'pending')->count();

        $recentAttendances = Attendance::with('student')->latest()->take(5)->get();
        $upcomingHolidays = Holiday::where('date', '>=', Carbon::today())->orderBy('date')->take(5)->get();
        $recentLeaves = LeaveRequest::with('student')->latest()->take(5)->get();

        // 🧮 Top 5 Absent Students
        $topAbsents = Attendance::select('student_id', DB::raw('COUNT(*) as total_absents'))
            ->where('status', 'absent')
            ->groupBy('student_id')
            ->orderByDesc('total_absents')
            ->take(5)
            ->with('student')
            ->get();

        return view('dashboard', compact(
            'classCount',
            'studentCount',
            'todayAttendanceCount',
            'pendingLeaves',
            'recentAttendances',
            'upcomingHolidays',
            'recentLeaves',
            'topAbsents'
        ));
    }
}
