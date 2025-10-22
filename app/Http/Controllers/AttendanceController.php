<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Holiday;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request, Classroom $classroom)
    {
        $month = $request->get('month', now()->format('Y-m')); // Default: current month
        $students = Student::with([
            'attendances' => function ($query) use ($month) {
                $query->where('date', 'like', "$month%");
            }
        ])->with('classroom')->get();

        // $month = $request->input('month', now()->format('Y-m')); // Default to current month
        $currentDate = now()->format('Y-m-d'); // Current date


        return view('attendances.index', compact('students', 'month', 'classroom', 'currentDate'));
    }

    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,leave,holiday',
            'remarks' => 'nullable|string|max:255',
        ]);

        Attendance::updateOrCreate(
            ['student_id' => $request->student_id, 'date' => $request->date],
            ['status' => $request->status, 'remarks' => $request->remarks]
        );

        return redirect()
            ->route('classrooms.attendances.index', $classroom->id)
            ->with('success', 'Attendance marked successfully.');

    }


    public function edit(Attendance $attendance)
    {
        $students = Student::all();
        return view('attendances.edit', compact('attendance', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,leave,holiday',
            'remarks' => 'nullable|string|max:255',
        ]);

        $attendance->update($request->all());
        return redirect()->route('attendances.index')->with('success', 'Attendance updated.');
    }

    /**
     * Display student attendance for a given month.
     * Logic is corrected to include 'leave' in the summary.
     */
    public function studentAttendance(Request $request, Student $student)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $daysInMonth = Carbon::parse($month)->daysInMonth;

        $startDate = $month . '-01';
        $endDate = $month . '-' . $daysInMonth;

        // Get list of holidays from DB
        $holidays = Holiday::whereBetween('date', [$startDate, $endDate])
            ->where('is_holiday', true)
            ->pluck('date')->toArray(); // Array of holiday dates

        // Calculate total possible working days (Mon-Fri, excluding holidays)
        $workingDays = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromFormat('Y-m-d', $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT));

            // Check if it's a weekday (Mon-Fri) and not a holiday
            if ($date->isWeekday() && !in_array($date->toDateString(), $holidays)) {
                $workingDays++;
            }
        }

        // Fetch attendances for the month
        $attendances = $student->attendances()
            ->whereBetween('date', [$startDate, $endDate]) // More robust than LIKE
            ->get();

        $present = $attendances->where('status', 'present')->count();
        $late = $attendances->where('status', 'late')->count();
        $leaveCount = $attendances->where('status', 'leave')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $holiday_count = count($holidays);

        // Build summary
        $summary = [
            'present' => $present,
            'late' => $late,
            'leave' => $leaveCount,
            'absent' => $absent, // Explicitly recorded absences
            'holiday_count' => $holiday_count,
            'working_days' => $workingDays, // Total possible days
            // Unaccounted Absences: Days that were working days but have no record (P, L, A, or Leave)
            'unaccounted_absences' => $workingDays - $present - $late - $leaveCount - $absent - $holiday_count,
            // Note: This 'unaccounted_absences' must be >= 0. If it's negative, your logic is flawed.
        ];

        return view('attendances.student_attendance', compact('student', 'attendances', 'month', 'summary'));
    }

    public function classAttendanceSheet(Request $request, Classroom $classroom)
    {
        // 1. Get the month, defaulting to the current month in 'Y-m' format.
        $month = $request->get('month', now()->format('Y-m'));

        // 2. Determine the start and end dates for the database query.
        // This is more robust than using a LIKE query.
        $startDate = \Carbon\Carbon::parse($month)->startOfMonth()->toDateString();
        $endDate = \Carbon\Carbon::parse($month)->endOfMonth()->toDateString();

        // 3. Eager load only the students belonging to the provided $classroom.
        // The original code was loading ALL students and then filtering by 'classroom' in the view,
        // which is inefficient if you only want students for a specific classroom.
        $classroom->load([
            'students.attendances' => function ($query) use ($startDate, $endDate) {
                // Use whereBetween for precise date filtering
                $query->whereBetween('date', [$startDate, $endDate]);
                // NOTE: The attendance model attribute should probably be 'attendance_date',
                // not 'date', based on the view code.
            }
        ]);

        // 4. Extract the students from the loaded classroom object
        $students = $classroom->students;

        // 5. Fetch the holidays for the current month
        // This is needed for the view logic to correctly identify non-working days.
        $holidays = \App\Models\Holiday::whereBetween('date', [$startDate, $endDate])
            ->where('is_holiday', true)
            ->pluck('date'); // Get an array of holiday dates

        // 6. Current date is useful for the view (e.g., highlighting today)
        $currentDate = now()->format('Y-m-d');

        // Return the view with the required data
        return view('attendances.class_attendance_sheet', compact('students', 'month', 'classroom', 'currentDate', 'holidays'));
    }

           /**
     * Delete a single attendance record by ID.
     */
    public function destroyAttendance(Attendance $attendance)
    {
        // Authorization check: Only admin/supervisor can delete attendance records
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'supervisor')) {
             abort(403, 'You do not have permission to delete attendance records.');
        }

        $studentId = $attendance->student_id;
        $attendance->delete();

        // Redirect back to the student's attendance page
        // Assumes route is named 'students.attendance' and takes the student ID as a parameter
        return redirect()->route('students.attendances.studentAttendance', $studentId)
                         ->with('success', 'Attendance record deleted successfully.');
    }
}
