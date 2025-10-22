<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Student Details</h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-gray-800 p-6 rounded-lg text-gray-100 space-y-2">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
            <p><strong>Classroom:</strong> {{ $student->classroom->name ?? '-' }}</p>
        </div>
        <div class="mt-4">
            <a href="{{ route('students.index') }}" class="text-blue-400 hover:underline">← Back to list - </a>
            <a href="{{ route('students.attendances.studentAttendance', $student->id) }}" class="text-indigo-400 hover:text-indigo-600 transition">Show Attendance </a>
        </div>
    </div>
</x-app-layout>
