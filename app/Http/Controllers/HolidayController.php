<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Student;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    /**
     * Display a listing of the holidays.
     * Assuming simple authorization check.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $holidays = Holiday::orderBy('date', 'desc')->paginate(15);

        return view('holidays.index', compact('holidays'));
    }

    /**
     * Show the form for creating a new holiday.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('holidays.create');
    }

    /**
     * Store a newly created holiday and update all students' attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // 1. Validation for the Holiday record
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|unique:holidays,date',
            'type' => 'required|in:public,weekend,special,others',
            'description' => 'nullable|string|max:255',
        ]);

        // 2. Create the Holiday record
        $holiday = Holiday::create($request->all());

        // 3. Mark all students' attendance for the new holiday
        $this->markHolidayAttendance($holiday->date, $holiday->title);

        return redirect()->route('holidays.index')->with('success', 'Holiday added and attendance records successfully marked for all students.');
    }

    /**
     * Display the specified holiday.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday): View
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('holidays.show', compact('holiday'));
    }

    /**
     * Show the form for editing the specified holiday.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday): View
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified holiday in storage.
     * This handles date changes by re-syncing attendance records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Save the original date to check for changes
        $originalDate = $holiday->date;

        $request->validate([
            'title' => 'required|string|max:255',
            // Allow the date to be the same, but check uniqueness against other dates
            'date' => 'required|date|unique:holidays,date,' . $holiday->id,
            'type' => 'required|in:public,weekend,special,others',
            'description' => 'nullable|string|max:255',
        ]);

        $holiday->update($request->all());

        // Check if the date has been changed
        if ($originalDate !== $holiday->date) {
            // 1. Remove 'holiday' attendance records for the old date
            $this->unmarkHolidayAttendance($originalDate);

            // 2. Mark 'holiday' attendance records for the new date
            $this->markHolidayAttendance($holiday->date, $holiday->title);
        }

        // If the title changed, we don't worry about updating the 'note' in attendance
        // as the primary record is the Holiday model itself.

        return redirect()->route('holidays.index')->with('success', 'Holiday updated successfully.');
    }

    /**
     * Remove the specified holiday from storage and remove associated attendance records.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // 1. Remove 'holiday' attendance records for this date
        $this->unmarkHolidayAttendance($holiday->date);

        // 2. Delete the Holiday record
        $holiday->delete();

        return redirect()->route('holidays.index')->with('success', 'Holiday and associated attendance records deleted successfully.');
    }

    // --- Helper Methods for Attendance Synchronization ---

    /**
     * Helper to create 'holiday' attendance records for all students on a given date.
     *
     * @param string $date
     * @param string $title
     * @return void
     */
    private function markHolidayAttendance(string $date, string $title)
    {
        // Fetch all students
        $students = Student::all();

        // Loop through students and create 'holiday' attendance entries
        foreach ($students as $student) {
            // Use updateOrCreate to ensure only one entry exists for this student on this date.
            Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => $date,
                ],
                [
                    'status' => 'holiday',
                    'remarks' => 'Official Holiday: ' . $title,
                ]
            );
        }
    }

    /**
     * Helper to remove 'holiday' attendance records for all students on a given date.
     *
     * @param string $date
     * @return void
     */
    private function unmarkHolidayAttendance(string $date)
    {
        // Delete all attendance records where the status is 'holiday' for the given date
        Attendance::where('date', $date)
            ->where('status', 'holiday')
            ->delete();
    }
}
