<x-app-layout>
<div class="container mx-auto p-4">


    <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-100">📚 {{ $class->name }} - Students</h1>
            <p class="text-gray-300">Section: {{ $class->section }}</p>
        <p class="text-gray-300">Total Students: {{ $class->students->count() }}</p>

            <a href="{{ route('classrooms.attendances.index', $class->id) }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                Attendance Students
            </a>
        </div>


    <div class="overflow-x-auto bg-gray-900 text-white rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-800">
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Student Name</th>
                    <th class="px-4 py-3 text-left">Roll No</th>
                    <th class="px-4 py-3 text-left">Class</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($class->students as $student)
                <tr class="bg-gray-700 hover:bg-gray-600 transition">
                    <td class="px-4 py-3">{{ $student->id }}</td>
                    <td class="px-4 py-3">{{ $student->name }}</td>
                    <td class="px-4 py-3">{{ $student->roll_number }}</td>
                    <td class="px-4 py-3">{{ $student->classroom->name }}</td>
                    <td class="px-6 py-4 flex space-x-3">
                        <a href="{{ route('students.attendances.studentAttendance', $student->id) }}" class="text-indigo-400 hover:text-indigo-600 transition">Show Attendance </a>
                        <a href="{{ route('students.show', $student->id) }}" class="text-blue-400 hover:text-blue-600 transition">View</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="text-yellow-400 hover:text-yellow-600 transition">Edit</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-300">No students found for this class.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
