<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Student;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('student.classroom')->latest()->paginate(10);
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $students = Student::all();
        return view('leaves.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'reason_type' => 'required|in:sick,personal,emergency,other',
            'reason' => 'nullable|string|max:255',
        ]);

        LeaveRequest::create($request->all());
        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }

    public function show(LeaveRequest $leaf)
    {
        $students = Student::all();
        return view('leaves.show', compact('leaf', 'students'));
    }
    public function edit(LeaveRequest $leaf)
    {
        $students = Student::all();
        return view('leaves.edit', compact('leaf', 'students'));
    }

    /**
 * Handle a generic update for a leave request, typically via a PUT/PATCH route.
 * This method includes crucial authorization checks for status changes and general edits.
 */
public function update(Request $request, LeaveRequest $leaf)
{
    // --- Authorization Check (CRITICAL FIX) ---
    // Only admin or supervisor should be able to update the leave.
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'supervisor')) {
         // Deny access if the user is not authorized
         abort(403, 'You do not have permission to modify leave request details.');
    }

    // --- Validation ---
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'from_date' => 'required|date|before_or_equal:to_date', // Ensure start date is before or equal to end date
        'to_date' => 'required|date|after_or_equal:from_date',
        'reason_type' => 'required|in:sick,personal,emergency,other',
        'reason' => 'required|string|max:500',
    ]);

    // --- Update ---
    // Gather all validated data.
    $validatedData = $request->only(['student_id', 'from_date', 'to_date', 'reason_type', 'reason']);

    // Filter out 'status' if it wasn't provided by the form to avoid unnecessary updates
    if (!$request->has('status')) {
        unset($validatedData['status']);
    }

    $leaf->update($validatedData);
    $leaf->update(['status' => 'pending']);

    return redirect()->route('leaves.index')->with('success', 'Leave request successfully updated.');
}


    public function destroy(LeaveRequest $leaf)
    {
        $leaf->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave request deleted.');
    }


    /**
     * Approve the specified leave request.
     */
    public function approve(LeaveRequest $leaf)
    {
        // Basic authorization check based on the view logic
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'supervisor')) {
            // You should typically use a Middleware or Policy for this
            abort(403, 'Unauthorized action.');
        }

        if ($leaf->status !== 'pending') {
            return back()->with('error', 'This leave request has already been ' . $leaf->status . '.');
        }

        // Update the status
        $leaf->update(['status' => 'approved']);
        $this->createAttendanceRecords($leaf);

        // Redirect back to the index with a success message
        return redirect()->route('leaves.index')->with('success', 'Leave request approved successfully.');
    }

    /**
     * Reject the specified leave request.
     */
    public function reject(LeaveRequest $leaf)
    {
        // Basic authorization check based on the view logic
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'supervisor')) {
            // You should typically use a Middleware or Policy for this
            abort(403, 'Unauthorized action.');
        }

        if ($leaf->status !== 'pending') {
            return back()->with('error', 'This leave request has already been ' . $leaf->status . '.');
        }

        // Update the status
        $leaf->update(['status' => 'rejected']);
        $this->deleteAttendanceRecords($leaf);

        // Redirect back to the index with a success message
        return redirect()->route('leaves.index')->with('success', 'Leave request rejected successfully.');
    }

     /**
     * Helper to create 'leave' attendance records for the date range.
     */
    private function createAttendanceRecords(LeaveRequest $leaf)
    {
        $period = CarbonPeriod::create($leaf->from_date, $leaf->to_date);

        foreach ($period as $date) {
            // We only create records for days that are NOT weekends (Mon-Fri)
            if ($date->isWeekday()) {
                // Use updateOrCreate to prevent duplicates if manually run multiple times
                Attendance::updateOrCreate(
                    [
                        'student_id' => $leaf->student_id,
                        'date' => $date->format('Y-m-d'),
                    ],
                    [
                        'status' => 'leave',
                        'note' => 'Approved Leave: ' . $leaf->reason_type,
                    ]
                );
            }
        }
    }

    /**
     * Helper to delete 'leave' attendance records for the date range.
     */
    private function deleteAttendanceRecords(LeaveRequest $leaf)
    {
        $period = CarbonPeriod::create($leaf->from_date, $leaf->to_date);
        $dates = collect($period)->map(fn ($date) => $date->format('Y-m-d'))->toArray();

        Attendance::where('student_id', $leaf->student_id)
            ->whereIn('date', $dates)
            ->where('status', 'leave')
            ->delete();
    }


}
