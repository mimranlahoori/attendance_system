<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Student;
use Illuminate\Http\Request;

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

    public function edit(LeaveRequest $leaf)
    {
        $students = Student::all();
        return view('leaves.edit', compact('leaf', 'students'));
    }

    public function update(Request $request, LeaveRequest $leave)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $leave->update($request->only(['status']));
        return redirect()->route('leaves.index')->with('success', 'Leave request updated.');
    }

    public function destroy(LeaveRequest $leave)
    {
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave request deleted.');
    }
}
