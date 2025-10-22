<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
public function index(Request $request)
    {
        $search = $request->input('search');
        $sectionFilter = $request->input('section');

        $query = Classroom::query();
        $allSection = Classroom::all('section');

        // Apply search filter
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('section', 'like', '%' . $search . '%');
        }

        // Apply section filter if provided
        if ($sectionFilter) {
            $query->where('section', $sectionFilter);
        }

        $classrooms = $query->paginate(10); // Paginate with 10 items per page

        return view('classrooms.index', compact('classrooms', 'search', 'sectionFilter', 'allSection'));
    }
    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
        ]);

        Classroom::create($request->only(['name', 'section']));
        return redirect()->route('classrooms.index')->with('success', 'Classroom added successfully.');
    }

        /**
     * Display the specified resource.
     */
    public function show($classes)
    {
        $class = Classroom::with('students')->findOrFail($classes);
        return view('classrooms.show', compact('class'));
    }
    public function edit($classes)
    {
        $classroom = Classroom::with('students')->findOrFail($classes);
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
        ]);

        $classroom->update($request->only(['name', 'section']));
        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted.');
    }
}
