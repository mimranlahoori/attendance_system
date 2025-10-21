<x-app-layout>
    <div class="max-w-6xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Attendances</h2>
            <a href="{{ route('attendances.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Mark Attendance
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-800 p-4 rounded-xl">
            <table class="min-w-full text-sm text-gray-300">
                <thead>
                    <tr class="text-left border-b border-gray-700">
                        <th class="py-2 px-3">#</th>
                        <th class="py-2 px-3">Student</th>
                        <th class="py-2 px-3">Date</th>
                        <th class="py-2 px-3">Status</th>
                        <th class="py-2 px-3">Remarks</th>
                        <th class="py-2 px-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr class="border-b border-gray-700">
                            <td class="py-2 px-3">{{ $loop->iteration }}</td>
                            <td class="py-2 px-3">{{ $attendance->student->name }}</td>
                            <td class="py-2 px-3">{{ $attendance->date }}</td>
                            <td class="py-2 px-3">
                                @if($attendance->status == 'present')
                                    <span class="text-green-400 font-semibold">Present</span>
                                @elseif($attendance->status == 'absent')
                                    <span class="text-red-400 font-semibold">Absent</span>
                                @else
                                    <span class="text-yellow-400 font-semibold">Leave</span>
                                @endif
                            </td>
                            <td class="py-2 px-3">{{ $attendance->remarks }}</td>
                            <td class="py-2 px-3 text-right">
                                <a href="{{ route('attendances.edit', $attendance->id) }}" class="text-blue-400 hover:text-blue-300 mr-3">Edit</a>
                                <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Delete this attendance?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
