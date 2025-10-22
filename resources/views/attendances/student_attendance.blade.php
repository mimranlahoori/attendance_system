<x-app-layout><x-slot name="header"><h2 class="font-semibold text-xl text-gray-200">Attendance Summary</h2></x-slot><div class="container mx-auto p-4">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-100">📚 Attendance Summary - {{ $student->name }} ({{ $month }})
        </h1>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="bg-green-600 p-3 rounded-lg text-white mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-xl text-center">
            <h3 class="text-md font-semibold text-green-400">✅ Present</h3>
            <p class="text-3xl mt-2 font-extrabold">{{ $summary['present'] }}</p>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-xl text-center">
            <h3 class="text-md font-semibold text-yellow-400">⏰ Late</h3>
            <p class="text-3xl mt-2 font-extrabold">{{ $summary['late'] }}</p>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-xl text-center">
            <h3 class="text-md font-semibold text-red-400">❌ Absent (Recorded)</h3>
            <p class="text-3xl mt-2 font-extrabold">{{ $summary['absent'] }}</p>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-xl text-center">
            <h3 class="text-md font-semibold text-blue-400">📘 Leave</h3>
            <p class="text-3xl mt-2 font-extrabold">{{ $summary['leave'] }}</p>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-xl text-center">
            <h3 class="text-md font-semibold text-gray-400">🏖 Holidays</h3>
            <p class="text-3xl mt-2 font-extrabold">{{ $summary['holiday_count'] }}</p>
        </div>

        <div class="bg-gray-800 text-white p-4 rounded-lg shadow-xl text-center border-2 border-red-500">
            <h3 class="text-md font-semibold text-red-500">🔥 Unaccounted Absences</h3>
            <p class="text-3xl mt-2 font-extrabold">{{ $summary['unaccounted_absences'] }}</p>
        </div>
    </div>


    <div class="overflow-x-auto bg-gray-900 text-white rounded-lg shadow-md">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-800">
                    <th class="px-4 py-3 text-left w-1/12">#</th>
                    <th class="px-4 py-3 text-left w-3/12">Date</th>
                    <th class="px-4 py-3 text-left w-4/12">Status</th>
                    <th class="px-4 py-3 text-left w-4/12">Actions</th> {{-- New Column --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $attendance)
                    {{-- Only showing non-'present' records in the list, as per original logic --}}
                    @if ($attendance->status !== 'present')
                        <tr class="bg-gray-700 hover:bg-gray-600 transition border-t border-gray-600">
                            <td class="px-4 py-3">{{ $attendance->id }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-sm rounded-full
                                    @if($attendance->status == 'leave') bg-blue-500 text-white
                                    @elseif($attendance->status == 'late') bg-yellow-500 text-gray-900
                                    @elseif($attendance->status == 'absent') bg-red-500 text-white
                                    @endif">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>

                            {{-- Actions Column with Delete Button (Visible only to Admin/Supervisor) --}}
                            <td class="px-4 py-3">
                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor')
                                    {{-- Delete Form (Requires `attendances.destroy` route) --}}
                                    <form action="{{ route('attendances.destroy', $attendance) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded-md transition shadow-md">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-300">No non-present attendance records found for this student this month.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
