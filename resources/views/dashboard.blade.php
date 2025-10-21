<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <h2 class="text-3xl font-bold text-white mb-8">📊 School Management Dashboard</h2>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg text-center">
                <h3 class="text-gray-400 text-sm mb-2">Total Classes</h3>
                <p class="text-3xl font-bold text-blue-400">{{ $classCount }}</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg text-center">
                <h3 class="text-gray-400 text-sm mb-2">Total Students</h3>
                <p class="text-3xl font-bold text-green-400">{{ $studentCount }}</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg text-center">
                <h3 class="text-gray-400 text-sm mb-2">Today’s Attendance</h3>
                <p class="text-3xl font-bold text-yellow-400">{{ $todayAttendanceCount }}</p>
            </div>

            <div class="bg-gray-800 p-6 rounded-2xl shadow-lg text-center">
                <h3 class="text-gray-400 text-sm mb-2">Pending Leave Requests</h3>
                <p class="text-3xl font-bold text-red-400">{{ $pendingLeaves }}</p>
            </div>
        </div>

        {{-- Latest Records --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Attendance --}}
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-white mb-4">📅 Recent Attendance</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-300">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-2 px-3">Student</th>
                                <th class="text-left py-2 px-3">Date</th>
                                <th class="text-left py-2 px-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentAttendances as $att)
                                <tr class="border-b border-gray-700">
                                    <td class="py-2 px-3">{{ $att->student->name }}</td>
                                    <td class="py-2 px-3">{{ $att->date }}</td>
                                    <td class="py-2 px-3">
                                        @if($att->status == 'present')
                                            <span class="text-green-400 font-semibold">Present</span>
                                        @elseif($att->status == 'absent')
                                            <span class="text-red-400 font-semibold">Absent</span>
                                        @else
                                            <span class="text-yellow-400 font-semibold">Leave</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-3 text-center text-gray-500">No recent attendance records.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Upcoming Holidays --}}
            <div class="bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-semibold text-white mb-4">🎉 Upcoming Holidays</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-300">
                        <thead>
                            <tr class="border-b border-gray-700">
                                <th class="text-left py-2 px-3">Title</th>
                                <th class="text-left py-2 px-3">Date</th>
                                <th class="text-left py-2 px-3">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($upcomingHolidays as $holiday)
                                <tr class="border-b border-gray-700">
                                    <td class="py-2 px-3">{{ $holiday->title }}</td>
                                    <td class="py-2 px-3">{{ $holiday->date }}</td>
                                    <td class="py-2 px-3">{{ ucfirst($holiday->type) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-3 text-center text-gray-500">No upcoming holidays.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Leave Requests --}}
        <div class="bg-gray-800 mt-10 rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-white mb-4">📝 Recent Leave Requests</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-300">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-2 px-3">Student</th>
                            <th class="text-left py-2 px-3">From</th>
                            <th class="text-left py-2 px-3">To</th>
                            <th class="text-left py-2 px-3">Reason</th>
                            <th class="text-left py-2 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentLeaves as $leave)
                            <tr class="border-b border-gray-700">
                                <td class="py-2 px-3">{{ $leave->student->name }}</td>
                                <td class="py-2 px-3">{{ $leave->from_date }}</td>
                                <td class="py-2 px-3">{{ $leave->to_date }}</td>
                                <td class="py-2 px-3">{{ $leave->reason_type }}</td>
                                <td class="py-2 px-3">
                                    @if($leave->status == 'approved')
                                        <span class="text-green-400 font-semibold">Approved</span>
                                    @elseif($leave->status == 'rejected')
                                        <span class="text-red-400 font-semibold">Rejected</span>
                                    @else
                                        <span class="text-yellow-400 font-semibold">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-3 text-center text-gray-500">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Top Absent Students --}}
        <div class="bg-gray-800 mt-10 rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-white mb-4">🚫 Top Absent Students</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-300">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="text-left py-2 px-3">#</th>
                            <th class="text-left py-2 px-3">Student</th>
                            <th class="text-left py-2 px-3">Class</th>
                            <th class="text-left py-2 px-3">Total Absents</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topAbsents as $index => $absent)
                            <tr class="border-b border-gray-700">
                                <td class="py-2 px-3">{{ $index + 1 }}</td>
                                <td class="py-2 px-3">{{ $absent->student->name }}</td>
                                <td class="py-2 px-3">{{ $absent->student->classroom->name ?? '-' }}</td>
                                <td class="py-2 px-3 text-red-400 font-semibold">{{ $absent->total_absents }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 text-center text-gray-500">No absents recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
