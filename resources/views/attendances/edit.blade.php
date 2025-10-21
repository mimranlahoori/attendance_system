<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h2 class="text-2xl font-bold text-white mb-6">Edit Attendance</h2>

        <form method="POST" action="{{ route('attendances.update', $attendance->id) }}" class="bg-gray-800 p-6 rounded-xl space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-300 mb-1">Student</label>
                <select name="student_id" class="w-full p-2 rounded bg-gray-700 text-white">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} ({{ $student->classroom->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Date</label>
                <input type="date" name="date" class="w-full p-2 rounded bg-gray-700 text-white" value="{{ $attendance->date }}">
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Status</label>
                <select name="status" class="w-full p-2 rounded bg-gray-700 text-white">
                    <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                    <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                    <option value="leave" {{ $attendance->status == 'leave' ? 'selected' : '' }}>Leave</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-300 mb-1">Remarks</label>
                <textarea name="remarks" rows="3" class="w-full p-2 rounded bg-gray-700 text-white">{{ $attendance->remarks }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Update Attendance
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
